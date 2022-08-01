<?php
   require_once 'inc/config.php';
   $pageName="Register";


   if(isset($_POST['registerUser'])){
      $name = mysqli_real_escape_string($conn,ak_secure_string($_POST['name']));
      $email = mysqli_real_escape_string($conn,ak_secure_string($_POST['email']));
      $password = mysqli_real_escape_string($conn,ak_secure_string($_POST['password']));
      $cnfPassword = mysqli_real_escape_string($conn,ak_secure_string($_POST['cnf-password']));
      $address = mysqli_real_escape_string($conn,ak_secure_string($_POST['address']));
      $address2 = mysqli_real_escape_string($conn,ak_secure_string($_POST['addresssecond']));
      $city = mysqli_real_escape_string($conn,ak_secure_string($_POST['city']));
      $zipCode = mysqli_real_escape_string($conn,ak_secure_string($_POST['zipCode']));
      $Country = mysqli_real_escape_string($conn,ak_secure_string($_POST['Country']));
      
      $pass = hash('sha512',$password.HASH_KEY);

      if($password === $cnfPassword){
        $token = bin2hex(openssl_random_pseudo_bytes(64));
         $checkUser=mysqli_query($conn,"SELECT * FROM `".$tblPrefix."users` WHERE `email`='$email' AND `password`='$pass' AND status>1 AND `type` = 2");
         if(mysqli_num_rows($checkUser) == 0){
            $insertUser = mysqli_query($conn,"INSERT INTO `".$tblPrefix."users`(`type`, `name`, `email`, `password`, `date_time`, `token`, `status`) VALUES (2,'$name','$email','$pass','$cTime', '$token', 1)");
            print_r(mysqli_error($conn));
            if($insertUser == TRUE){
                $encMail = base64_encode($email);
                $subject = "Registration Successful - ".SITE_NAME;
                $verificationUrl = SITE_URL.'verify-account.php?u='.$encMail.'&token='.$token;
                smtp_mailer($email, $subject, $verificationUrl);
               $id = mysqli_insert_id($conn);
               $data =mysqli_query($conn,"INSERT INTO `".$tblPrefix."userdata` ( `user_email`, `Add1`, `Add 2`, `city`, `zip`, `country`) VALUES ('$email','$address','$address2','$city','$zipCode','$Country') ");

               $wallet = mysqli_query($conn,"INSERT INTO `".$tblPrefix."wallet`(`user_id`, `balance`, `date_time`, `status`) VALUES ('$id',5,'$cTime',2)");
               $userData = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `id`,`type`, `name`, `email`, `img`, `date_time` FROM `bnmi_users` WHERE id = ".$id));
               if($userData == TRUE){
                $_SESSION['toast']['type'] = "alert";
                $_SESSION['toast']['msg'] = "Registration successful!<br/><br/> Please follow the link sent on your email address to verify your account.";
               }
            }else{
               $_SESSION['toast']['type'] = "warning";
               $_SESSION['toast']['msg'] = "Something went wrong, Please try again later.";
            }
         }else{
            $_SESSION['toast']['type'] = "warning";
            $_SESSION['toast']['msg'] = "You already have an account";
         }
      }
   }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'inc/head.php';?>
    <link rel="stylesheet" href="./assets/style/logIn.css" />
    <link rel="stylesheet" href="./assets/style/responsive.css" />
</head>

<body>
    <!-- Header -->
    <?php require_once 'inc/header.php';?>
    <!-- Header -->

    <!-- Main -->
    <main>
        <!-- Sing Up Component -->
        <section class="SignIn_Div side_padding">
            <div class="container-fluid padding_one">
                <div class="row">
                    <div class="col-lg-12 col-xxl-8">
                        <!-- Sign In Div -->
                        <div class="sign_in_inner_div">
                            <!-- Sing In Component content -->
                            <div class="text-center">
                                <h1>HI, THERE</h1>
                                <p class="light_para my-3">Create Your Account</p>
                            </div>
                            <!-- Sing In Component content -->

                            <!-- Sing in input div -->
                            <form method="POST">
                                <div class="mt-4">
                                    <div class="sing_in_input_div d-flex align-items-center mb-4">
                                        <div class="sing_in_icons_div">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <input type="text" name="name" autocomplete="off" required
                                            placeholder="Enter your name" />
                                    </div>

                                    <div class="sing_in_input_div d-flex align-items-center mb-4">
                                        <div class="sing_in_icons_div">
                                            <img src="./assests/icons&images/Layer 2.svg" alt="" />
                                        </div>
                                        <input type="email" name="email" autocomplete="off" required
                                            placeholder="Email Address" />
                                    </div>

                                    <div class="sing_in_input_div d-flex align-items-center mb-4">
                                        <div class="sing_in_icons_div">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <input type="password" name="password" autocomplete="off" required
                                            placeholder="Enter your Password" />
                                    </div>

                                    <div class="sing_in_input_div d-flex align-items-center">
                                        <div class="sing_in_icons_div">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <input type="password" name="cnf-password" autocomplete="off" required
                                            placeholder="Confirm Password" />
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <div class="sing_in_input_div d-flex align-items-center mt-4">
                                                <input type="text" name="address" autocomplete="off" required
                                                    placeholder="Address line 1" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <div class="sing_in_input_div d-flex align-items-center mt-4">
                                                <input type="text" name="addresssecond" autocomplete="off" required
                                                    placeholder="Address line 2" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <div class="sing_in_input_div d-flex align-items-center mt-4">
                                                <input type="text" name="city" autocomplete="off" required
                                                    placeholder="Enter your city name" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <div class="sing_in_input_div d-flex align-items-center mt-4">
                                                <input type="text" name="zipCode" autocomplete="off" required
                                                    placeholder="Zip / postCode" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="sing_in_input_div d-flex align-items-center mt-4">
                                                <input type="text" name="Country" autocomplete="off" required
                                                    placeholder="Country Name" />
                                            </div>
                                        </div>

                                    </div>



                                    <!-- Forget Password -->
                                    <div class="text-center mt-3 forgot_div">
                                        <!-- <a href="#">Forgot Password?</a> -->
                                        <div class="mt-4">
                                            <button class="logIn_button" type="submit"
                                                name="registerUser">REGISTER</button>
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
                        <div class="switch_section switch_section_padding  text-center">
                            <!-- Content -->
                            <h1 class="text-white">Already have an account?</h1>
                            <p class="text-white mb-4">Log in your account</p>
                            <div>
                                <a class="logIn_button" href="./login.php">LOG IN</a>
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

    <!-- Footer -->
    <?php require_once 'inc/footer.php';?>
    <?php require_once 'inc/js.php';?>

</body>

</html>