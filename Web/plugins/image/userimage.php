<?php 
require($_SERVER["DOCUMENT_ROOT"].'/classes/classloader.php');

$loader = new Loader();
spl_autoload_register([$loader, 'handle']);
 
$db = new db();
$dbh = $db->connect();

if(isset($_GET['i']) AND @$_GET['i']!=null){
	$sql = "SELECT image from users WHERE id=(:id) AND status=1";
	$query = $dbh->prepare($sql);
	$query-> bindParam(':id', $_GET['i'], PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() == 1){
		$filename = $results[0]->image;
		$fielepath = $uploaddir.$filename; 
		
		if(file_exists($fielepath))
		{
			header('Content-type: image/png');
			readfile($fielepath);
		}else{
			header('Content-type: image/png');
			readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/noav.png");
		}
		
	}else{
		header('Content-type: image/png');
		readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/noav.png");
	}
}else{
	header("Location: ../");
}
