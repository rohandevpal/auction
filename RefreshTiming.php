<?php
 require_once 'inc/config.php';
$productname = $_POST['productid'];
  $refresh = mysqli_query($conn,  "SELECT * FROM `bnmi_Time` WHERE `auction_id`='$productname'");
  $refershTime = mysqli_fetch_assoc($refresh);
        echo date('Y-m-d H:i:s', strtotime('+3 minutes', strtotime($refershTime['time'])));
    
?>

  