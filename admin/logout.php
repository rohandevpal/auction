<?php 
require_once('../inc/config.php');
unset($_SESSION['adminUser']);
$_SESSION['toast']['msg'] ="Successfully logged out.";
header("location:login.php");
exit();