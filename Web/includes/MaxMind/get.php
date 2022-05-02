<?php
require_once __DIR__ . '/reader.php';
use MaxMind\Db\Reader;
	
class MaxMind
{		
	public $reader;
	
    public function __construct($db)
    {
		$this->reader = new Reader($db);
    }
	
	public function __destruct()
    {
		$this->reader->close();
    }
	
	function comp($ipAddress){
		return $this->reader->get($ipAddress);
	}
	
	function country($ipAddress){
		return $this->reader->get($ipAddress)['country']['names']['en'];
	}
	
	function country_code($ipAddress){
		return $this->reader->get($ipAddress)['country']['iso_code'];
	}
	
	function region($ipAddress){
		return $this->reader->get($ipAddress)['subdivisions']['0']['names']['en'];
	}
	
	function postal($ipAddress){
		return $this->reader->get($ipAddress)['postal']['code'];
	}
	
	function lat($ipAddress){
		return $this->reader->get($ipAddress)['location']['latitude'];
	}
	
	function lon($ipAddress){
		return $this->reader->get($ipAddress)['location']['longitude'];
	}
	
	function continent($ipAddress){
		return $this->reader->get($ipAddress)['continent']['names']['en'];
	}
	
	function continent_code($ipAddress){
		return $this->reader->get($ipAddress)['continent']['code'];
	}
	
	function city($ipAddress){
		return $this->reader->get($ipAddress)['city']['names']['en'];
	}
		
}
?>