<?php
require_once 'inc/config.php';
$full = date('Y-m-d H:i');
$data = mysqli_query($conn, "SELECT ap.auction_id,ap. user_id as auctionParticipitant, us.name,us.email,ba.name, Date_Add(ba.starting_from , INTERVAL -15 MINUTE )FROM `bnmi_auction_participant` ap LEFT JOIN `bnmi_users` us ON ap.user_id = us.id LEFT JOIN `bnmi_auctions` ba ON ap.auction_id = ba.id Where Date_Add(ba.starting_from , INTERVAL -15 MINUTE ) = '$full' ");
$queryCards = mysqli_query($conn, "SELECT `id`, `name`, `image`, `store_price`, `starting_price`, Date_Add(starting_from, INTERVAL -15 MINUTE ), `capacity` FROM `" . $tblPrefix . "auctions` WHERE status = 2 AND   Date_Add(starting_from, INTERVAL -15 MINUTE )= '$full' ");

$array = array();
while ($res = mysqli_fetch_assoc($data)) {
  array_push($array, $res['email']);
}
while ($postpond = mysqli_fetch_assoc($queryCards)) {
  // print_r($postpond);
  $auctionName = $postpond['name'];
  $auctionid = $postpond['id'];
  $auctionName;
  $usersJoined = getUsersJoined($postpond['id']);
  $totalUsers = $postpond['capacity'];
  $percentage = ($usersJoined / $totalUsers) * 100;
  $time = mysqli_query($conn, "SELECT * FROM `bnmi_auctions` WHERE id = '$auctionid' AND name = '$auctionName'");
  echo $start = mysqli_fetch_assoc($time);
  print_r($start);
  if ($percentage <  99) {
    $incdate =  date('Y-m-d H:i:s', strtotime('+1 week', strtotime($start['starting_from'])));
    $update =  mysqli_query($conn, "UPDATE  bnmi_auctions  SET starting_from ='$incdate'   WHERE `bnmi_auctions`.`name` = '$auctionName' ");
    $auction_check = mysqli_query($conn,"SELECT * FROM `bnmi_Time` WHERE `auction_id`='$auctionid'");
    if(mysqli_num_rows($auction_check)>0){
        $data = mysqli_query($conn,"UPDATE `bnmi_Time` SET `time`='$incdate' WHERE  `auction_id`='$auctionid' ");
      }
      else{
          $ids = mysqli_insert_id($conn);
          $data = mysqli_query($conn,"INSERT INTO `bnmi_Time`(`auction_id`, `time`) VALUES ('$auctionid', '$incdate')");
      }
    if ($update) {
      foreach ($array as $post) {
        // print_r($post);
        $subject2 = "Auction Postponed";
        $message2 = "The auction You Participated in (".$postpond['name']."), is postponed until " . date("d-m-y, H:i:s a",strtotime($incdate)) . " Due to the insufficient members in the auction room. <br>
       <a
    href='https://smart-auction.net/auction.php?auction=".$postpond['name']."&id=".$postpond['id']."'
    style='
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif, Helvetica, Arial, sans-serif;
        box-sizing: border-box;
        font-size: 14px;
        color: #fff;
        text-decoration: none;
        line-height: 2em;
        font-weight: bold;
        text-align: center;
        display: inline-block;
        border-radius: 5px;
        text-transform: capitalize;
        background-color: #348eda;
        margin: 0;
        border-color: #348eda;
        border-style: solid;
        border-width: 10px 20px;
    '
    target='_blank'
>
    Check Auction
</a>
";
        smtp_mailer($post, $subject2, $message2);
      }
    }
  } 
  else {
    foreach ($array as $value) {
      $subject1 = "Auction starting in 15 mins, JOIN NOW";
      $message1 = "Auction You Participated in ".$postpond['name'].", Will be starting in 15 mins. Hurry up and join by clicking the below Link <a href='https://smart-auction.net/auction.php?auction=".$postpond['name']."&id=".$postpond['id']."' target='_blank'>Join Here</a>";
      smtp_mailer($value, $subject1, $message1);
    }
  }
}
