<?php
   require_once 'inc/config.php';
   $pageName="How it Works";
   $howitWorks = mysqli_query($conn,"SELECT `type`, `title`, `img`, `desc` FROM `".$tblPrefix."cms_pages` WHERE type = 2 and status > 1");

?>
<!DOCTYPE html>
<html lang="en">
   <head>

   <?php require_once 'inc/head.php';?>

      <link rel="stylesheet" href="./assets/style/howItWorks.css" />
   </head>

   <body>
   <!-- Header -->
   <?php require_once 'inc/header.php';?>
   <!-- Header -->

   <!-- Main -->
   <main>
      <!-- Banner section -->
      <section class="Banner_Section_div">
         <h1 class="text-white banner_heading">HOW IT <span>WORKS?</span></h1>
      </section>
      <!-- Banner section -->

      <!-- How to works section -->
      <section class="register_and_account_div padding_Two">
         <div class="container">
            <?php    
               if(mysqli_num_rows($howitWorks)){
                  $i = 0;
                  while($data = mysqli_fetch_assoc($howitWorks)){
                     $i++;
            ?>
            <div class="row mb-4 mb-lg-4 mb-xl-0 justify-content-evenly <?php if($i %2 == 0){echo 'flex-row-reverse';}?>">
               <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                  <img src="./assets/img/<?php echo $data['img']?>" alt="<?php echo $data['title']?>" class="img-fluid howItWorks_image" />
               </div>
               <div class="col-1 d-none d-xl-block">
                  <div class="number_circle">0<?php echo $i;?></div>
                  <div class="dot_container mt-3">
                     <span class="doted"></span>
                     <span class="doted"></span>
                     <span class="doted"></span>
                     <span class="doted"></span>
                     <span class="doted"></span>
                     <span class="doted"></span>
                     <span class="doted"></span>
                     <span class="doted"></span>
                     <span class="doted"></span>
                     <span class="doted"></span>
                     <span class="doted"></span>
                     <span class="doted"></span>
                  </div>
               </div>
               <div class="col-12 col-sm-12 col-md-6 col-lg-5 my-auto">
                  <div class="How_it_works_content">
                     <h3 class="howitworks_heading mt-4 mt-md-0 mb-1 p-0"><?php echo $data['title']?></h3>
                     <p class="howitworks_para">
                        <?php echo htmlspecialchars_decode($data['desc']);?>
                     </p>
                  </div>
               </div>
            </div>
            <?php } }?>

            <div class="row py-0 py-md-4">
               <div class="col-12">
                  <p class="howitworks_para">In short, here are the simplified registration steps:</p>
                  <p class="howitworks_para">
                     1 - First of all you must register on our website www.smartauction.com by creating
                     your personal account. <br>
                  </p>
                  <p class="howitworks_para">2 - Then you must choose the auction room of the desired product.</p>
                  <p class="howitworks_para">3 - As soon as the product has been chosen, you must register for the
                     corresponding room by paying the participation fees.</p>
                  <p class="howitworks_para">4 - When the progress bar, showing the filling rate of the auction room,
                     is
                     not 100% full, the auction will not start at the scheduled time and will be
                     automatically postponed for the week of after.</p>
                  <p class="howitworks_para">5 - Once the auction room is full, a confirmation email will be sent to
                     inform you of the exact date and time of the start of the auction.
                     Have you already registered for an auction house</p>

                  <p class="howitworks_para">The auction will start soon and you have no idea about the auction
                     process?
                     Please understand these important points in order to maximize your
                     chances of winning the auction</p>

                  <p class="howitworks_para">
                     - The starting price of each product put up for auction will be 1 Dinar
                  </p>

                  <p class="howitworks_para">
                     - The participants in the auction will be able to bid by 100 milimes or
                     200 milimes only
                  </p>

                  <p class="howitworks_para">
                     - Each participant is entitled to 5 free bets during the auction.
                  </p>

                  <p class="howitworks_para">
                     - If you have consumed your 5 free bets, you can buy packs of Tokens to
                     outbid:
                  </p>

                  <p class="howitworks_para">• Standard tokens: 10 tokens = 13dt / 15 tokens = 19dt / 20 tokens =
                     25dt / 25 tokens = 30dt / 100 tokens = 110dt <br>
                     • Standard tokens are only used during standard auctions where the value
                     of the product does not exceed <20,000 dinars. <br> • VIP tokens: 12 tokens=120dt / 15 tokens=140dt
                        / 20
                        tokens=180dt / 25 tokens=225dt / 100 tokens=900dt <br> • VIP tokens are only used during VIP
                        auctions
                        where the product value exceeds> 20,000 dinars</p>

                  <p class="howitworks_para">- Please note that the token purchase costs are refundable only in the
                     event that an auction is canceled, otherwise the tokens are not
                     refundable.</p>
                  <p class="howitworks_para">- Once the auction has started, a 10 minute countdown will be displayed
                     (10 minutes for participants to join the auction, don't waste your tokens
                     😉.</p>
                  <p class="howitworks_para">- The auction starts after 9 minutes and 50 seconds, the last 10 seconds
                     of the countdown will be automatically renewed for each new increase
                     of 100 or 200 milimes.</p>
                  <p class="howitworks_para">- NB: After 20 minutes (i.e. at 19:20) from the start of the auction, the
                     10 seconds decrease to 5 seconds! You will only have 5 seconds to bid</p>
                  <p class="howitworks_para">- Whoever bets during the last 10 or 5 seconds, without having any
                     other new bets from the other participants, will win the auction!
                  </p>
                  <p class="howitworks_para">When you win the auction, payment of the proceeds will be made in
                     cash, checks or bank transactions as you see fit.</p>

                  <h5 class="howitworks_para">Important notice : The minimum number of actual participants required for
                     an
                     auction to be considered completed must be equivalent to a minimum of 50%
                     of the participants registered in this same auction. In the event that the auction
                     is considered unfinished, it will be postponed for a later date.
                  </h5>

                  <h3 class="mt-5 howitworks_para"><span>PLEASE NOTE :</span> It is no longer possible for the winners
                     of 2 auctions per
                     year
                     (2 standard auctions and 2 VIP auctions) to participate during the following 6
                     months, so the accounts of the winners will be suspended for 6 months.</h3>

                  <p class="howitworks_para">It is essential that each participant intends to acquire the product on
                     which he
                     intends to bid. The management of smartauction.com prohibits any person having no real
                     intention of acquiring the product from participating in its platform.</p>

                  <p class="howitworks_para">An innovative and original service which brings a new way of understanding
                     the purchase on the Internet in complete security. Of course, there is no magic
                     behind all this: the financing of the products is ensured by the price of entry to
                     the theaters and by the smartauction Tokens.
                  </p>

                  <p class="howitworks_para">To find out more, visit the official smartauction.com website, our Facebook
                     page or
                     our
                     Instagram page.</p>
               </div>
            </div>

         </div>
      </section>
      <!-- How to works section -->

      <?php require_once 'inc/getInTouch.php';?>

      <!-- News Letter Section -->

      <?php require_once 'inc/newsletter.php';?>
      <!-- News Letter Section -->
   </main>
   <!-- Main -->

   <!-- Footer -->
   <!-- Footer -->

   <?php require_once 'inc/footer.php';?>

   <!-- Footer -->
   <!-- Footer -->

   <?php require_once 'inc/js.php';?>

</body>
</html>
