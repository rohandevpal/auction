<?php
   require_once 'inc/config.php';
   $pageName="Auction";

   if(isset($_GET['id']) && isset($_GET['auction'])){
       $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
       $query = mysqli_query($conn,"SELECT ac.id, ac.cat, ac.type, ac.name, ac.image, ac.short_desc, ac.desc, ac.store_price, ac.starting_price, ac.entry_price, ac.starting_from, ac.capacity,ct.name as category FROM `".$tblPrefix."auctions` ac LEFT JOIN `".$tblPrefix."category` ct ON ac.cat = ct.id WHERE ac.id = $id");
       if(mysqli_num_rows($query) == 0){
           $_SESSION['toast']['type']="error";
           $_SESSION['toast']['type']="Something went wrong, Please try again later.";
           header("location:index.php");
       }else{
           $data = mysqli_fetch_assoc($query);
       }
   }else{
       $_SESSION['toast']['type']="error";
       $_SESSION['toast']['type']="Something went wrong, Please try again later.";
    header("location:index.php");
   }
   $usersJoined = getUsersJoined($data['id']);
   $totalUsers = $data['capacity'];
//    $percentage = ($usersJoined * $totalUsers) / 100;
   $percentage = 50;
// Enter Auction
   if(isset($_POST['enterAuction'])){
       $user = $_SESSION['user']['id'];
       $auctionId = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
       if(validateWallet($data['entry_price'])){
           $enterAuction = mysqli_query($conn,"INSERT INTO `".$tblPrefix."auction_participant`(`auction_id`, `user_id`, `date_time`, `status`) VALUES ('$auctionId','$user','$cTime',2)");
           if($enterAuction == TRUE){
                makeAuctionTransaction($data['entry_price'],$auctionId);
                  $mailid = $_GET['id'];
               $mailname = $_GET['auction'];
               $_SESSION['toast']['type']="alert";
               $_SESSION['toast']['msg']="You've Successfully Registed";
               $confirmation = $_SESSION['user']['email'];
                 $url =  SITE_URL."auction.php?auction=".$mailname."&id=".$auctionId;
$subject =  'Thank you for Participating';
$msg = '<table width="100%" cellpadding="0" cellspacing="0" style="font-family: "Helvetica Neue, Helvetica, Arial,sans-serif",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: "Helvetica Neue, Helvetica, Arial,sans-serif",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: "Helvetica Neue, Helvetica, Arial,sans-serif ,Helvetica,Arial,sans-serif"; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
<strong style="font-family: "Helvetica Neue, Helvetica, Arial,sans-serif",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">Thank you for Subscribe auction</strong> '.$mailname.'
</td>

<br> <br>
</tr><tr style="font-family: "Helvetica Neue, Helvetica, Arial,sans-serif",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: "Helvetica Neue, Helvetica, Arial,sans-serif",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
This is your official confirmation. Thank you for participating in the auction. The auction will start once the room is complete. Stay tuned for more updates.</td>
<br> <br>
</tr><tr style="font-family: "Helvetica Neue, Helvetica, Arial,sans-serif",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: "Helvetica Neue, Helvetica, Arial,sans-serif",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
<br> <br>
<a href="'.$url.'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;color:#fff;text-decoration:none;line-height:2em;font-weight:bold;text-align:center;display:inline-block;border-radius:5px;text-transform:capitalize;background-color:#348eda;margin:0;border-color:#348eda;border-style:solid;border-width:10px 20px" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://www.mailgun.com&amp;source=gmail&amp;ust=1646889420029000&amp;usg=AOvVaw1mhNDLJn3LvfT6oCabEya7">Check Auction</a></td>
</tr>
</tr></table></td>
</tr></table>';
               smtp_mailer($confirmation,$subject, $msg);
               header("refresh:0");
               exit();
           }else{
            $_SESSION['toast']['type']="error";
            $_SESSION['toast']['msg']="Something went wrong, Please try again later";
            header("refresh:0");
               exit();
           }

       }else{
        $_SESSION['toast']['type']="warning";
        $_SESSION['toast']['msg']="You've Insufficient Token Wallet Balance";
        header("refresh:0");
        exit();
      }
    }
    
