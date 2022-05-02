<?php
header('Content-type:application/json;charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/config.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/MaxMind/get.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/IP2Proxy/get.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/IP2Location/get.php';
$MaxMind = new MaxMind('C:\inetpub\GeoLite2-City.mmdb');
$IP2Proxy = new IP2Proxy('C:\inetpub\IP2PROXY-LITE-PX10.BIN');
$IP2Location = new IP2Location('C:\inetpub\IP2LOCATION-LITE-DB11.BIN');

$error = false;

if (isset($_GET['ip']) && $_GET['ip'] != "") {
    $ip = $_GET['ip'];
} else {
    $ip = $fp->getIP();
}

$serverIP = $fp->getIP();
$comerc = false;

if (isset($_GET['key'])) {
    $Key = $_GET['key'];
    $sql = "SELECT * FROM project WHERE token=(:token) LIMIT 1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':token', $Key, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        $res = $query->fetchAll(PDO::FETCH_OBJ);
        $type = $res[0]->type;
        $sub_until = $res[0]->subscribe_until;
        if($type == 3){
            $date_now = date("Y-m-d H:i:s");
            $db_date = new DateTime($sub_until);
            $db_date = $db_date->format("Y-m-d H:i:s");

            if ($db_date > $date_now) {
                $comerc = true;
            }else{
                $error = true;
                $myObj->error = "0";
                $myObj->status = "Project already expired";
            }
        }
    }
}

if(!$comerc){
    $sql = "SELECT * FROM free_ip WHERE ip=(:ip) LIMIT 1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':ip', $serverIP, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        $res = $query->fetchAll(PDO::FETCH_OBJ);
        $lastused = $res[0]->dDate;
        date_default_timezone_set('Europe/Berlin');
        $now = date("Y-m-d H:i:s");
        $nowTime = new DateTime($now);
        $nowTime->modify("-10 seconds");
        $nowTime = $nowTime->format('Y-m-d H:i:s');
    
        $dbTime = new DateTime($lastused);
        $dbTime = $dbTime->format('Y-m-d H:i:s');
    
        if ($dbTime > $nowTime) {
            $error = true;
            $myObj->error = "244";
            $myObj->status = "Only 1 query every 10 seconds.";
        }else{
            $sqlactiv = "UPDATE free_ip SET used=used+1 WHERE ip=(:ip)";
            $queryactiv = $dbh->prepare($sqlactiv);
            $queryactiv->bindParam(':ip', $serverIP, PDO::PARAM_STR);
            $queryactiv->execute();
        }
    
    }else{
        $sql = "insert into free_ip (ip) values (:ip)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':ip', $serverIP, PDO::PARAM_STR);
        $query->execute();
    }
}


if (!filter_var($ip, FILTER_VALIDATE_IP)) {
    $ip = gethostbyname($ip);
}

if ($check->PrivIP($ip) != 'OK') {
    $error = true;
    $myObj->error = "255";
    $myObj->status = $check->PrivIP($ip);
}

if ($error == false) {
    $city = '';
    $country = '';
    $region = '';
    $lat = '';
    $long = '';

    if ($IP2Location->comp($ip)) {
        $country = $IP2Location->country($ip);
        $continent_code = $MaxMind->continent_code($ip);
        $country_code = $IP2Location->country_code($ip);
        $city = $IP2Location->city($ip);
        $region = $IP2Location->region($ip);
        $zip = $IP2Location->postal($ip);
        $lat = $IP2Location->lat($ip);
        $long = $IP2Location->lon($ip);
    }
    if ($region == "" || $city == "" || $zip == "") {
        if ($MaxMind->comp($ip)) {
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

    $myObj->status = "OK";
    $myObj->ip = $ip;
    $myObj->country = $country;
    $myObj->country_code = $country_code;
    $myObj->continent_code = $continent_code;
    $myObj->flag = "https://browserprint.io/api/flags?i=" . $country_code;
    $myObj->city = $city;
    $myObj->region = $region;
    $myObj->zip = $zip;
    $myObj->lat = number_format($lat, 4, '.', '');
    $myObj->long = number_format($long, 4, '.', '');

}
echo json_encode($myObj);
