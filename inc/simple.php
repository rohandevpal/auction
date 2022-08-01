<?php
require 'smtp/PHPMailerAutoload.php';

function getTemplate($subject,$message){
	$font = 'Helvetica Neue, Helvetica, Arial,sans-serif';
	
	return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: '.$font.', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
	<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Alerts e.g. approaching your limit</title>
	
	
	<style type="text/css">
	img {
	max-width: 100%;
	}
	body {
	-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
	}
	body {
	background-color: #f6f6f6;
	}
	@media only screen and (max-width: 640px) {
	  body {
		padding: 0 !important;
	  }
	  h1 {
		font-weight: 800 !important; margin: 20px 0 5px !important;
	  }
	  h2 {
		font-weight: 800 !important; margin: 20px 0 5px !important;
	  }
	  h3 {
		font-weight: 800 !important; margin: 20px 0 5px !important;
	  }
	  h4 {
		font-weight: 800 !important; margin: 20px 0 5px !important;
	  }
	  h1 {
		font-size: 22px !important;
	  }
	  h2 {
		font-size: 18px !important;
	  }
	  h3 {
		font-size: 16px !important;
	  }
	  .container {
		padding: 0 !important; width: 100% !important;
	  }
	  .content {
		padding: 0 !important;
	  }
	  .content-wrap {
		padding: 10px !important;
	  }
	  .invoice {
		width: 100% !important;
	  }
	}
	</style>
	</head>
	
	<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
	
	<table class="body-wrap" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
			<td class="container" width="600" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
				<div class="content" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
					<table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="alert alert-warning" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-weight:900;font-size: 22px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #FF9F00; margin: 0; padding: 20px;" align="center" bgcolor="#FF9F00" valign="top">
							  '.$subject.'
							</td>
						</tr><tr style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 18px;text-align:center; fon-weight:700; padding-top:40px;color:#000 !important;  vertical-align: top; margin: 0; padding: 20px;" valign="top">
						'.$message.'
							
						<div class="footer" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
						<table width="100%" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="aligncenter content-block" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top"><a href="javascript:void(0)" style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">Unsubscribe</a> from these alerts.</td>
							</tr></table></div></div>
			</td>
			<td style="font-family: '.$font.',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
		</tr></table></body>
	</html>';
	}
	
function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	// $mail->SMTPDebug=3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = "587"; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "smartauction.admn@gmail.com";
	$mail->Password = 'Aa@2019!9';
	$mail->SetFrom("smartauction.admn@gmail.com");
	$mail->Subject = $subject;
	$mail->Body = getTemplate($subject,$msg);
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
	return TRUE;
	}
}

function smtp_bulk_mailer($to,$template){
	$mail = new PHPMailer(); 

	global $conn;

	$tempData=mysqli_query($conn,"SELECT `name`, `img`, `title`, `text`, `link` FROM `bnmi_campaign` WHERE `id`=$template ");
	$dataT=mysqli_fetch_assoc($tempData);
	if($dataT['link']!=NULL || $dataT['link'] != '#'){ 
		$button = '<a href="'.$dataT['link'].'" style=" display: inline-block; text-decoration: none; color: #fff; border-radius: 5px; background: #ea0009; padding: 10px 50px; font-size: 16px; border-radius: 25px; font-weight: 600; " >Click Here</a >';
	}else{
		$button=' ';
	}

	$message = '<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Email Template</title>
	</head>
	<body style="background-color: #1abc9c;font-family: "Nunito", sans-serif;">
		<div style="
		justify-content: center;
		align-items: center;
		display: flex;
		flex-direction: column;
		max-width: 600px;
		margin:30px auto;
		box-shadow: 0px 10px 30px 0px rgba(0,0,0,0.20);
		padding: 30px;
		background-color: #fff;
		">
			<div class="logo">
				<h1 class="fw-bold">
					'.SITE_NAME.'
				</h1>
			</div>
			'.$image.'
			<div class="heading">
				<h2>
					'.$dataT['img'].'
				</h2>
			</div>
			<div class="message">
				<p style="text-align: center; color:rgba(150, 150, 150, 0.911);">
					'.$dataT['text'].'
				</p>
				'.$button.'
			</div>
		</div>
	</body>
	</html>';
	// $mail->SMTPDebug=3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = "587"; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "smartauction.admn@gmail.com";
	$mail->Password = 'Aa@2019!9';
	$mail->SetFrom("smartauction.admn@gmail.com");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	foreach($to as $singleemail){
		$mail->AddAddress($singleemail);   
	}  
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		return TRUE;
	}
}
// echo smtp_mailer($to,$subject, $msg);

function auctionMail($emails,$subject, $msg){
	$mail = new PHPMailer(); 
	// $mail->SMTPDebug=3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = "587"; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "smartauction.admn@gmail.com";
	$mail->Password = 'Aa@2019!9';
	$mail->SetFrom("smartauction.admn@gmail.com");
	$mail->Subject = $subject;
	$mail->Body = getTemplate($subject,$msg);
	if(is_array($emails)){
		foreach($to as $singleemail){
			$mail->AddAddress($singleemail);   
		} 
	}else{
		$mail->AddAddress($to);
	}
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		return TRUE;
	}
}
?>
