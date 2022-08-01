<?php

require_once 'inc/config.php';
$pageName="Auction-End";
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once 'inc/head.php';?>
</head>

<body>
   <!-- Header -->
   <?php require_once 'inc/header.php';?>
   <!-- Header -->

   <!-- Main -->
   <main>
      <!-- Banner section -->
      <section class="Banner_Section_div">
         <h1 class="text-white">ENDED <span>AUCTIONS</span></h1>
      </section>
      <!-- Banner section -->

      <!-- Catelog section -->
      <div class="catalog_section padding_one main_bg">
         <div class="container_fluid side_padding">
            <!-- Catelog section heading -->
            <div class="row">
               <div class="col-12">
                  <div class="hot_it_works_heading text-center py-3">
                     <h1>CATALOG OF COMPLETED <span class="span_color_2">AUCTIONS</span></h1>
                     <div class="line_div my-4"></div>
                  </div>
               </div>
            </div>
            <!-- Catelog section heading -->

            <!-- Catalog section products -->
            <div class="row mt-5 justify-content-center">
           <?php
       $auctionEnd = mysqli_query($conn, "SELECT * FROM `bnmi_auctions` WHERE `status` = '3' LIMIT 30");
         while($res = mysqli_fetch_assoc($auctionEnd)){
            $id = $res['id'];
            // $maxamount = mysqli_query($conn, "SELECT * FROM `bnmi_winnig` WHERE  `auction_id` = '$id'");
            // $totalmount = mysqli_fetch_assoc($maxamount);
            // $biddingmax = $totalmount['amount'];
            // print_r($totalamount);
            $name = $res['name'];
            $img = $res['image'];

            Endauction($id, $name ,$img);
         }

           ?>
            </div>

            <!-- Catalog section products -->
         </div>
      </div>
      <!-- Catelog section -->

      <!-- News Letter Section -->

    
      <!-- News Letter Section -->
   </main>
   <!-- Main -->

   <!-- Footer -->
   <!-- Footer -->
   <?php require_once 'inc/footer.php';?>
   <?php require_once 'inc/js.php'; ?>
   <!-- Footer -->
   <!-- Footer -->

   <!-- Bootsrap 5 script CDN -->
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>