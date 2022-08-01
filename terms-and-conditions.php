<?php

   require_once 'inc/config.php';
   $pageName="Terms & Condition";

?>
<!DOCTYPE html>
<html lang="en">
   <head>
   <?php require_once 'inc/head.php';?>
      
      <link rel="stylesheet" href="./assets/style/howItWorks.css" />
      <link rel="stylesheet" href="./assets/style/policy.css" />
   </head>

   <body>
      <!-- Header -->
      <?php require_once 'inc/header.php';?>
      <!-- Header -->

      <main>
         <!-- Banner section -->
         <section class="Banner_Section_div">
            <h1 class="text-white banner_heading">TERMS <span>CONDITIONS</span></h1>
         </section>
         <!-- Banner section -->

         <!-- Content -->
         <section class="Policy_section py-5">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <?php echo htmlspecialchars_decode(getSocialLinks('terms')); ?>
                  </div>
               </div>
            </div>
         </section>
         <!-- Content -->
      </main>

      <!-- Footer -->
      <?php require_once 'inc/footer.php';?>
      <?php require_once 'inc/js.php';?>

   </body>
</html>
