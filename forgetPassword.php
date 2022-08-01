<?php
    require 'inc/forget-password.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./assets/style/forgetPassword.css">
    <!-- Alertify-->
    <link rel="stylesheet" type="text/css" href="./assets/style/alertify.rtl.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/style/alertify-default-theme.rtl.min.css">
</head>

<body>
    <div class="password_div">
        <?php 
            if(isset($_GET['verify'])){
        ?>
        <div class="password_iner_div px-5 py-3">
            <div class="password_heading_div">
                <div class="passwrod_key_div d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-key"></i>
                </div>
            </div>

            <h1 class="text-center mt-4">Enter Email</h1>

            <form method="POST" >
                <div>
                    <h5>Email</h5>
                    <div class="input_div my-3">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" placeholder="Email" name="email" autocomplete="off" required>
                    </div>
                    <p>We will send a reset link to your register E-mail</p>
                </div>

                <div class="text-center mt-4 mb-2">
                    <button type="submit" name="verify" class="reset_password">RESET PASSWORD</button>
                </div>
            </form>

        </div>
        <?php }else if(isset($_GET['u']) && isset($_GET['token']) ) { ?>
        <div class="password_iner_div px-5 py-3 ms-5">
            <div class="password_heading_div">
                <div class="passwrod_key_div d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-key"></i>
                </div>
            </div>

            <h1 class="text-center mt-4">Enter Password</h1>

            <form method="POST">
                <input type="hidden" name="u" value="<?php echo $_GET['u']?>">
                <input type="hidden" name="token" value="<?php echo $_GET['token']?>">
                <div>
                    <h5>Password</h5>
                    <div class="input_div my-3">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="password" name="password" placeholder="Password" autocomplete="off" required >
                    </div>
                    <h5>Confirm Passsword</h5>
                    <div class="input_div my-3">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="password" name="conf-password" placeholder="Confirm Passsword" autocomplete="off" required >
                    </div>
                </div>

                <div class="text-center mt-4 mb-2">
                    <button type="submit" name="recover-account" class="reset_password">RESET PASSWORD</button>
                </div>
            </form>

        </div>
        <?php }?>
    </div>
    <!-- Alertify -->
  <script type="text/javascript" src="./assets/js/alertify.min.js"></script>
  <?php echo toast(1); ?>
</body>

</html>