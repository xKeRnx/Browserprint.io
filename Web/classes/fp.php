<?php
class fp
{
	public $dbh;

	function __construct()
	{
		$db = new db();
		$this->dbh = $db->connect();
	}
	
    function getIP()
    {
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
		}
		return $_SERVER['REMOTE_ADDR'];
    }
}
