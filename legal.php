<?php
   require_once 'inc/config.php';
   $pageName="Legal";

?>
<!DOCTYPE html>
<html lang="en">
   <head>

   <?php require_once 'inc/head.php';?>

      <link rel="stylesheet" href="./assets/style/policy.css" />
      <link rel="stylesheet" href="./assets/style/howItWorks.css" />

   </head>

   <body>
      <!-- Header -->
      <?php require_once 'inc/header.php';?>
      <!-- Header -->

      <main>
         <!-- Banner section -->
         <section class="Banner_Section_div">
            <h1 class="text-white banner_heading">Legal</h1>
         </section>
         <!-- Banner section -->

         <!-- Content -->
         <section class="Policy_section py-5">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <?php echo htmlspecialchars_decode(getSocialLinks('legal')); ?>
                  </div>
               </div>
            </div>
         </section>
         <!-- Content -->
      </main>

      <!-- Footer -->
      <?php require_once 'inc/footer.php';?>
      <!-- Footer -->

      <?php require_once 'inc/js.php';?>

   </body>
</html>
