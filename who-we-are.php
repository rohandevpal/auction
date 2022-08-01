<?php
   require_once 'inc/config.php';
   $pageName="Who We Are";
   $whoweare = mysqli_query($conn,"SELECT `type`, `title`, `img`, `desc` FROM `".$tblPrefix."cms_pages` WHERE type = 4 and status > 1");

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php require_once 'inc/head.php'?>
      <link rel="stylesheet" href="./assets/style/whoWeAre.css" />
      <link rel="stylesheet" href="./assets/style/howItWorks.css" />
   </head>
   <body>
      <!-- Header -->
      <?php require_once 'inc/header.php';?>
      <!-- Header -->

      <main>
         <!-- Banner section -->
         <section class="Banner_Section_div">
            <h1 class="text-white banner_heading">WHO ARE <span>WE</span></h1>
         </section>
         <!-- Banner section -->

         <section class="whoWeAre padding_one">
            <div class="container-fluid side_padding">
            <?php    
               if(mysqli_num_rows($whoweare)){
                  $i = 0;
                  while($data = mysqli_fetch_assoc($whoweare)){
                     $i++;
            ?>
               <div class="row <?php if($i %2 == 0){echo 'flex-row-reverse';}?> my-5 ">
                  <div class="col-12 col-sm-12 col-md-6 col-lg-7">
                     <!-- My Account Setting -->
                     <div class="row">
                        <div class="col-12">
                           <div class="hot_it_works_heading py-3">
                              <h1><?php echo $data['title'];?></h1>
                              <div class="line_div ms-0 my-4"></div>
                           </div>
                        </div>
                     </div>
                     <!-- My Account Setting -->
                     <p class="light_para mt-3">
                        <?php echo htmlspecialchars_decode($data['desc']);?>
                     </p>
                  </div>
                  <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                     <img src="./assets/img/<?php echo $data['img'];?>" alt="<?php echo $data['title'];?>" class="img-fluid howItWorks_image" />
                  </div>
               </div>
               <?php } }?>
            </div>
         </section>
      </main>

      <!-- Footer -->
      <?php require_once 'inc/js.php'; ?>
      <?php require_once 'inc/footer.php'; ?>


   </body>
</html>
