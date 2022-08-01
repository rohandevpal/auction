<?php
   require_once 'inc/config.php';
   $pageName="Contact";

   if(isset($_POST['submitContact'])){
      $name = mysqli_real_escape_string($conn,ak_secure_string($_POST['name']));
      $email = mysqli_real_escape_string($conn,ak_secure_string($_POST['email']));
      $contact = mysqli_real_escape_string($conn,ak_secure_string($_POST['contact']));
      $message = mysqli_real_escape_string($conn,ak_secure_string($_POST['message']));

      $query = "INSERT INTO `bnmi_query`(`name`, `email`, `contact`, `msg`, `status`, `date_time`) VALUES ('$name','$email','$contact','$message',1,'$cTime')";
      if(mysqli_query($conn,$query) ==  TRUE){
         $_SESSION['toast']['type'] = "success";
         $_SESSION['toast']['msg'] = "Query Submitted successfully, We`ll get back to you soon";
         header('refresh:0');
         exit();
      }else{
         $_SESSION['toast']['type'] = "warning";
         $_SESSION['toast']['msg'] = "Something went wrong, Please try again later";
         header('refresh:0');
         exit();
      }

   }

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php require_once 'inc/head.php';?>
      <link rel="stylesheet" href="./assests/style/content.css" />
      <link rel="stylesheet" href="./assests/style/howItWorks.css" />
   </head>

   <body>
      <!-- Header -->
      <?php require_once 'inc/header.php';?>
      <!-- Header -->

      <!-- Main -->
      <main>
         <!-- Banner section -->
         <section class="Banner_Section_div">
            <h1 class="text-white banner_heading">CONTACT <span>US</span></h1>
         </section>
         <!-- Banner section -->

         <!-- Content us section -->
         <section class="contact_use_section padding_one main_bg">
            <div class="container-fluid side_padding">
               <div class="row gx-0 justify-content-center">
                  <div class="col-12 contact_row col-sm-12 col-md-7 col-lg-7 p-5">
                     <div class="contact_div">
                        <!-- Contact content -->
                        <div class="d-flex justify-content-between">
                           <h3 class="contact_heading">Send us a Message</h3>
                           <img src="./assests/icons&images/cons.svg" alt="" />
                        </div>
                        <!-- Contact content -->
                        <form method="POST">
                           <!-- Contact inputs -->
                           <div class="contact_input_group_div mt-3">
                              <!-- Inputs -->
                              <div class="contact_page_input_inner mb-3 d-flex">
                                 <div class="contact_icons">
                                    <img src="./assests/icons&images/user-solid 1.svg" alt="" />
                                 </div>
                                 <input type="text" name="name" autocomplete="OFF" required placeholder="Full Name" />
                              </div>
                              <!-- Inputs -->
   
                              <!-- Inputs -->
                              <div class="contact_page_input_inner mb-3 d-flex">
                                 <div class="contact_icons">
                                    <img src="./assests/icons&images/mail.svg" alt="" />
                                 </div>
                                 <input type="email" name="email" autocomplete="OFF" required placeholder="Email Address" />
                              </div>
                              <!-- Inputs -->
   
                              <!-- Inputs -->
                              <div class="contact_page_input_inner mb-3 d-flex">
                                 <div class="contact_icons">
                                    <img src="./assests/icons&images/phone-solid 1.svg" alt="" />
                                 </div>
                                 <input type="number" name="contact" autocomplete="OFF" required placeholder="Phone Number" />
                              </div>
                              <!-- Inputs -->
   
                              <!-- Inputs -->
                              <div class="contact_page_input_inner text-aria-div mb-3 d-flex">
                                 <div class="contact_icons message_icons_div">
                                    <img src="./assests/icons&images/d.svg" alt="" />
                                 </div>
                                 <textarea class="message_aria" name="message" autocomplete="OFF" required id="" cols="30" rows="10" placeholder="Message"></textarea>
                                 <!-- <input type="number" placeholder="Phone Number"> -->
                              </div>
                              <!-- Inputs -->
   
                              <!-- Send Button -->
                              <button type="submit" name="submitContact" class="send_Button mt-3">Send <img src="./assests/icons&images/send.svg" alt="" /></button>
                              <!-- Send Button -->
                           </div>
                           <!-- Contact inputs -->
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Map section -->
            <div class="container-fluid p-0 map_container">
               <iframe
                  src="<?php echo getGeneral('maps');?>"
                  width="100%"
                  height="450"
                  allowfullscreen=""
                  loading="lazy"
               ></iframe>
            </div>
            <!-- Map section -->
         </section>
         <!-- Content us section -->

         <!-- News Letter Section -->

         <?php require_once 'inc/newsletter.php';?>
         <!-- News Letter Section -->
      </main>
      <!-- Main -->

      <!-- Footer -->
      <?php require_once 'inc/footer.php';?>
      <!-- Footer -->

      <?php require_once 'inc/js.php';?>
   </body>
</html>
