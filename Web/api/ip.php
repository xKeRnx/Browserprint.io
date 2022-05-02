<?php 
header("Content-Type: application/json", true);
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/config.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/MaxMind/get.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/IP2Proxy/get.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/IP2Location/get.php';
$MaxMind = new MaxMind('C:\inetpub\GeoLite2-City.mmdb');
$MaxMind_ASN = new MaxMind('C:\inetpub\GeoLite2-ASN.mmdb');
$IP2Proxy = new IP2Proxy('C:\inetpub\IP2PROXY-LITE-PX10.BIN');
$IP2Location = new IP2Location('C:\inetpub\IP2LOCATION-LITE-DB11.BIN');

$error = false;

if (isset($_GET['key'])) {
	$username = 'Unknown';
	if (isset($_SESSION['ulogin'])) {
		$username = $_SESSION['ulogin'];
	}
	
    $CurPageURL = $_SERVER['HTTP_HOST'];

    if (isset($_GET['ip']) && $_GET['ip'] != "") {
        $ip = $_GET['ip'];
    }else{
        $ip = $fp->getIP();
    }

    $serverIP = $fp->getIP();

    if(!filter_var($ip, FILTER_VALIDATE_IP)){
        $ip = gethostbyname($ip);
    }

    if($check->PrivIP($ip) != 'OK'){
        $error = true;
        $myObj->error = "255";
        $myObj->status = $check->PrivIP($ip);
    }

	$Key = $_GET['key'];

    $save = false;
	$sql = "SELECT * FROM project WHERE token=(:token) LIMIT 1";
	$query = $dbh->prepare($sql);
	$query->bindParam(':token', $Key, PDO::PARAM_STR);
	$query->execute();
	if ($query->rowCount() > 0) {
        $res = $query->fetchAll(PDO::FETCH_OBJ);
        $project_id = $res[0]->id;
        $db_website = $res[0]->website;
        $db_ip = $res[0]->ip;
		$type = $res[0]->type;
        $sub_until = $res[0]->subscribe_until;
        $save = $res[0]->save_ip_data;
        $idents = $res[0]->idents;

        $sql_idents = 0;
        $sql_ids = "SELECT COUNT(id) as ct FROM save_ip WHERE YEAR(dDate) = YEAR(CURRENT_DATE()) AND MONTH(dDate) = MONTH(CURRENT_DATE()) AND DAY(dDate) = DAY(CURRENT_DATE()) AND project_id = (:project_id)";
        $query_ids = $dbh->prepare($sql_ids);
        $query_ids->bindParam(':project_id', $project_id, PDO::PARAM_STR);
        $query_ids->execute();
        if ($query_ids->rowCount() > 0) {
            $res_ids = $query_ids->fetchAll(PDO::FETCH_OBJ);
            $sql_idents = $res_ids[0]->ct;
        }

        if($sql_idents > $idents){
            $error = true;
            $myObj->error = "5";
            $myObj->status = "Plan identifications already exceeded ".$sql_idents.'-'.$idents;
        }

		if($db_ip == $serverIP){
			if($type == 1 || $type == 2){
				$date_now = date("Y-m-d H:i:s");
				$db_date = new DateTime($sub_until);
				$db_date = $db_date->format("Y-m-d H:i:s");

				if ($db_date > $date_now) {

				}else{
                    $error = true;
                    $myObj->error = "0";
					$myObj->status = "Project already expired";
				}
			}else{
                $error = true;
                $myObj->error = "1";
				$myObj->status = "Key not for this Type";
			}
		}else{
            $error = true;
            $myObj->error = "2";
			$myObj->status = "No valid ServerIP";
		}
	}else{
        $error = true;
        $myObj->error = "3";
		$myObj->status = "Key not found in DB";
	}

    if($error == false){
        $vpndetect = 'false';
        $proxydetect = 'false';
        $tordetect = 'false';
        $torResponse = file_get_contents('https://browserprint.io/torlist');
        $torResponse_exit = file_get_contents('https://browserprint.io/torexitlist');
        
        $city = '';
        $country = '';
        $region = '';
        $lat = '';
        $long = '';
        $classification = 'Unknown';
        $crawler_name = '';
        $crawler_class = '';
        $datacenter = '';
        $homepage = '';

        if($IP2Location->comp($ip)){
            $country = $IP2Location->country($ip);
            $country_code = $IP2Location->country_code($ip);
            $continent_code = $MaxMind->continent_code($ip);
            $city = $IP2Location->city($ip);
            $region = $IP2Location->region($ip);
            $zip = $IP2Location->postal($ip);
            $lat = $IP2Location->lat($ip);
            $long = $IP2Location->lon($ip);
        }
        if($region == "" || $city == "" || $zip == ""){
            if($MaxMind->comp($ip)){
                $country = $MaxMind->country($ip);
                $continent_code = $MaxMind->continent_code($ip);
                $country_code = $MaxMind->country_code($ip);
                $city = $MaxMind->city($ip);
                $region = $MaxMind->region($ip);
                $zip = $MaxMind->postal($ip);
                $lat = $MaxMind->lat($ip);
                $long = $MaxMind->lon($ip);
            } 
        }

        if (strpos($torResponse_exit, $ip) !== false) {
            $classification = 'Tor exit node';
            $tordetect = 'true';
        }elseif (strpos($torResponse, $ip) !== false) {
            $classification = 'Tor node';
            $tordetect = 'true';
        }

        // Establish database connection.
        $ipdb = new ipdb();
        $sqlite = $ipdb->connect();
        $statement = $sqlite->prepare('SELECT ipc.ip_classification, ipl.* FROM main.udger_ip_list as ipl, main.udger_ip_class as ipc WHERE ipc.id=ipl.class_id AND ip=(:ip)');
        $statement->bindParam(':ip', $ip, PDO::PARAM_STR);
        $statement->execute();
        if($results = $statement->fetchAll(PDO::FETCH_OBJ)){
            $classification = $results[0]->ip_classification;

            if ($results[0]->crawler_id != 0) {
                $crawler = $sqlite->prepare('SELECT cc.crawler_classification, cl.* FROM main.udger_crawler_list as cl, main.udger_crawler_class as cc WHERE cc.id=cl.class_id AND cl.id=(:id)');
                $crawler->bindParam(':id', $results[0]->crawler_id, PDO::PARAM_STR);
                $crawler->execute();
                if ($crawler_res = $crawler->fetchAll(PDO::FETCH_OBJ)) {
                    $crawler_name = $crawler_res[0]->name;
                    $crawler_class = $crawler_res[0]->crawler_classification;
                }
            }

            $ip2long = ip2long($results[0]->ip);
            $dc = $sqlite->prepare('SELECT lst.name, lst.homepage, rg.* from main.udger_datacenter_range as rg, udger_datacenter_list as lst WHERE lst.id=rg.datacenter_id AND rg.iplong_from < :ip AND rg.iplong_to > :ip');
            $dc->bindParam(':ip', $ip2long, PDO::PARAM_STR);
            $dc->execute();

            if ($dc_ress = $dc->fetchAll(PDO::FETCH_OBJ)) {
                foreach ($dc_ress as $dc_res) {
                    $datacenter = $dc_res->name;
                    $homepage = $dc_res->homepage;
                }
            }

            if($results[0]->class_id == 4 OR $results[0]->class_id == 6){
                $proxydetect = 'true';
            }
            if($results[0]->class_id == 5){
                $vpndetect = 'true';
            }

        }

        if($classification == 'Unknown' || $proxydetect == 'false' && $vpndetect == 'false' && $tordetect == 'false'){
            if($ipdb->isPubProxy($ip)){
                $classification = 'Public proxy';
                $proxydetect = 'true';
            }
        }

        if($classification == 'Unknown' || $proxydetect == 'false' && $vpndetect == 'false' && $tordetect == 'false'){
            if($IP2Proxy->isProxy($ip)){
                if($IP2Proxy->proxyType($ip) == "PUB"){
                    $classification = 'Public proxy';
                }else{
                    $classification = 'Web proxy';
                }
                $proxydetect = 'true';
            }
        }

        if($classification == 'Unknown' || $proxydetect == 'false' && $vpndetect == 'false' && $tordetect == 'false'){
                $ipapi_call = file_get_contents('http://ip-api.com/php/'.$ip.'?fields=status,message,continentCode,country,countryCode,region,regionName,city,zip,lat,lon,timezone,currency,isp,org,as,asname,reverse,mobile,proxy,hosting,query');
                $ipapi_data = unserialize($ipapi_call);
 
                if($ipapi_data['status'] == 'success'){
                    $pprox = utf8_encode($ipapi_data['proxy']);
                    $phosting = utf8_encode($ipapi_data['hosting']);
                    if($phosting == true){
                        $classification = 'Hosting';
                    }
                    if($pprox == true){
                        $classification = 'VPN or Proxy';
                        $proxydetect = 'true';
                        $vpndetect = 'true';
                    }
                }
        }
        if($classification == 'Unknown'){
            if (strpos($ipdb->hostname($ip), $ip) !== false) {
                $classification = 'Dedicated Server';
            }
        }

        $myObj->status = "OK";
        $myObj->threat = $check->dnsbllookup($ip);
        $myObj->ip = $ip;
        $myObj->country = $country;
        $myObj->country_code = $country_code;
        $myObj->continent_code = $continent_code;
        $myObj->flag = "https://browserprint.io/api/flags?i=".$country_code;
        $myObj->city = $city;
        $myObj->region = $region;
        $myObj->zip = $zip;
        $myObj->lat = number_format($lat, 4, '.', '');
        $myObj->long = number_format($long, 4, '.', '');
        $myObj->proxy = $proxydetect;
        $myObj->tor = $tordetect;
        $myObj->vpn = $vpndetect;
        $myObj->classification = $classification;
        $myObj->crawler_name = $crawler_name;
        $myObj->crawler_class = $crawler_class;
        $myObj->datacenter = $datacenter;
        $myObj->homepage = $homepage;
        if ($ipdb->hostname($ip)) {
            $myObj->hostname = $ipdb->hostname($ip);
        }

        if ($MaxMind_ASN->comp($ip)) {
            $myObj->isp = $MaxMind_ASN->comp($ip)['autonomous_system_organization'];
            $myObj->asn = $MaxMind_ASN->comp($ip)['autonomous_system_number'];
        }

    }
}else{
    $error = true;
    $myObj->error = "4";
	$myObj->status = "Key not defined";
}
$return = json_encode($myObj);
$ser = serialize($myObj);

if($save == true && $query->rowCount() > 0 && $error == false){
    $act_save = 1;
    $sql = "insert into save_ip (project_id, data, active_save) values (:project_id, :data, :active_save)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':project_id', $project_id, PDO::PARAM_STR);
    $query->bindParam(':data', $ser, PDO::PARAM_STR);
    $query->bindParam(':active_save', $act_save, PDO::PARAM_STR);
    $query->execute();
}elseif($save == false && $query->rowCount() > 0 && $error == false){
    $act_save = 0;
    $sql = "insert into save_ip (project_id, active_save) values (:project_id, :active_save)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':project_id', $project_id, PDO::PARAM_STR);
    $query->bindParam(':active_save', $act_save, PDO::PARAM_STR);
    $query->execute();
}

echo $return;
?>