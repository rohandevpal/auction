<?php 
require_once 'inc/config.php';
if(isset($_SESSION['user'])){
    $id =   $_SESSION['user'] ['id'];
    mysqli_query($conn, "UPDATE `bnmi_users` SET `login_status`='0' WHERE id =' $id'");
    session_destroy();
    $_SESSION['toast']['type'] = "warning";
    $_SESSION['toast']['msg'] = "Log Out";
    header('location:login.php');
    exit();
}