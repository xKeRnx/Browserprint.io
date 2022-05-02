<?php
require_once __DIR__ . '/Database.php';
use \IP2Proxy\Database;
	
class IP2Proxy
{		
	public $db;
	
    public function __construct($file)
    {
		$this->db = new Database($file, Database::FILE_IO);
    }
	
	function comp($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL);
	}
	
	function country($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['countryName'];
	}
	
	function country_code($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['countryCode'];
	}
	
	function region($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['regionName'];
	}
	
	function city($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['cityName'];
	}
	
	function threat($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['threat'];
	}
	
	function lastSeen($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['lastSeen'];
	}
	
	function asn($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['asn'];
	}
	
	function usageType($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['usageType'];
	}
	
	function domain($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['domain'];
	}
	
	function proxyType($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['proxyType'];
	}
	
	function isProxy($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['isProxy'];
	}
	
	function isp($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['isp'];
	}
	

		
}
?>