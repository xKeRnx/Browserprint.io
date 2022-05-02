<?php
require($_SERVER["DOCUMENT_ROOT"] . '/classes/classloader.php');

$db = new db();
$check = new checks();
$send = new sends();
$alert = new alert();
$users = new users();
$fp = new fp();

// Establish database connection.
$dbh = $db->connect();

// Load functions
require($_SERVER["DOCUMENT_ROOT"] . '/includes/functions.php');

if (isset($_SESSION['ulogin'])) {
	$sql_inconf = "SELECT name from  users WHERE name=(:name)";
	$query_inconf = $dbh->prepare($sql_inconf);
	$query_inconf->bindParam(':name', $_SESSION['ulogin'], PDO::PARAM_STR);
	$query_inconf->execute();
	$results_inconf = $query_inconf->fetchAll(PDO::FETCH_OBJ);
	if ($query_inconf->rowCount() > 0) {
		$username_fromconf = $results_inconf[0]->name;
	}
}
