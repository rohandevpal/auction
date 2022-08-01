<?php
   require_once 'inc/config.php';
   $pageName="Current Auctions";

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php require_once 'inc/head.php';?>
      
      <link rel="stylesheet" href="./assets/style/howItWorks.css" />
      <link rel="stylesheet" href="./assets/style/currentAuctions.css" />

   </head>

   <body>
      <!-- Header -->
      <?php require_once 'inc/header.php';?>
      <!-- Header -->

      <main>
         <!-- Banner section -->
         <section class="Banner_Section_div">
            <h1 class="text-white banner_heading">CURRENT <span>AUCTIONS</span></h1>
         </section>
         <!-- Banner section -->
         <!--Products-->
         <section class="side_padding main_bg">
            <div class="container-fluid padding_one">
               <!-- Upcomming changes section products -->
               <div class="row justify-content-center mt-5">
                  <?php echo auctionCard(0,0)?>
                  <!-- Popular cards -->
               </div>
               <!-- Upcomming changes section products -->
            </div>
         </section>
         <!--/ Products-->

         <!-- News Letter Section -->

         <?php require_once 'inc/newsletter.php';?>

         <!-- News Letter Section -->
      </main>
      
      <!-- Footer -->
      <!-- Footer -->
      <?php require_once 'inc/footer.php';?>
      <!-- Footer -->
      <!-- Footer -->

      <?php require_once 'inc/js.php';?>
   </body>
</html>
