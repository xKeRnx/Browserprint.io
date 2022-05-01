using SharpCompress.Archives;
using SharpCompress.Archives.Rar;
using SharpCompress.Common;
using SharpCompress.Readers;
using System;
using System.Collections.Generic;
using System.IO;
using System.IO.Compression;
using System.Linq;
using System.Net;
using System.Security.AccessControl;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace BrowserPrint_Updater
{
    class Program
    {
        static string timeNow;
        static string udger_key = "";
        static string download_dir = Directory.GetCurrentDirectory();
        static string backup_dir = Directory.GetCurrentDirectory() + "\\backup\\";
        static string move_dir = @"C:\\inetpub";
        static string x86folder = Environment.GetEnvironmentVariable("ProgramFiles(x86)");
        static string x64folder = Environment.GetEnvironmentVariable("ProgramW6432");
        static string iis_dir = x64folder + "\\PHP\\v7.4";
        static bool can_download = false;

        public static void EveryDay()
        {
            while (true)
            {
                can_download = false;
                timeNow = DateTime.Now.ToString("yyyy-MM-dd - HH:mm:ss");
                udger_downloadFile();
                Maxmind_downloadFile();
                IP2Location_downloadFile();
                IP2Proxy_downloadFile();
                geoip_downloadFileAsync().Wait();
                Write("Waiting 24hours for next Update...", ConsoleColor.Blue);
                Write("");
                can_download = true;
                Thread.Sleep(86400000);
            }
        }

        public static void EveryHour()
        {
            while (true)
            {
                if (can_download == true) {
                    timeNow = DateTime.Now.ToString("yyyy-MM-dd - HH:mm:ss");
                    torlist_download();
                    torexitlist_download();
                    Write("Waiting 60 minutes for next Update...", ConsoleColor.Blue);
                    Write("");
                    Thread.Sleep(3600000);
                }
            }
        }

        static void Main(string[] args)
        {
            if (!Directory.Exists("backup"))
            {
                Directory.CreateDirectory("backup");
            }
            Thread EveryDay_Thread = new Thread(EveryDay);
            Thread EveryHours_Thread = new Thread(EveryHour);
            EveryHours_Thread.Start();
            EveryDay_Thread.Start();
        }

        static void torlist_download()
        {
            Write("Start Torlist Download " + timeNow, ConsoleColor.Yellow);
            string baseUrl = @"https://raw.githubusercontent.com/SecOps-Institute/Tor-IP-Addresses/master/tor-nodes.lst";
            string filename = "torlist.txt";

            if (File.Exists(download_dir + "\\" + filename))
            {
                File.Delete(download_dir + "\\" + filename);
            }

            using (WebClient myWebClient = new WebClient())
            {
                try
                {
                    Write("Downloading file: " + filename + " ...", ConsoleColor.White, false);
                    myWebClient.DownloadFile(new Uri(baseUrl), download_dir + "\\" + filename);

                    Write("... Done\n", ConsoleColor.Green, false);
                    myWebClient.Dispose();
                    if (File.Exists(download_dir + "\\" + filename))
                    {
                        long length = new FileInfo(download_dir + "\\" + filename).Length;
                        if (length > 0) {
                            if (File.Exists(move_dir + "\\" + filename))
                            {
                                File.Delete(move_dir + "\\" + filename);
                            }
                            File.Move(download_dir + "\\" + filename, move_dir + "\\" + filename);
                            Write(filename + " renamed and moved... new name: " + filename, ConsoleColor.Green);
                            AddFileSecurity(move_dir + "\\" + filename, @"IUSR", FileSystemRights.FullControl, AccessControlType.Allow);
                        }
                        else
                        {
                            Write("Tor node list is empty..\n", ConsoleColor.Red, false);
                        }
                    }
                }
                catch (WebException e)
                {
                    Write("\nError: " + e.Message, ConsoleColor.Red);
                }
            }
        }

        static void torexitlist_download()
        {
            Write("Start Torexitlist Download " + timeNow, ConsoleColor.Yellow);
            string baseUrl = @"https://raw.githubusercontent.com/SecOps-Institute/Tor-IP-Addresses/master/tor-exit-nodes.lst";
            string filename = "torexitlist.txt";

            if (File.Exists(download_dir + "\\" + filename))
            {
                File.Delete(download_dir + "\\" + filename);
            }

            using (WebClient myWebClient = new WebClient())
            {
                try
                {
                    Write("Downloading file: " + filename + " ...", ConsoleColor.White, false);
                    myWebClient.DownloadFile(new Uri(baseUrl), download_dir + "\\" + filename);

                    Write("... Done\n", ConsoleColor.Green, false);
                    myWebClient.Dispose();
                    if (File.Exists(download_dir + "\\" + filename))
                    {
                        long length = new FileInfo(download_dir + "\\" + filename).Length;
                        if (length > 0)
                        {
                            if (File.Exists(move_dir + "\\" + filename))
                            {
                                File.Delete(move_dir + "\\" + filename);
                            }
                            File.Move(download_dir + "\\" + filename, move_dir + "\\" + filename);
                            Write(filename + " renamed and moved... new name: " + filename, ConsoleColor.Green);
                            AddFileSecurity(move_dir + "\\" + filename, @"IUSR", FileSystemRights.FullControl, AccessControlType.Allow);
                        }
                        else
                        {
                            if (File.Exists(download_dir + "\\" + filename))
                            {
                                File.Delete(download_dir + "\\" + filename);
                            }
                            baseUrl = @"https://check.torproject.org/torbulkexitlist";
                            Write("Tor exit node list from Git is empty\n", ConsoleColor.Red, false);
                            Write("Try downloading exit nodes from torproject: " + filename + " ...", ConsoleColor.White, false);
                            myWebClient.DownloadFile(new Uri(baseUrl), download_dir + "\\" + filename);

                            Write("... Done\n", ConsoleColor.Green, false);
                            myWebClient.Dispose();
                            if (File.Exists(download_dir + "\\" + filename))
                            {
                                length = new FileInfo(download_dir + "\\" + filename).Length;
                                if (length > 0)
                                {
                                    if (File.Exists(move_dir + "\\" + filename))
                                    {
                                        File.Delete(move_dir + "\\" + filename);
                                    }
                                    File.Move(download_dir + "\\" + filename, move_dir + "\\" + filename);
                                    Write(filename + " renamed and moved... new name: " + filename, ConsoleColor.Green);
                                    AddFileSecurity(move_dir + "\\" + filename, @"IUSR", FileSystemRights.FullControl, AccessControlType.Allow);
                                }
                                else
                                {
                                    Write("Tor exit node list is empty..\n", ConsoleColor.Red, false);
                                }
                            }
                        }
                    }
                }
                catch (WebException e)
                {
                    Write("\nError: " + e.Message, ConsoleColor.Red);
                }
            }
        }

        static void udger_downloadFile()
        {
            Write("Start Udger Download " + timeNow, ConsoleColor.Yellow);
            string baseUrl = @"http://data.udger.com/";
            string filename = "udgerdb_v3.dat";
            string new_filename = "ipres.db";

            if (downloadFile(baseUrl + udger_key + "/", filename))
            {
                if (File.Exists(download_dir + "\\" + filename))
                {
                    if (File.Exists(move_dir + "\\" + new_filename))
                    {
                        File.Delete(move_dir + "\\" + new_filename);
                    }
                    if (File.Exists(download_dir + "\\" + filename))
                    {
                        string timeNow1 = DateTime.Now.ToString("yyyy-MM-dd_HH-mm");
                        File.Copy(download_dir + "\\" + filename, backup_dir + new_filename + "_" + timeNow1, true);
                        File.Move(download_dir + "\\" + filename, move_dir + "\\" + new_filename);
                        Write(filename + " renamed and moved... new name: " + new_filename, ConsoleColor.Green);
                        AddFileSecurity(move_dir + "\\" + new_filename, @"IUSR", FileSystemRights.FullControl, AccessControlType.Allow);
                    }
                    else
                    {
                        Write(filename + " not exists!", ConsoleColor.Red);
                    }
                }
            }
            Write("");
        }

        static void IP2Location_downloadFile()
        {
            Write("Start IP2Location Download " + timeNow, ConsoleColor.Yellow);
            string baseUrl = @"https://www.ip2location.com/download/?token=&file=DB11LITEBINIPV6";
            string filename = "IP2LOCATION-LITE-DB11.IPV6.BIN";
            string new_filename = "IP2LOCATION-LITE-DB11.BIN";

            if (downloadFile_WN(baseUrl, filename + ".zip"))
            {
                if (File.Exists(download_dir + "\\" + filename + ".zip"))
                {
                    if (File.Exists(move_dir + "\\" + new_filename))
                    {
                        File.Delete(move_dir + "\\" + new_filename);
                    }

                    unTAR(download_dir + "\\" + filename + ".zip", download_dir, filename, filename);

                    if (File.Exists(download_dir + "\\" + filename + ".zip"))
                    {
                        File.Delete(download_dir + "\\" + filename + ".zip");
                    }

                    if (File.Exists(download_dir + "\\" + filename))
                    {
                        string timeNow1 = DateTime.Now.ToString("yyyy-MM-dd_HH-mm");
                        File.Copy(download_dir + "\\" + filename, backup_dir + new_filename + "_" + timeNow1, true);
                        File.Move(download_dir + "\\" + filename, move_dir + "\\" + new_filename);
                        Write(filename + " renamed and moved... new name: " + new_filename, ConsoleColor.Green);
                        AddFileSecurity(move_dir + "\\" + new_filename, @"IUSR", FileSystemRights.FullControl, AccessControlType.Allow);
                    }
                    else
                    {
                        Write(filename + " not exists!", ConsoleColor.Red);
                    }
                }
            }
            Write("");
        }

        static void IP2Proxy_downloadFile()
        {
            Write("Start IP2Proxy Download " + timeNow, ConsoleColor.Yellow);
            string baseUrl = @"https://www.ip2location.com/download/?token=&file=PX10LITEBIN";
            string filename = "IP2PROXY-LITE-PX10.BIN";
            string new_filename = "IP2PROXY-LITE-PX10.BIN";

            if (downloadFile_WN(baseUrl, filename + ".zip"))
            {
                if (File.Exists(download_dir + "\\" + filename + ".zip"))
                {
                    if (File.Exists(move_dir + "\\" + new_filename))
                    {
                        File.Delete(move_dir + "\\" + new_filename);
                    }

                    unTAR(download_dir + "\\" + filename + ".zip", download_dir, filename, filename);

                    if (File.Exists(download_dir + "\\" + filename + ".zip"))
                    {
                        File.Delete(download_dir + "\\" + filename + ".zip");
                    }

                    if (File.Exists(download_dir + "\\" + filename))
                    {
                        string timeNow1 = DateTime.Now.ToString("yyyy-MM-dd_HH-mm");
                        File.Copy(download_dir + "\\" + filename, backup_dir + new_filename + "_" + timeNow1, true);
                        File.Move(download_dir + "\\" + filename, move_dir + "\\" + new_filename);
                        Write(filename + " renamed and moved... new name: " + new_filename, ConsoleColor.Green);
                        AddFileSecurity(move_dir + "\\" + new_filename, @"IUSR", FileSystemRights.FullControl, AccessControlType.Allow);
                    }
                    else
                    {
                        Write(filename + " not exists!", ConsoleColor.Red);
                    }
                }
            }
            Write("");
        }

        static void Maxmind_downloadFile()
        {
            Write("Start Maxmind Download " + timeNow, ConsoleColor.Yellow);
            string baseUrl = @"https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=&suffix=tar.gz";
            string filename = "GeoLite2-City.mmdb";
            string new_filename = "GeoLite2-City.mmdb";

            if (downloadFile_WN(baseUrl, filename + ".zip"))
            {
                if (File.Exists(download_dir + "\\" + filename + ".zip"))
                {
                    if (File.Exists(move_dir + "\\" + new_filename))
                    {
                        File.Delete(move_dir + "\\" + new_filename);
                    }

                    unTAR(download_dir + "\\" + filename + ".zip", download_dir, filename, filename);

                    if (File.Exists(download_dir + "\\" + filename + ".zip"))
                    {
                        File.Delete(download_dir + "\\" + filename + ".zip");
                    }

                    if (File.Exists(download_dir + "\\" + filename))
                    {
                        string timeNow1 = DateTime.Now.ToString("yyyy-MM-dd_HH-mm");
                        File.Copy(download_dir + "\\" + filename, backup_dir + new_filename + "_" + timeNow1, true);
                        File.Move(download_dir + "\\" + filename, move_dir + "\\" + new_filename);
                        Write(filename + " renamed and moved... new name: " + new_filename, ConsoleColor.Green);
                        AddFileSecurity(move_dir + "\\" + new_filename, @"IUSR", FileSystemRights.FullControl, AccessControlType.Allow);
                    }
                    else
                    {
                        Write(filename + " not exists!", ConsoleColor.Red);
                    }
                }
            }
            Write("");
        }

        public static void unTAR(String tarFilePath, String directoryPath, String contains, String newname)
        {
            using (Stream stream = File.OpenRead(tarFilePath))
            {
                var reader = ReaderFactory.Open(stream);
                while (reader.MoveToNextEntry())
                {
                    if (!reader.Entry.IsDirectory && reader.Entry.Key.Contains(contains))
                    {
                        ExtractionOptions opt = new ExtractionOptions
                        {
                            ExtractFullPath = false,
                            Overwrite = true
                        };
                        Console.Write("Unpaking " + newname + "...");
                        reader.WriteEntryToDirectory(directoryPath, opt);
                        Write("...Done", ConsoleColor.Green);
                    }
                }
            }
        }

        static async Task geoip_downloadFileAsync()
        {
            string baseUrl = @"https://mailfud.org/geoip-legacy/";
            string extension = ".gz";
            string GeoIP = "GeoIP.dat";
            string GeoIPv6 = "GeoIPv6.dat";
            string GeoIPCity = "GeoIPCity.dat";
            string GeoIPCityv6 = "GeoIPCityv6.dat";
            string GeoIPASNum = "GeoIPASNum.dat";
            string GeoIPASNumv6 = "GeoIPASNumv6.dat";
            string GeoIPISP = "GeoIPISP.dat";
            string GeoIPOrg = "GeoIPOrg.dat";

            Write("Start GEOIP Download " + timeNow, ConsoleColor.Yellow);
            await downANDdec(baseUrl, GeoIP, extension);
            await downANDdec(baseUrl, GeoIPv6, extension);
            await downANDdec(baseUrl, GeoIPCity, extension);
            await downANDdec(baseUrl, GeoIPCityv6, extension);
            await downANDdec(baseUrl, GeoIPASNum, extension);
            await downANDdec(baseUrl, GeoIPASNumv6, extension);
            await downANDdec(baseUrl, GeoIPISP, extension);
            await downANDdec(baseUrl, GeoIPOrg, extension);

            Write("");
        }

        public static async Task downANDdec(string baseUrl, string filename, string extension)
        {
            if (downloadFile(baseUrl, filename + extension))
            {
                await DecompressGZip(download_dir + "\\" + filename + extension, iis_dir + "\\" + filename);
                string timeNow1 = DateTime.Now.ToString("yyyy-MM-dd_HH-mm");
                await DecompressGZip(download_dir + "\\" + filename + extension, backup_dir + filename + "_" + timeNow1);

                if (File.Exists(download_dir + "\\" + filename + extension))
                {
                    File.Delete(download_dir + "\\" + filename + extension);
                }
            }
        }


        static bool downloadFile(string baseUrl, string filename)
        {
            if (File.Exists(download_dir + "\\" + filename))
            {
                File.Delete(download_dir + "\\" + filename);
            }

            using (WebClient myWebClient = new WebClient())
            {
                try
                {
                    Write("Downloading file: " + filename + " ...", ConsoleColor.White, false);
                    myWebClient.DownloadFile(new Uri(baseUrl + filename), download_dir + "\\" + filename);

                    Write("... Done\n", ConsoleColor.Green, false);
                    myWebClient.Dispose();
                    return true;
                }
                catch (WebException e)
                {
                    Write("\nError: " + e.Message, ConsoleColor.Red);
                }
            }
            return false;
        }


        static bool downloadFile_WN(string baseUrl, string filename)
        {
            if (File.Exists(download_dir + "\\" + filename))
            {
                File.Delete(download_dir + "\\" + filename);
            }

            using (WebClient myWebClient = new WebClient())
            {
                try
                {
                    Write("Downloading file: " + filename + " ...", ConsoleColor.White, false);
                    myWebClient.DownloadFile(new Uri(baseUrl), download_dir + "\\" + filename);

                    Write("... Done\n", ConsoleColor.Green, false);
                    myWebClient.Dispose();
                    return true;
                }
                catch (WebException e)
                {
                    Write("\nError: " + e.Message, ConsoleColor.Red);
                }
            }
            return false;
        }

        static void Write(string text, ConsoleColor color = ConsoleColor.White, bool WL = true)
        {
            Console.ForegroundColor = color;
            if (WL)
            {
                Console.WriteLine(text, Console.ForegroundColor);
            }
            else
            {
                Console.Write(text, Console.ForegroundColor);
            }
            Console.ForegroundColor = ConsoleColor.White;
        }

        public static async Task DecompressGZip(string inputPath, string outputPath)
        {
            using (var input = File.OpenRead(inputPath))
            using (var output = File.OpenWrite(outputPath))
            using (var gz = new GZipStream(input, CompressionMode.Decompress))
            {
                await gz.CopyToAsync(output);
            }
        }

        public static void AddFileSecurity(string fileName, string account, FileSystemRights rights, AccessControlType controlType)
        {

            // Get a FileSecurity object that represents the
            // current security settings.
            FileSecurity fSecurity = File.GetAccessControl(fileName);

            // Add the FileSystemAccessRule to the security settings.
            fSecurity.AddAccessRule(new FileSystemAccessRule(account,
                rights, controlType));

            // Set the new access settings.
            File.SetAccessControl(fileName, fSecurity);
        }
    }
}
