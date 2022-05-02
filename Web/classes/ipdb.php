<?php
class ipdb 
{
    public $dbh;
    public $alert;
    public $send;
    public $user_agent;

    public function __construct()
    {
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->alert = new alert();
        $this->send = new sends();
        $db = new db();
        $this->dbh = $db->connect();
    }

	function isPubProxy($ip){
        $sql = "SELECT ip FROM pub_proxy WHERE ip=(:ip) LIMIT 1";
        $query = $this->dbh->prepare($sql);
        $query->bindParam(':ip', $ip, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
	}

	function connect(){
		try
		{
			return new PDO('sqlite:C:\inetpub\ipres.db');
		}
		catch (PDOException $e)
		{
		  exit('Connection failed: ' . $e->getMessage());
		}
	}
 
	function hostname($ip){
		$ret = gethostbyaddr($ip);
		if ($ret) { 
			return $ret;
		}
		return false;
	}
 
	function isp($ip){
		$ret = geoip_isp_by_name($ip);
		if ($ret) { 
			return $ret;
		}
		return false;
	}
 
	function asn($ip){
		$ret = geoip_asnum_by_name($ip);
		if ($ret) { 
			return $ret;
		}
		return false;
	}
	
	function country($ip){
		$ret = geoip_country_name_by_name($ip);
		if ($ret) { 
			return $ret;
		}
		return false;
	}
	
	function record_by_name($ip){
		$ret = geoip_record_by_name($ip);
		if ($ret) { 
			return $ret;
		}
		return false;
	}
	
	function city($ip){
		$ret = geoip_record_by_name($ip);
		if ($ret) { 
			return $ret['city'];
		}
		return false;
	}
	
	function postal($ip){
		$ret = geoip_record_by_name($ip);
		if ($ret) { 
			return $ret['postal_code'];
		}
		return false;
	}
	
	function region($ip){
		$ret = geoip_record_by_name($ip);
		if ($ret) { 
			return $ret['region'];
		}
		return false;
	}
 
}
?>