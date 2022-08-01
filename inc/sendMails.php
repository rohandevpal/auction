<?php

require 'mailer/vendor/autoload.php';

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
 
// //Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);



function sendMail($email,$subject,$message){
	//required parameters...
	$production = PROD;
	$siteName = SITE_NAME;
	$MailFrom = SITE_EMAIL;

	//smtp request...
	$mail = new PHPMailer;
	$mail->Host       = 'smart-auction.net';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
    $mail->Username   = 'info@smart-auction.net';                     //SMTP username
    $mail->Password   = 'EN1u0n1c(v{9';                  
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;           
    $mail->setFrom($MailFrom, $siteName);
    $mail->addAddress($email);     //Add a recipient
    $mail->addReplyTo($MailFrom, $siteName);

	$mail->Subject = $subject;
    $mail->Body    = $message;
	if($production != 1){
		$file = fopen(rand(99999,999999).'.html', 'w');
		fwrite($file, $message);
		fclose($file);
		return true;
	} else {
		if(!$mail->send()) {
			return false;
		} else {
			return true;
		}
	}
}

function SendBulk($emails,$template){
	//required parameters...
	$production = PROD;
	$siteName = SITE_NAME;
	$MailFrom = SITE_EMAIL;

	global $conn;
	global $idMail;

	$tempData=mysqli_query($conn,"SELECT `name`, `img`, `title`, `text`, `link` FROM `bnmi_campaign` WHERE `id`=$template ");
	$dataT=mysqli_fetch_assoc($tempData);
	if($dataT['link']!=NULL || $dataT['link'] != '#'){ 
		$button = '<a href="'.$dataT['link'].'" style=" display: inline-block; text-decoration: none; color: #fff; border-radius: 5px; background: #ea0009; padding: 10px 50px; font-size: 16px; border-radius: 25px; font-weight: 600; " >Click Here</a >';
	}else{
		$button=' ';
	}

	$message = '<div style="display: flex;justify-content: center;align-items: center;text-align: center;word-break: break-all;"> <div style=" width: 600px; text-align:center; height: 100vh; background-position: center; background-color: #fff; " > <div style="text-align: center"> <img src="https://adityakundra.com/CryptoFinal/assets/img/logo.png" alt="" style="height: 100px; padding-bottom: 20px"/> </div><img src="SITEURL/assets/img/campaign/'.$dataT['img'].'" alt="" style="width: 100%"/> <h1 style="color: #ea0009; text-transform: uppercase; text-align: center" > '.$dataT['title'].' </h1> <hr style=" width: 100px; background-color: #ea0009; height: 2px; border: none; "/> <p style="padding: 10px 10px; text-align: center">'.htmlspecialchars_decode($dataT['text']).'</p><div style="text-align: center">'.$button.' </div><br/> <hr style="border: none; background-color: black; height: 1px"/> <div style="text-align: center; margin: 30px 0 30px 0"> <span style="border-right: 2px solid black; padding: 0 5px" >'.SITE_NAME.'</span > <span style="border-right: 2px solid black; padding: 0 5px" >Website</span > <span style="padding: 0 5px">Email</span> </div><hr style="border: none; background-color: black; height: 1px"/> <p style="text-align: center; margin-top: 30px"> Copyright &copy; '.SITE_NAME.'. All rights reserved </p></div></div>';

	//smtp request...
	$mail = new PHPMailer;
	$mail->Host       = 'smart-auction.net';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
    $mail->Username   = 'info@smart-auction.net';                     //SMTP username
    $mail->Password   = 'EN1u0n1c(v{9';                  
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;  
	$mail->setFrom($MailFrom, $siteName);         
	
	foreach($emails as $singleemail){
		echo $singleemail;
	$mail->addAddress($singleemail);   
	}  
	    //Add a recipient
    $mail->addReplyTo($MailFrom, $siteName);

	$mail->Subject = "Testing";
	$mail->IsHTML(true);
    $mail->Body    = $message;

	if($production != 1){
		$file = fopen(rand(99999,999999).'.html', 'w');
		fwrite($file, $message);
		fclose($file);
		return true;
	} else {
		if(!$mail->send()) {
			return false;
		} else {
			return true;
		}
	}
}

function auctionMail($emails,$subject,$message){
	//required parameters...
	$production = PROD;
	$siteName = SITE_NAME;
	$MailFrom = SITE_EMAIL;

	global $conn;
	global $idMail;
	$msg = getTemplate($subject,$message);
	//smtp request...
	$mail = new PHPMailer;
	$mail->Host       = 'smart-auction.net';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
    $mail->Username   = 'info@smart-auction.net';                     //SMTP username
    $mail->Password   = 'EN1u0n1c(v{9';                  
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port    = 465;  
	$mail->setFrom($MailFrom, $siteName);         
	
	foreach($emails as $singleemail){
	$mail->addAddress($singleemail);   
	}  
	    //Add a recipient
    $mail->addReplyTo($MailFrom, $siteName);

	$mail->Subject = "Testing";
	$mail->IsHTML(true);
    $mail->Body    = $msg;

	if($production != 1){
		$file = fopen(rand(99999,999999).'.html', 'w');
		fwrite($file, $message);
		fclose($file);
		return true;
	} else {
		if(!$mail->send()) {
			return false;
		} else {
			return true;
		}
	}
}

?>