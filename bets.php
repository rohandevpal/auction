<?php
require_once 'inc/config.php';
$pageName = "Auction Bets";

if (!isset($_SESSION['user'])) {
  $_SESSION['toast']['msg'] = "Please login to continue.";
  header('location:login.php');
  exit();
}
$productname = "";

if (isset($_GET['id']) && isset($_GET['auction'])) {
  $id = mysqli_real_escape_string($conn, ak_secure_string($_GET['id']));
  $query = mysqli_query($conn, "SELECT * FROM " . $tblPrefix . "auctions WHERE id = $id");
  $refresh = mysqli_query($conn,  "SELECT * FROM `bnmi_Time` WHERE `auction_id`='$id'");
  $bidingAmount =  mysqli_query($conn, "SELECT  userdata, email, MAX(amount) ,auction_id, auction_name FROM " . $tblPrefix . "bid WHERE auction_id = $id ");
  $winassoc = mysqli_fetch_assoc($bidingAmount);
  $refershTime = mysqli_fetch_assoc($refresh);
  $data = mysqli_fetch_assoc($query);
  $productname = $data['name'];
  $totaldata = mysqli_query($conn, "SELECT * FROM `bnmi_attendance`  Where  auction_id = $id ");
  $totaluser = mysqli_num_rows($totaldata);
}

$sql = mysqli_query($conn, "SELECT `id` FROM `" . $tblPrefix . "auction_participant` WHERE auction_id = '" . $_GET['id'] . "' AND user_id = " . $_SESSION['user']['id']);
if (mysqli_num_rows($sql) == 0) {
  $_SESSION['toast']['type'] = "error";
  $_SESSION['toast']['msg'] = "You`re not in auction.";
  header("location:index.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once 'inc/head.php'; ?>

  <link rel="stylesheet" href="./assets/style/howItWorks.css" />
  <link rel="stylesheet" href="./assets/style/bets.css" />
</head>

<body>
  <!-- Header -->
  <?php require_once 'inc/header.php'; ?>
  <!-- Header -->

  <main>
    <!-- bets section -->
    <section class="bets_section side_padding">
      <div class="container-fluid padding_one">
        <div class="row">
          <div class="col-12">
            <h1>Bids</h1>
            <p class="light_para">Welcome Smart Auction Bids page</p>
          </div>
        </div>

        <div class="row py-3">
          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ">
            <div class="bitCards d-flex align-items-center px-3">
              <!-- icon -->
              <div class="bitCard_icon bg_one">
                <img src="./assets/img/auction/<?php echo $data['image'] ?>" alt="">
              </div>
              <!-- icon -->
              <!-- content -->
              <div class="bitCard_Contnet">
                <h1 id="timer">00:00</h1>

                <p class="light_para">Remaining</p>
              </div>
              <!-- content -->
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-4 col-lg-4">
            <div class="bitCards d-flex align-items-center px-3">
              <!-- icon -->
              <div class="bitCard_icon bg_three">
                <img src="./assets/icons&images/Vector.png" alt="">
              </div>
              <!-- icon -->
              <!-- content -->
              <div class="bitCard_Contnet">
                <h1 class="biddata">CA$ <span id="currentbid" class="text-dark"></span></h1>
                <p class="light_para">Current Bid</p>
              </div>
              <!-- content -->
            </div>
          </div>


          <div class="col-12 col-sm-12 col-md-4 col-lg-4">
            <div class="bitCards d-flex align-items-center px-3">
              <!-- icon -->
              <div class="bitCard_icon bg_three">
                <img src="./assets/icons&images/Vector.png" alt="">
              </div>
              <!-- icon -->
              <!-- content -->
              <div class="bitCard_Contnet">
                <h1 class="walletBalance"><?php if ($_SESSION['userWallet'] < 0) {
                                            echo 0;
                                          } else {
                                            echo  $_SESSION['userWallet'];
                                          };
                                          ?></h1>
                <p class="light_para">Tokens</p>
              </div>
              <!-- content -->
            </div>
          </div>


        </div>
        <div class="row mt-2 mt-md-5 mb-3">
          <div class="col-12 col-sm-12 col-md-6 text-center text-md-start">
            <h1 class="mb-4 mb-md-0">Active Bids</h1>
          </div>
          <div class="col-12 col-sm-12 col-md-6 d-flex justify-content-center  justify-content-md-end">
            <button class="placeabit_Button" name="placebid" id="placeBid">Place a Bid</button>
          </div>
        </div>

        <div class="row py-3 bidsShow" id="bidsShow">

        </div>

      </div>
    </section>
    <!-- bets section -->
  </main>

  <!-- Footer -->
  <?php require_once 'inc/footer.php'; ?>
  <!-- Footer -->

  <?php require_once 'inc/js.php'; ?>

  <script>
    const timerFunction = function(distance, elem) {
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      // Display the result in the element with id="demo"
      document.getElementById(elem).innerHTML =
        minutes + "m " + seconds + "s ";

      if (distance < 0) {
        document.getElementById('timer').innerHTML =
          "00" + "m " + "00" + "s ";
        // winning();
      }
      //   if (minutes == 0 && seconds < 2){

      // }
    }

    function bidtiming() {
      $.ajax({
        type: "POST",
        url: 'RefreshTiming.php',
        data: {
          productid: <?php echo $_GET['id'] ?>,
        },
        success: function(timing) {
          // $('#bidsShow').html(biddata)
          var countDownDate2 = new Date(timing).getTime();
          var now2 = new Date().getTime();
          distance2 = countDownDate2 - now2;
          timerFunction(distance2, 'timer');


          if (distance2 < 0) {
            winning();
            document.getElementById('timer').innerHTML =
              "00" + "m " + "00" + "s ";
          }
          if(minutes==0 && seconds <2 )
            winning();
        }
      })
    }


    function winning() {
      $.ajax({
        type: "POST",
        url: 'winconfirm.php',
        data: {
          id: <?php echo $_GET['id'] ?>,
        },
        success: function(windata) {
          <?php $url = 'winningPage.php?auction=' . $id; ?>
          if (windata == 1) {
            <?php $url = 'winningPage.php?auction=' . $id; ?>
            window.location = `<?php echo $url ?>`
          } else {
            <?php $url = 'winningPage.php?auction=' . $id; ?>
            window.location = `<?php echo $url ?>`
          }

        }
      })
    }
    $('.placeabit_Button').on('click', function(e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: 'bid.php',
        data: {
          productid: <?php echo $_GET['id'] ?>
        },
        success: function(data) {
          if (data == 'error') {
            alertify.alert('Insuficient Ballance, Please top up your wallet to proceed. ')

          } else {
            document.querySelector(`.walletBalance`).textContent = document.querySelector(`.walletBalance`).textContent - 1;
          }

          if (data == "time update") {


          }
          biddata()

        }
      });
    })

    function biddata() {
      $.ajax({
        type: "POST",
        url: 'biddata.php',
        data: {
          productid: <?php echo $_GET['id'] ?>,

        },
        success: function(biddata) {
          $('#bidsShow').html(biddata)
        }
      })
    }

    function biding() {
      $.ajax({
        type: "POST",
        url: 'current_bidding.php',
        data: {
          productid: <?php echo $_GET['id'] ?>,

        },
        success: function(biddata) {

          $('#currentbid').html(biddata)

        }
      })
    }

    setInterval(function() {
      biddata();
      bidtiming()
      biding();


    }, 1000);
  </script>
</body>

</html>