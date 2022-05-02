<?php
if(isset($_GET['i'])){
    $string = substr($_GET['i'], 0, 5);
    $string = preg_replace("/[\W]/", "", $string);
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/assets/img/iso_flags/".$string.".png")){
        header('Content-type: image/png');
	    readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/iso_flags/".$string.".png");
    }else{
        header('Content-type: image/png');
	    readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/iso_flags/unk.png");
    }
}else{
    header('Content-type: image/png');
	readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/iso_flags/unk.png");
}
?>