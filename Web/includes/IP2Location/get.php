<?php
require_once __DIR__ . '/Database.php';
use \IP2Location\Database;
	
class IP2Location
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
	
	function postal($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['zipCode'];
	}
	
	function lat($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['latitude'];
	}
	
	function lon($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['longitude'];
	}
	
	function city($ipAddress){
		return $this->db->lookup($ipAddress, Database::ALL)['cityName'];
	}
		
}
?>