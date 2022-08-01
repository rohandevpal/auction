<?php
   require_once 'inc/config.php';
   $pageName="Buy Tokens";

   $dataPackagesType1 = mysqli_query($conn,"SELECT `id`, `type`, `name`, `description`, `price`, `sale_price` FROM `".$tblPrefix."packages` WHERE status = 2 AND type = 1");
   $dataPackagesType2 = mysqli_query($conn,"SELECT `id`, `type`, `name`, `description`, `price`, `sale_price` FROM `".$tblPrefix."packages` WHERE status = 2 AND type = 2");

?>
<!DOCTYPE html>
<html lang="en">

<head>

   <?php require_once 'inc/head.php';?>

   <link rel="stylesheet" href="./assets/style/logIn.css" />
   <link rel="stylesheet" href="./assets/style/howItWorks.css" />
   <link rel="stylesheet" href="./assets/style/buy_token.css" />
</head>

<body>
   <!-- Header -->
   <?php require_once 'inc/header.php';?>
   <!-- Header -->

   <!-- Main -->
   <main>
      <!-- Banner section -->
      <section class="Banner_Section_div">
         <h1 class="text-white banner_heading">BUY <span>TOKENS</span></h1>
      </section>
      <!-- Banner section -->

      <!-- Les Jetons ZId -->

      <?php if(mysqli_num_rows($dataPackagesType1)>0){ ?>
      <section class="les_jetons_zid padding_one">
         <div class="container-fluid side_padding">
            <div class="row">
               <div class="col-12">
                  <h2 class="les_jetons_zid_heading text-center py-4 text-white">SMART AUCTION TOKENS</h2>
                  <div class="row">
                     <div class="col-10 m-auto">
                        <p class="text-center buy_tokens_para mt-2">
                           Smart-Auction Tokens are clicks you use to outbid standard auctions Please note that Standard
                           Tokens are only valid for
                           standard auctions.
                        </p>
                     </div>
                  </div>
               </div>
               <div class="col-12 zid_clicks mt-5">
                  <div class="row justify-content-center">
                     <?php while($dataType1 = mysqli_fetch_assoc($dataPackagesType1)){ ?>
                     <div class="col-xxl-3 col-md-6 mb-5">
                        <div class="zid_click_card mx-2">
                           <div class="zid_click_card_head text-center py-4">
                              <h4 class="mb-0 text-white"><?php echo $dataType1['name']?></h4>
                           </div>
                           <div class="zid_click_card_body text-center py-4">
                              <p class="click_card_content text-center light_para px-5"><?php echo $dataType1['description']?>.</p>
                              <h2 class="click_card_price text-center"><?php echo $dataType1['sale_price']?><sup>$</sup></h2>
                              <a href="payments.php?type=token&package=<?php echo $dataType1['id']?>" target="_blank" class="View_More_Button my-3">Buy Now</a>
                           </div>
                        </div>
                     </div>
                     <?php }?>
                  </div>
               </div>

               <div class="col-12 section_divider mt-5 mb-5"></div>
            </div>
         </div>
      </section>
      <?php }?>

      <!-- Les Jetons ZId -->

      <!-- Les  jetons Vip -->

      <?php if(mysqli_num_rows($dataPackagesType2)>0){ ?>
      <section class="les_jetons_vip mb-5">
         <div class="container-fluid side_padding">
            <div class="row">
               <div class="col-12 mt-5">
                  <h2 class="les_jetons_vip_heading text-center py-4 text-white">SMART AUCTION TOKENS</h2>
                  <div class="row">
                     <div class="col-10 m-auto">
                        <p class="text-center buy_tokens_para mt-2">
                           VIP Tokens are clicks you use to outbid during VIP auctions Please note that VIP Tokens are
                           only valid for VIP auctions
                        </p>
                     </div>
                  </div>
               </div>
               <div class="col-12 vip_clicks mt-5">
                  <div class="row justify-content-center">
                     <?php while($dataType2 = mysqli_fetch_assoc($dataPackagesType2)){ ?>
                     <div class="col-xxl-3 col-md-6 mb-5">
                        <div class="vip_click_card mx-2">
                           <div class="vip_click_card_head text-center py-4">
                              <img src="./assests/icons&images/vip.png" alt="" class="vip_logo_img mb-3" />
                              <h4 class="mb-0 text-white"><?php echo $dataType2['name']?></h4>
                           </div>
                           <div class="vip_click_card_body text-center py-4">
                              <p class="click_card_content text-center light_para px-5"><?php echo $dataType2['description']?></p>
                              <h2 class="click_card_price text-center"><?php echo $dataType2['sale_price']?><sup>$</sup></h2>
                              <a href="payments.php?type=token&package=<?php echo $dataType2['id']?>" target="_blank" class="View_More_Button my-3">Buy Now</a>
                           </div>
                        </div>
                     </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <?php }?>

      <!-- Les Jetons Vip -->

      <!-- News Letter Section -->

      <?php require_once 'inc/newsletter.php';?>
      <!-- News Letter Section -->
   </main>
   <!-- Main -->

   <!-- Footer -->
   <!-- Footer -->

   <?php require_once 'inc/footer.php';?>

   <?php require_once 'inc/js.php';?>
</body>

</html>