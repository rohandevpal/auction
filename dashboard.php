<?php
   require_once 'inc/config.php';
   $pageName="Dashboard";

   if(! isset($_SESSION['user'])){
      $_SESSION['toast']['msg'] = "Please login to continue.";
      header('location:login.php');
      exit();
   }
   if(isset($_POST['updateUserProfile'])){
      $name = mysqli_real_escape_string($conn,ak_secure_string($_POST['Username']));
      $mysql = mysqli_query($conn,"UPDATE `".$tblPrefix."users` SET `name` = '$name' WHERE  id = ".$_SESSION['user']['id']." ");
      if($mysql == true){
         $tmpName = $_FILES['userProfile']['tmp_name'];
         if(file_exists($tmpName)){
               $fileName = $_FILES['userProfile']['name'];
               $ext = pathinfo($fileName, PATHINFO_EXTENSION);
               if($ext=='jpg' || $ext=='jpeg' || $ext=='png'){
                  $fileName = rand(11111,99999).".".$ext;
                  if(move_uploaded_file($tmpName, './assets/img/user/'.$fileName)==true){
                     mysqli_query($conn, "UPDATE `".$tblPrefix."users` SET `img`='$fileName' WHERE `id`=".$_SESSION['user']['id']."");
                     $_SESSION['user']['img'] = $fileName;
                     $_SESSION['toast']['type']="success";
                     $_SESSION['toast']['msg']="Successfully updated.";
                  }else{
                     $_SESSION['toast']['msg']="Something went wrong, Please try again.";
                  }
               }else{
                     $_SESSION['toast']['msg']="Upload only image format(jpg,jpeg,png).";
                  }
         }
         $_SESSION['user']['name'] = $name;
         $_SESSION['toast']['type']="success";
         $_SESSION['toast']['msg']="Successfully updated.";
      }
   }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php require_once 'inc/head.php';?>
      <link rel="stylesheet" href="./assets/style/blog.css" />
      <link rel="stylesheet" href="./assets/style/MyAccount.css" />
      <link rel="stylesheet" href="./assets/style/howItWorks.css" />
      <link rel="stylesheet" href="./assets/style/userProfile.css" />
   </head>

   <body>
      <!-- Header -->
      <?php require_once 'inc/header.php';?>
      <!-- Header -->

      <!-- main -->
      <main>
         <!-- Banner section -->
         <section class="Banner_Section_div">
            <h1 class="text-white banner_heading">MY <span>ACCOUNT</span></h1>
         </section>
         <!-- Banner section -->
         <!-- My BET -->
         <div class="My_Bet_section padding_one main_bg">
               <div class="container-fluid side_padding">
               <!-- User Profile div -->
               <div class="row">
                  <div class="col-12 py-5 user_margin_class">
                     <div class="user_products_card d-flex align-items-center">
                     <div class="user_CR">
                        <img src="./assets/img/user/<?php echo $_SESSION['user']['img'];?>" alt=""  class="userImage"/>

                        <div class="edit_option">
                           <img src="./assests/icons&images/mybit/pencil 1.png" alt="" />
                        </div>
                     </div>

                     <div class="ms-4 mt-4 mt-mb-0">
                        <h3><?php echo $_SESSION['user']['name']?></h3>
                        <p><?php echo $_SESSION['user']['email']?></p>
                     </div>
                     </div>
                  </div>
               </div>
               </div>
            </div>
            <!-- My BET -->
         <!-- My Account Setting -->
         <section class="MyAccount_Section padding_one">
            <div class="container-fluid side_padding">
               
               <div class="row pb-5 pt-4">
                  <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                     <!-- My Account Setting -->
                     <div class="row">
                        <div class="col-12">
                           <div class="hot_it_works_heading py-3">
                              <h1>MY ACCOUNT <span class="span_color_2">SETTINGS</span></h1>
                              <div class="line_div ms-0 my-4"></div>
                           </div>
                        </div>
                     </div>
                     <!-- My Account Setting -->

                     <div class="row">
                        <div class="col-12 myAccountOptionNum col-sm-12 col-md-6 col-lg-6">
                           <p>Number of tokens purchased</p>
                           <input type="text" class="NumberInputDis text-white"  value="<?php echo getWallet($_SESSION['user']['id']);?>" disabled />
                        </div>
                     </div>

                     <form method="post" enctype="multipart/form-data">
                        <div class="row mt-4">
                           <div class="col-12 col-sm-12 col-md-12 col-md-12 col-lg-12 mt-4 mt-md-0">
                              <div class="col-12 myAccountOption col-sm-12">
                                 <p>Email</p>
                                 <input type="text" value="<?php echo $_SESSION['user']['email'];?>" placeholder="Your name" disabled />
                              </div>
                           </div>
                        </div>
                        <div class="row mt-4">
                           <div class="col-12 col-sm-12 col-md-12 col-md-12 col-lg-12 mt-4 mt-md-0">
                              <div class="col-12 myAccountOption col-sm-12">
                                 <p>Full Name (*)</p>
                                 <input type="text" name="Username" autocomplete="off" required value="<?php echo $_SESSION['user']['name'];?>" placeholder="Your name" />
                              </div>
                           </div>
                        </div>
                        <div class="row mt-4">
                           <div class="col-12 col-sm-12 col-md-12 col-md-12 col-lg-12 mt-4 mt-md-0">
                              <div class="col-12  col-sm-12">
                                 <p>Upload Profile Image</p>
                                 <input type="file" name="userProfile" autocomplete="off" class="w-100" />
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-5">
                              <button type="submit" name="updateUserProfile" class="btn send_button">Save</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </section>
         <!-- My Account Setting -->
      </main>
      <!-- main -->

      <!-- Footer -->
      <?php require_once 'inc/footer.php';?>
      <?php require_once 'inc/js.php';?>
      <script>
         document.querySelector('.edit_option').addEventListener('click', function(){
            document.querySelector('.inputFile').click()
         })
      </script>

   </body>
</html>