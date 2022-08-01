<?php
session_start();
//date_default_timezone_set('Canada/Mountain');
date_default_timezone_set('Asia/Kolkata');
$cTime = date('Y-m-d H:i:s');
$cDate = date('Y-m-d');
$metaPage =0;
$activePage =0;
$tblPrefix ="bnmi_";

//constants...
define('HASH_KEY', 'auction');
define('PROD', 0); //during production 1 testing 0...
define('RECAP_KEY', '');


if(PROD){
define('SITE_URL', 'https://smart-auction.net/');

$hostName = 'localhost';
$userName = 'smartauc_auc';
$password = 'K-=a{6l}Ql$H';
$database = 'smartauc_auction';
	
}else{
	define('SITE_URL', 'http://localhost/auction-website/');
	$hostName = 'localhost';
	$userName = 'root';
	$password = '';
	$database = 'auction';
}
$conn = mysqli_connect($hostName, $userName, $password, $database);

if($conn!=true){
	echo '<script> alert("Could not connect to database.");</script>';
	exit();
}

require_once 'functions.php';
require_once 'action-newsletter.php';
require_once 'simple.php';


$genDataQ = mysqli_query($conn, "SELECT key_name, key_value FROM `".$tblPrefix."general` WHERE key_name!=''");
while($genData = mysqli_fetch_assoc($genDataQ)){
	$_SESSION['general'][$genData['key_name']]= $genData['key_value'];
}


define('SITE_NAME', $_SESSION['general']['website_name']);
define('SITE_EMAIL', $_SESSION['general']['mailer_email']);

