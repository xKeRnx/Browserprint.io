<?php
$__TOKEN = "hardcodeshitbykernstudios";
require $_SERVER["DOCUMENT_ROOT"] . '/includes/config.php';

$torlist_file = torexitlist;
if(file_exists($torlist_file)){
	echo nl2br(file_get_contents($torlist_file));
}else{
    echo 'ERROR';
}
?>