if (isset($_POST['participateAuction'])) {
    $userId = $_SESSION['user']['id'];
    $auctionId = mysqli_real_escape_string($conn, ak_secure_string($_GET['id']));
    $query = mysqli_query($conn, "INSERT INTO `" . $tblPrefix . "attendance`(`auction_id`, `user_id`, `date_time`) VALUES ('$auctionId','$userId','$cTime')");
      if ($query == true) {

          $_SESSION['userWallet'] = getWallet($_SESSION['user']['id']) - $data['starting_price'];

          $_SESSION['toast']['type'] = "success";
          $_SESSION['toast']['msg'] = "Entered Auction Successfully";

          $auctionName = $_GET['auction'];
          $auctionid = $_GET['id'];

          header('location:bets.php?auction=' . $auctionName . '&id=' . $auctionid . '');
          exit();
      }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'inc/head.php';?>
    <link rel="stylesheet" href="./assets/style/auctionpage.css" />
    <link rel="stylesheet" href="./assets/style/ended.css" />
</head>

<body>
    <!-- Header -->
    <?php require_once 'inc/header.php';?>
    <!-- Header -->

    <!-- Main -->
    <main>
        <!---Card-->
        <section class="py-5 px-3 mb-5">
            <div class="container">
                <div class="row g-3">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                        <img src="./assets/img/auction/<?php echo $data['image']?> " alt="<?php echo $data['name']?>"
                            class="d-block w-75 img-fluid img_slide" />
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6  ">
                        <h3 class="fw-bold"><?php echo $data['name']?> </h3>
                        <h5><?php echo $data['category']?> </h5>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                            <p><?php echo $data['short_desc']?></p>
                        </div>
                         <div class="row">
                            <div class="col-6">
                                <p class="text-muted fw-bolder">Auction scheduled on:</p>
                            </div>
                            <div class="col-6">
                                <?php echo date("d/m/Y h:i:s a",strtotime($data['starting_from']))?>
                            </div>

                            <div class="col-6">
                            <p class="text-muted fw-bolder">Store price:</p>
                            <p class="text-muted fw-bolder">New price:</p>
                            </div>
                            <div class="col-6">
                            <p class="me-5">$<?php echo $data['store_price']?></p>
                            <p class=me-5>$<?php echo $data['starting_price']?></p>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <div class="card border-0 ">
                                <div class="card-body">
                                    <?php echo htmlspecialchars_decode($data['desc']);?>
                                </div>
                            </div>
                        </div>
                        <div class="row py-4">
                            <div class="col-6">
                                <p class="text-muted fw-bolder auctionText">Auction Starting In :</p>
                            </div>
                            <div class="col-6" id="demo"></div>
                            <div class="col-6" id="demo2" style="display:none;"></div>
                        </div>
                        <div class="timeComplete" style="display:none;"></div>
                        <?php if (isset($_SESSION['user'])) {
              if (isUserAlreadyInAuction($_GET['id'])) {
                if (validateWallet($data['entry_price'])) {
            ?>

                        <form method="POST">
                            <button type="submit"
                                class="btn btn-lg rounded-pill h4 fw-bolder btn-danger buy_Button mb-5 paticipate_button"
                                name="enterAuction">Participate In <?php echo $data['entry_price']; ?> Tokens</button>
                        </form>
                        <?php } else { ?>
                        <a target="_blank" href="buy-token.php"
                            class="btn btn-lg rounded-pill h4 fw-bolder btn-danger buy_Button mb-5"
                            name="enterAuction">Please top up
                            your tokens</a>
                        <?php }
              } else { ?>
                        <form method="POST">
                            <button type="submit"
                                class="btn btn-lg rounded-pill h4 fw-bolder btn-danger buy_Button mb-5 enterAuction"
                                style="display:none;" name="participateAuction">
                                Enter Auction
                            </button>
                        </form>

                        <?php }
            } else { ?>
                        <a target="_blank" href="login.php?auction=<?php echo $_GET['auction']?>&id=<?php echo $_GET['id']?>"
                            class="btn btn-lg rounded-pill h4 fw-bolder btn-danger buy_Button mb-5 login-btn">Please
                            Login
                            to Enter Auction</a>
                        <?php } ?>
                    </div>
                </div>
        </section>
        <!-- News Letter Section -->
    </main>
    <!-- Main -->

    <!-- Footer -->
    <!-- Footer -->
    <?php require_once 'inc/footer.php';?>

    <!-- Footer -->
    <!-- Footer -->


    <?php require_once 'inc/js.php';?>
    <script>
    const timerFunction = function(distance, elem) {
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById(elem).innerHTML = days + "d " + hours + "h " +
            minutes + "m " + seconds + "s ";


        if (distance < 0) {

            <?php if (isUserAlreadyInAuction($_GET['id'])) { ?>
            document.getElementById(elem).innerHTML = "auction has been closed";
            document.querySelector('.paticipate_button').style.display = "none";
            document.querySelector('. login-btn').style.display = "none";

            <?php }
     
        ?>
        }

        if (minutes == 0 && seconds < 3) {
            window.location.reload();
        }

        // window.location.reload();
    }


    // Set the date we're counting down to
    // var countDownDate = new Date("Jan 5, 2024 15:37:25").getTime();
    var countDownDate = new Date("<?php echo $data['starting_from']; ?>").getTime();
    // var countDownDate = new Date('feb 3, 2022 10:20:25').getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // show the time and distance
            timerFunction(distance, 'demo');

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);

                document.querySelector(".enterAuction").style.display = 'block'
                document.getElementById("demo").innerHTML = "Started";
                document.getElementById("demo2").style.display = "block";

                document.querySelector(".timeComplete").style.display = 'block'
                // document.querySelector(".alreadyInAuction").style.display = 'none'

                document.querySelector(".auctionText").innerHtml = 'Entry Closing In'




                var countDownDate2 = new Date(
                        "<?php echo date('Y-m-d H:i',strtotime('+5 minutes',strtotime($data['starting_from'])));?>")
                    .getTime();


                // Update the count down every 1 second
                var x2 = setInterval(function() {

                    // Get today's date and time
                    var now2 = new Date().getTime();

                    // Find the distance between now2 and the count down date
                    var distance2 = countDownDate2 - now2;

                    // show the time and distance
                    timerFunction(distance2, 'demo2');

                    document.querySelector('.auctionText').innerHtml = `Entry Closing In`

                    if (distance2 < 0) {
                        clearInterval(x2);

                        document.querySelector(".enterAuction").style.display = 'none'
                        document.getElementById("demo").innerHTML =
                            `Auction has been started and Entry is closed`;
                        const elem = document.querySelector('.timeComplete');
                        const elem2 = document.querySelector('#demo2');
                        elem.style.display = 'none';
                        elem2.style.display = 'none';
                    }
                }, 1000);
            }
        },
        1000);
    </script>


</body>

</html>