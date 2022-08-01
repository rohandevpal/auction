<?php
require_once 'inc/config.php';
 $productname = $_POST['id'];
// $productname = 16;
$query = mysqli_query($conn, "SELECT * FROM " . $tblPrefix . "auctions WHERE id = '$productname'");

$bidingAmount =  mysqli_query($conn, "SELECT * FROM " . $tblPrefix . "bid WHERE auction_id ='$productname' ORDER BY `bnmi_bid`.`amount` DESC LIMIT 1");
// echo "SELECT * FROM " . $tblPrefix . "bid WHERE auction_id ='16' ORDER BY `bnmi_bid`.`amount` DESC LIMIT 1";
$winassoc = mysqli_fetch_assoc($bidingAmount);
$userName = $winassoc['userdata'];
$winamount = $winassoc['amount'];
$auctionid = $winassoc['auction_id'];
$auctionname = $winassoc['auction_name'];
$useremail = $winassoc['email'];
$data = mysqli_fetch_assoc($query);
$productname = $data['name'];
// echo "INSERT INTO " . $tblPrefix . "winnig(`userId`,`winner_name`, `Winner_email`, `amount`, `auction_id`,`auction_name`) VALUES ('$userName','$useremail','$winamount','$auctionid' , '$auctionname')";
// $data =  mysqli_query($conn, "INSERT INTO " . $tblPrefix . "winnig(`winner_name`, `Winner_email`, `amount`, `auction_id`,`auction_name`) VALUES ('$userName','$useremail','$winamount','$auctionid' , '$auctionname'");
// if ($data) {
//     $auctionclose =  mysqli_query($conn,"UPDATE `bnmi_auctions` SET `status` = '3' WHERE id = '$auctionid';");
//     if (updateWallet($winamount)) {
//         makeAuctionTransaction($winamount, $auctionid);
//         $subject2 = "Congratulations for '.$auctionname.'";
//         $message2 = "Congratulations '.$userName.' you have Win '.$auctionname.' in '.$winamount .'";
//         smtp_mailer($useremail, $subject2, $message2);
//         echo 1;
//     }
//     echo "yes";
// }
$winnercheck = mysqli_query($conn, "SELECT * FROM " . $tblPrefix . "winnig WHERE auction_id = '$auctionid'");
// echo "SELECT * FROM " . $tblPrefix . "winnig WHERE auction_id = '$auctionid";

if (mysqli_num_rows($winnercheck) > 0) {
    echo 0;
     $auctionclose =  mysqli_query($conn,"UPDATE `bnmi_auctions` SET `status` = '3' WHERE id = '$auctionid';");
} else {
    $bidinginsert =  mysqli_query($conn, "INSERT INTO " . $tblPrefix . "winnig(`winner_name`, `Winner_email`, `amount`, `auction_id`,`auction_name`) VALUES ('$userName','$useremail','$winamount','$auctionid' , '$auctionname')");
    echo "INSERT INTO " . $tblPrefix . "winnig(`winner_name`, `Winner_email`, `amount`, `auction_id`,`auction_name`) VALUES ('$userName','$useremail','$winamount','$auctionid' , '$auctionname'))";
    $auctionclose =  mysqli_query($conn,"UPDATE `bnmi_auctions` SET `status` = '3' WHERE id = '$auctionid';");
    if ($bidinginsert) {
        echo "done";
        if (updateWallet($winamount)) {
            makeAuctionTransaction($winamount, $auctionid);
            $subject2 = "Congratulations for '.$auctionname.'";
            $message2 = "Congratulations '.$userName.' you have Win '.$auctionname.' in '.$winamount .'";
            smtp_mailer($useremail, $subject2, $message2);
            echo 1;
        }
        if($auctionclose){
            echo 2;
        }
    }
    else{
        echo "no";
    }
}
