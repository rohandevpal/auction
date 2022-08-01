<?php
require_once 'inc/config.php';
$full = date('Y-m-d H:i');
$login_user = mysqli_query($conn, "SELECT ap.auction_id,ap. user_id as auctionParticipitant, us.name,us.email, us.login_status , ba.name, Date_Add(ba.starting_from , INTERVAL -5 MINUTE )FROM `bnmi_auction_participant` ap LEFT JOIN `bnmi_users` us ON ap.user_id = us.id LEFT JOIN `bnmi_auctions` ba ON ap.auction_id = ba.id Where Date_Add(ba.starting_from , INTERVAL -5 MINUTE ) = '$full' AND login_status = 1;");
$array = array();
while ($login_fetch = mysqli_fetch_assoc($login_user)) {
    array_push($array, $login_fetch['email']);
    $capcity_id =  $login_fetch['auction_id'];
    $login_user = mysqli_query($conn, "SELECT * FROM `bnmi_auctions` where id  ='$capcity_id'");
    $capcity_fetch = mysqli_fetch_assoc($login_user);
    $total = $capcity_fetch['capacity'];
    $usersJoined = getUsersJoined($login_fetch['auction_id']);
    print_r($usersJoined);
    $percentage = ($usersJoined / $total) * 100;
    print_r($capcity_fetch);

    if($percentage < 50) {
        $incdate =  date('Y-m-d H:i:s', strtotime('+1 week', strtotime($capcity_fetch['starting_from'])));
        $update =  mysqli_query($conn, "UPDATE  bnmi_auctions  SET starting_from ='$incdate'   WHERE `bnmi_auctions`.`id` = '$capcity_id' ");

        $auction_check = mysqli_query($conn,"SELECT * FROM `bnmi_Time` WHERE `auction_id`='$capcity_id'");
        if(mysqli_num_rows($auction_check)>0){
            $data = mysqli_query($conn,"UPDATE `bnmi_Time` SET `time`='$incdate' WHERE  `auction_id`='$capcity_id' ");
           }
           else{
               $ids = mysqli_insert_id($conn);
               $data = mysqli_query($conn,"INSERT INTO `bnmi_Time`(`auction_id`, `time`) VALUES ('$capcity_id', '$incdate')");
           }
        
        if($update){
            foreach ($array as $post) {
                // print_r($post);
                $subject2 = "postpond";
                $message2 = "Auction You Participated is postpond till " . $incdate . " beacause of members are not online.";
                smtp_mailer($post, $subject2, $message2);
              }
        }
    }


    //   print_r($array);
}
