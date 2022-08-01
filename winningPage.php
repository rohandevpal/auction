<?php require_once 'inc/config.php';
$pageName = "Winner";
$topWining = mysqli_query($conn, "SELECT * FROM " . $tblPrefix . "bid  ORDER BY " . $tblPrefix . "bid. amount DESC LIMIT 3");
if(isset($_GET['auction'])){
  $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['auction']));
  $winnerSql = mysqli_query($conn,"SELECT  bw.Winner_email,bw.amount, us.name,us.img FROM `".$tblPrefix."winnig` bw LEFT JOIN `".$tblPrefix."users` us ON bw.Winner_email = us.email WHERE bw.auction_id = $id");
 $winner = mysqli_fetch_assoc($winnerSql);

  $bidSql = mysqli_query($conn,"SELECT bb.email,bb.amount, us.name,us.img FROM `".$tblPrefix."bid` bb LEFT JOIN `".$tblPrefix."users` us ON bb.email = us.email WHERE bb.auction_id = $id ORDER BY `bb`.`amount` DESC");
}else{
  $winnerSql = mysqli_query($conn,"SELECT bw.Winner_email,bw.amount,ac.name as auction,us.name,us.email FROM `".$tblPrefix."winnig` bw LEFT JOIN `".$tblPrefix."auctions` ac ON bw.auction_id = ac.id LEFT JOIN `".$tblPrefix."users` us ON bw.winner_email = us.email");
   "SELECT bw.Winner_email,bw.amount,ac.name as auction,us.name,us.email FROM `".$tblPrefix."winnig` bw LEFT JOIN `".$tblPrefix."auctions` ac ON bw.auction_id = aw.id LEFT JOIN `".$tblPrefix."users` us ON bw.winner_email = us.email";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'inc/head.php'; ?>
    <link rel="stylesheet" href="./assets/style/auctionpage.css" />
    <link rel="stylesheet" href="./assets/style/winningPage.css" />

    <style> 
.user_popup_container {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background-color: rgba(0, 0, 0, 0.522);
  display: flex;
  justify-content: center;
  align-items: center;
}

.popup_inner_div {
  width: 500px;
  background-color: var(--MainColor);
  border-radius: 8px;
  position: relative;
}

.popup_inner_div i {
    position: absolute;
    right: 20px;
    top: 20px;
    cursor: pointer;
}

.popup_inner_div h4 {
  font-size: 30px;
}

    </style>
</head>


<body>
    <!-- Header -->
    <?php require_once 'inc/header.php'; ?>
    <!-- Header -->
    <main>
    <?php if(isset($_GET['auction'])){
        $auction_id = $_GET['auction'];
    $winningData = mysqli_query($conn, "SELECT * FROM `bnmi_winnig` WHERE auction_id ='$auction_id'");
   
    $winresult = mysqli_fetch_assoc($winningData);


      echo ' <div class="user_popup_container">
            <div class="popup_inner_div p-3 text-center">
                <i class="fa-solid fa-xmark close_button"></i>
                <img src="./assets/img/31177-winning-cup.gif" class="img-fluid w-25" alt="">
                <h4>Congratulations!</h4>
                <p class="mt-3 fw-bold" style="font-size:20px;">'.$winresult['winner_name'].'!</p>
                <p class="mt-3 text-capitalize ">You have won <span class="fw-bold">'.$winresult['auction_name'].' </span>in CA$ '.$winresult['amount'].'</p>
            </div>
        </div>';
    }?>

        <!-- winning> -->
        <section class="winner_section side_padding">
            <div class="container-fluid padding_one">
                <!-- Auction win heading -->
                <div class="row">
                    <div class="col-12">
                        <h1 class="fw-bold text-center">AUCTION LIST</h1>
                    </div>
                </div>
                <!-- Auction win heading -->
                <!-- Auction win cards section -->
                <div class="row pt-5 pb-3 justify-content-center">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-5 col-xxl-3 mb-5 mb-lg-0 d-none">
                        <!-- auction win card -->
                        <?php if(isset($_GET['auction'])){?>
                        <div class="AuctionWinner_Card_div d-none">
                            <!-- Acution winning inner card -->
                            <div class="Auction_Winner_inner_card text-center">
                                <h3 class="mt-2">GRAND AUCTION WINNER</h3>
                                <div class="User_Winner py-3 mt-3 mb-2">
                                    <!-- all winner users -->
                                    <div class="User_Winner_Div second_winner">
                                        <!-- user content -->
                                        <div class="user_Price_Contnet">
                                            <p><?php echo $winner['name']; ?></p>
                                            <h3>CA$ <?php echo $winner['amount']; ?></h3>
                                        </div>
                                        <!-- user content -->
                                    </div>
                                    <!-- all winner users -->
                                </div>
                                <!-- <div class="Winner_Time py-2 mt-5 mb-2"></div> -->
                            </div>
                            <!-- Acution winning inner card -->
                            <div class="auctionCard_Content py-3">
                                <!-- <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">70%</div>
                  </div> -->
                                <!-- All Card -->
                                <?php
                  $i = 1;
                    while ($winres = mysqli_fetch_assoc($topWining)) {
                      if($i <= 3 ){
                        echo '<div class="allCard_div my-3">
                        <div class="row  gx-0">
                        <div class="col-12 col-sm-12 col-md-2 d-flex justify-content-center align-items-center">
                          <p>' . $i . '</p>
                        </div>
                        <div class="col-12 col-sm-12 col-md-2 d-flex justify-content-center my-2 my-md-0">
                        <div class="uerWinner_icons">
                            <i class="fas fa-user"></i>
                          </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-5 d-flex justify-content-center align-items-center">
                          <p>' . $winres['userdata'] . '</p>
                        </div>
                        <div
                          class="col-12 col-sm-12 col-md-2 d-flex justify-content-center align-items-center my-2 my-md-0">
                          <p>CA$'  . $winres['amount'] . '</p>
                          </div>
                          </div>
                          </div>';
                          }
                      $i++;
                    }
                  ?>
                                <!-- All Card -->
                            </div>
                        </div>
                        <?php }?>
                        <!-- auction win card -->
                    </div>
                    <div
                        class="col-12 col-sm-12 col-md-12  <?php if(isset($_GET['auction'])){ echo "col-lg-7 col-xxl-9";}else{echo "col-lg-12 col-xxl-12";}?>">
                        <!-- all auction winner -->
                        <div class="row">
                            <div class="col-12">
                                <div class="auctionList_div_content">
                                    <div class="row">
                                        <div
                                            class="col-12 col-sm-12 col-md-12 d-flex align-items-center justify-content-center justify-content-md-center">
                                            <h2 class="text-white mb-3 mb-md-0">AUCTION LIST</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <?php
              $j = 1;
              if(isset($_GET['auction'])){
                while ($res = mysqli_fetch_assoc($bidSql)) {
                ?>
                            <div class="col-12 my-md-2 my-lg-4 my-xxl-0 col-xxl-4   d-flex justify-content-center">
                                <div class="row user_sub_cards mt-3">
                                    <div
                                        class="col-12 col-sm-12 col-md-6  d-flex align-items-center justify-content-center justify-content-md-start mb-3 mb-md-0">
                                        <div class="user_sub_img ">
                                            <img src="./assets/img/user/<?php echo $res['img']?>" alt=""
                                                class="img-fluid">
                                        </div>
                                        <div class="user_sub_card ms-4 ">
                                            <h1><?php echo $res['name'] ?></h1>
                                            <p class="light_para">CA$ <?php echo $res['amount'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                } }else{
                  while ($res = mysqli_fetch_assoc($winnerSql)) { ?>
                            <div class="col-12 my-4 my-xxl-0 col-xxl-4 mt-5 d-flex justify-content-center">
                                <div class="row user_sub_cards mt-3">
                                    <div
                                        class="col-12 col-sm-12 col-md-6  d-flex align-items-center justify-content-center justify-content-md-start mb-3 mb-md-0">
                                        <div class="user_sub_card ms-4 ">
                                            <h1><?php echo $res['name'] ?></h1>
                                            <p class="light_para">Auction: <?php echo $res['auction'] ?></p>
                                            <p class="light_para">User: <?php echo $res['name'] ?></p>
                                            <p class="light_para">Email: <?php echo $res['email'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } } ?>
                            <!-- Auction win cards section -->
                        </div>
        </section>
        <!-- winning> -->
    </main>
    <!-- Footer -->
    <?php require_once 'inc/footer.php'; ?>
    <!-- Footer -->
    <?php require_once 'inc/js.php'; ?>
</body>

</html>