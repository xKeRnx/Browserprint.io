<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/config.php';

if (isset($_GET['t'])) {
	$token = $_GET['t'];
	
	if($token == 'KeRn2020'){
		echo 'OK';
	}else{
		echo 'NO AUTH';
	}
}else{
	echo 'NO AUTH';
}
?>