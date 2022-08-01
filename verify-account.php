<?php

   require_once 'inc/config.php';

if(isset($_GET['u']) && isset($_GET['token'])){
	$email = base64_decode(mysqli_real_escape_string($conn, ak_secure_string($_GET['u'])));
	$token = mysqli_real_escape_string($conn, ak_secure_string($_GET['token']));

	$checkUser = mysqli_query($conn, "SELECT id FROM `".$tblPrefix."users` WHERE email='$email' AND token = '$token' AND status>0");
	if(mysqli_num_rows($checkUser)>0){
		$actionQ = "UPDATE `".$tblPrefix."users` SET status=3, token='' WHERE email='$email' AND token = '$token'";
		if(mysqli_query($conn, $actionQ)==true){
			$_SESSION['toast']['type'] = "success";
			$_SESSION['toast']['msg'] = "Account successfully verified, Please login to continue.";
			$subject2 = "Thankyou for Signing-up";
            $message2 = "You are successfully registered with us; we'll keep you updated on the upcoming auctions";
            smtp_mailer($email, $subject2, $message2);
			header('location:login.php');
			exit();

		}else{
			$_SESSION['toast']['type'] = "warning";
			$_SESSION['toast']['msg'] = "Something went wrong, Please try again.";
			header('location:register.php');
			exit();
		}
	}else{
		$_SESSION['toast']['type'] = "warning";
		$_SESSION['toast']['msg'] = "Token has been expired.";
		header('location:register.php');
		exit();
	}
}else{
	$_SESSION['toast']['type'] = "error";
	$_SESSION['toast']['msg'] = "Something went wrong, Please try again.";
	header('location:register.php');
	exit();
}