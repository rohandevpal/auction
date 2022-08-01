<?php
require_once 'inc/config.php';
$pageName = "Login";

if(isset($_SESSION['user'])){
    $_SESSION['toast']['type']="success";
    $_SESSION['toast']['msg']="Logged in ";
    header("location:dashboard.php");
    exit();
}

if (isset($_POST['looginUser'])) {
   $email = mysqli_real_escape_string($conn, ak_secure_string($_POST['email']));
   $password = mysqli_real_escape_string($conn, ak_secure_string($_POST['password']));
   $pass = hash('sha512', $password . HASH_KEY);

   $checkUser = mysqli_query($conn, "SELECT * FROM `" . $tblPrefix . "users` WHERE `email`='$email' AND `password`='$pass' AND status>1 AND `type` = 2");
   if (mysqli_num_rows($checkUser) > 0) {
      $adminData = mysqli_fetch_assoc($checkUser);
      $_SESSION['user'] = $adminData;
      if (isset($_SESSION['user'])) {
         $id =   $_SESSION['user'] ['id'];
         mysqli_query($conn, "UPDATE `bnmi_users` SET `login_status`='1' WHERE id =' $id'");
         unset($_SESSION['user']['password']);
         $_SESSION['toast']['type'] = "success";
         $_SESSION['toast']['msg'] = "Successfully logged In.";
         if(isset($_GET['auction']) && isset($_GET['id'])){
            $url = 'auction.php?auction='.$_GET['auction'].'&id='.$_GET['id'].'';
            header("location:".$url."");
            exit();
         }else{
         header("location:dashboard.php");
         exit();
         }
      } else {
         $_SESSION['toast']['msg'] = 'Something went wrong, Please try again.';
      }
   } else {
      $_SESSION['toast']['msg'] = 'username or password is wrong, please try again.';
   }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
   <?php require_once 'inc/head.php'; ?>
   <link rel="stylesheet" href="./assets/style/logIn.css">
</head>

<body>
   <!-- Header -->
   <?php require_once 'inc/header.php'; ?>
   <!-- Header -->

   <!-- Main -->
   <main>
      <!-- Sing Up Component -->
      <section class="SignIn_Div side_padding">
         <div class="container-fluid padding_one">
            <div class="row">
               <div class="col-lg-12 col-xxl-8">
                  <!-- Sign In Div -->
                  <div class="sign_in_inner_div p-lg-0 p-xxl-3">
                     <!-- Sing In Component content -->
                     <div class="text-center">
                        <h1>HI, THERE</h1>
                        <p class="light_para my-3">You can log in to your account here.</p>
                     </div>
                     <!-- Sing In Component content -->

                     <!-- Sing in and log in buttons -->
                     <!-- Sing in input div -->
                     <form method="POST">
                        <div class="mt-4">
                           <div class="sing_in_input_div d-flex align-items-center mb-4">
                              <div class="sing_in_icons_div">
                                 <img src="./assets/icons&images/Layer 2.svg" alt="" />
                              </div>
                              <input type="email" name="email" autocomplete="off" required placeholder="Email Address" />
                           </div>

                           <div class="sing_in_input_div d-flex align-items-center">
                              <div class="sing_in_icons_div">
                                 <i class="fas fa-lock"></i>
                              </div>
                              <input type="password" name="password" autocomplete="off" required placeholder="Password" />
                           </div>

                           <!-- Forget Password -->
                           <div class="text-center mt-5 forgot_div">
                              <a href="forgetPassword.php?verify">Forgot Password?</a>
                              <div class="mt-4">
                                 <button type="submit" name="looginUser" class="logIn_button">LOG IN</button>
                              </div>
                           </div>
                        </div>
                     </form>
                     <!-- Sing in input div -->
                  </div>
                  <!-- Sign In Div -->
               </div>

               <div class="col-lg-12 col-xxl-4 mt-5 mt-xxl-0">
                  <!-- Switch section -->
                  <div class="switch_section text-center py-5 py-xxl-0">
                     <!-- Content -->
                     <h1 class="text-white">NEW HERE?</h1>
                     <p class="text-white mb-4">Sign up and create your Account</p>
                     <div>
                        <a class="logIn_button" href="./register.php">SIGN UP</a>
                     </div>
                     <!-- Content -->
                  </div>
                  <!-- Switch section -->
               </div>
            </div>
         </div>
      </section>
      <!-- Sing Up Component -->
   </main>
   <!-- Main -->
   <!-- second_footer -->
   <!-- Footer -->
   <?php require_once 'inc/footer.php'; ?>
   <!-- Footer -->
   <!-- jquery -->
   <?php require_once 'inc/js.php'; ?>
</body>

</html>