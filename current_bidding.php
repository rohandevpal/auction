<?php  
require_once 'inc/config.php';
$id = $_POST['productid'];
      $bids_res = mysqli_query($conn, "SELECT * FROM " . $tblPrefix . "bid WHERE auction_id ='$id' ORDER BY `bnmi_bid`.`amount` DESC LIMIT 1");
      $bids = mysqli_fetch_assoc($bids_res);
 echo $amount = $bids['amount'];

      ?>