<?php
  require_once 'inc/config.php';
  $pageName="Wallet";

  if(!isset($_SESSION['user'])){
    $_SESSION['toast']['msg'] = "Please login to continue.";
    header('location:login.php');
    exit();
 }

  $data = mysqli_query($conn,"SELECT `id`, `user`, `package`, `data`, `date_time` FROM `".$tblPrefix."wallet_transactions` WHERE user = ".$_SESSION['user']['id']);
  $data1 = mysqli_query($conn,"SELECT `user_id`, `auction_id`, `token`, `date_time` FROM `".$tblPrefix."auction_transactions` WHERE user_id = ".$_SESSION['user']['id'] );

  $arr1 = array();
  while($d =mysqli_fetch_assoc($data)){
    array_push($arr1,$d);
  }
  $arr2 = array();
  while($d =mysqli_fetch_assoc($data1)){
    array_push($arr2,$d);


  }
    $array = array_merge($arr1,$arr2);

  function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1['date_time']);
    $datetime2 = strtotime($element2['date_time']);
    return $datetime1 - $datetime2;
  } 
    
  usort($array, 'date_compare');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once 'inc/head.php';?>
  
  <link rel="stylesheet" href="./assets/style/content.css" />
  <link rel="stylesheet" href="./assets/style/howItWorks.css" />
  <link rel="stylesheet" href="./assets/style/userProfile.css" />
  <link rel="stylesheet" href="./assets/style/wallet.css" />
</head>

<body>
  <!-- Header -->
  <?php require_once 'inc/header.php';?>

  <!-- Header -->

  <main>
    <!-- Banner section -->
    <section class="Banner_Section_div">
      <h1 class="text-white banner_heading">MY <span>WALLET</span></h1>
    </section>
    <!-- Banner section -->

    <!-- My BET -->
    <div class="My_Bet_section padding_one main_bg">
      <div class="container-fluid side_padding">
        <!-- User Profile div -->
        <div class="row">
          <div class="col-12 py-5 user_margin_class">
            <div class="user_products_card d-flex align-items-center">
              <div class="user_CR d-none" >
                <img src="./assests/icons&images/mybit/julian-wan-WNoLnJo7tS8-unsplash.jpg" alt=""  class ="d-none"/>

                <!-- <div class="edit_option">
                  <img src="./assests/icons&images/mybit/pencil 1.png" alt="" />
                </div> -->
              </div>

              <div class="ms-4 mt-5 mt-mb-0">
                <h3><?php echo   $_SESSION['user']['name'];?> </h3>
                <p><?php echo   $_SESSION['user']['email'];?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- My BET -->

    <section class="wallet main_bg pb-5">
      <div class="container">
        <div class="row">
          <!-- My Wallet Desing -->
          <div class="row  justify-content-center">

            <div class="col-12">
              <div class="d-flex BalanceDiv justify-content-between align-items-center">
                <h1>Balance</h1>
                <p><?php echo getWallet($_SESSION['user']['id']);?> <span>Tokens</span></p>
              </div>

              <div class="AlTranstion mt-3">
                <p class="light_para">Transations</p>

                <?php 
                // echo "<pre/>";
                  foreach(array_reverse($array) as $aa =>$a){
                    // print_r($a);
                    if(array_key_exists('package',$a)){
                        echo '<!-- Credit Transaction -->
                        <div class="row transionDiv">
                          <div class="col-12 col-sm-12 col-md-6">
                          <div class="d-flex align-items-center">
                            <div class="transferMoney_Div upper me-3">
                              <i class="fas fa-plus"></i>
                            </div>
                            <div>
                              <h3>Money Transfer Smart auction</h3>
                              <div class="d-flex mt-2">
                                <p class="light_para">'.date("d/m/Y",strtotime($a['date_time'])).'</p>
                                <p class="light_para ms-3">'.date("H:i:a",strtotime($a['date_time'])).'</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 transferData upperPrice col-sm-12 col-md-6 d-flex justify-content-end">
                          <div>
                            <h3>+'.json_decode($a["data"])->package.'</h3>
                            <p class="light_para mt-1">Transfer</p>
                          </div>
                        </div>
                      </div>';
                    }else{
                      echo '<!-- Debit Transaction -->
                        <div class="row transionDiv">
                          <div class="col-12 col-sm-12 col-md-6">
                            <div class="d-flex align-items-center">
                              <div class="transferMoney_Div lower me-3">
                                <i class="fas fa-minus"></i>
                              </div>
                              <div>
                                <h3>Money Transfer Smart auction</h3>
                                <div class="d-flex mt-2">
                                  <p class="light_para">'.date("d/m/Y",strtotime($a['date_time'])).'</p>
                                  <p class="light_para ms-3">'.date("H:i:a",strtotime($a['date_time'])).'</p>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 transferData lowerPrice col-sm-12 col-md-6 d-flex justify-content-end">
                            <div>
                              <h3> -'.$a['token'].'</h3>
                              <p class="light_para mt-1">Transfer</p>
                            </div>
                          </div>
                        </div> ';
                    }
                  }
                ?>
                

              </div>
            </div>
          </div>
          <!-- My Wallet Desing -->
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <?php require_once 'inc/footer.php';?>

  <!-- Footer -->
  <?php require_once 'inc/js.php';?>
</body>

</html>