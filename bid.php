<?php
require_once 'inc/config.php';
$full = date('Y-m-d H:i:s');
$productname = $_POST['productid'];
$firstAmount = mysqli_query($conn, "SELECT  amount FROM " . $tblPrefix . "bid WHERE auction_id =  $productname");
$bidingAmount =  mysqli_query($conn, "SELECT MAX(amount)  FROM " . $tblPrefix . "bid WHERE auction_id =  $productname");
$inc = mysqli_fetch_assoc($bidingAmount);
if($_SESSION['userWallet'] < 1){
    echo "error";
}else{
    $_SESSION['userWallet']  = $_SESSION['userWallet'] - 1;
    
    $userid = $_SESSION['user']['name'];
    $query = mysqli_query($conn, "SELECT * FROM " . $tblPrefix . "auctions WHERE id = $productname");
    $data = mysqli_fetch_assoc($query);
    $title = $data['name'];
    $userEmail = $_SESSION['user']['email'];
    $Amount = $data['starting_price'];
    
    $result;
    if (mysqli_num_rows($firstAmount) > 0) {
        $incrementAmount = $inc['MAX(amount)'] + 1;
        $insert = mysqli_query($conn, "INSERT INTO " . $tblPrefix . "bid(`userdata`,`email`, `amount`, `auction_id`,auction_name) VALUES ('$userid','$userEmail','$incrementAmount','$productname','$title')");
        $insert = mysqli_query($conn,"UPDATE `bnmi_Time` SET `time`='$full' WHERE  `auction_id`='$productname' ");
        $result = mysqli_fetch_assoc($insert);
    } else {
        $insert = mysqli_query($conn, "INSERT INTO " . $tblPrefix . "bid(`userdata`, `email`,`amount`, `auction_id`,auction_name) VALUES ('$userid','$userEmail','$Amount','$productname','$title')");
        $insert = mysqli_query($conn,"UPDATE `bnmi_Time` SET `time`='$full' WHERE  `auction_id`='$productname ");
    }
    
    if ($insert) {
      echo "time update";
    }
}
