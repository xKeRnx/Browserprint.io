<?php
 header('Content-type: image/png');
if(isset($_GET['i'])){
    $i = $_GET['i'];
    if($i == 'Windows 10' || $i == 'Windows 8.1' || $i == 'Windows 8' || $i == 'Windows 7' || $i == 'Windows Vista' || $i == 'Windows XP'){
	    readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/device/windows.png");
    }elseif($i == 'iPhone' || $i == 'iPod' || $i == 'iPad'){
        readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/device/apple.png");
    }elseif($i == 'Android'){
        readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/device/android.png");
    }elseif($i == 'BlackBerry'){
        readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/device/blackberry.png");
    }elseif($i == 'Mobile'){
        readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/device/mobile.png");
    }elseif($i == 'Mac OS X' || $i == 'Mac OS X'){
        readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/device/mac.png");
    }elseif($i == 'Linux'){
        readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/device/linux.png");
    }elseif($i == 'Ubuntu'){
        readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/device/ubuntu.png");
    }else{
        readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/device/unk.png");
    }
}else{
	readfile($_SERVER["DOCUMENT_ROOT"]."/assets/img/device/unk.png");
}
?>