<?php 
    include_once("../inc/config.php");
    $pageName="Forget Password ";
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <?php include_once('inc/css.php');?>
    <title><?php echo $pageName ." | ". SITE_NAME?></title>
</head>
<body class="jumbo-page">
    <main class="admin-main  bg-pattern">
        <div class="container">
            <div class="row m-h-100 ">
                <div class="col-md-8 col-lg-4  m-auto">
                    <div class="card shadow-lg ">
                        <?php
                            if(isset($_GET['resetpassword'])){
                        ?>
                        <div class="card-body ">
                            <div class=" padding-box-2 ">
                                <div class="text-center p-b-20 pull-up-sm">

                                    <div class="avatar avatar-lg">
                                        <span class="avatar-title rounded-circle bg-pink"> 
                                            <i class="mdi mdi-key-change"></i> 
                                        </span>
                                    </div>

                                </div>
                                <h3 class="text-center">Enter Emaill</h3>
                                <form action="../inc/forget-password.php" method="POST">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group input-group-flush mb-3">
                                            <input type="email" class="form-control form-control-prepended"
                                                   placeholder="Enter Your Email" name="email" autocomplete="off" required>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <span class=" mdi mdi-email "></span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="small">
                                            We will send a reset link to your registered E-Mail
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn text-uppercase btn-block  btn-primary" name="verify">
                                            Reset Password
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    <?php }elseif(isset($_GET['u']) && isset($_GET['token'])){
                        $u=mysqli_real_escape_string($conn,$_GET['u']);
                        $token=mysqli_real_escape_string($conn,$_GET['token']);
                    ?>
                        <div class="card-body ">
                            <div class=" padding-box-2 ">
                                <div class="text-center p-b-20 pull-up-sm">
                                    <div class="avatar avatar-lg">
                                        <span class="avatar-title rounded-circle bg-pink"> 
                                            <i class="mdi mdi-key-change"></i> 
                                        </span>
                                    </div>
                                </div>
                                <h3 class="text-center">Create Password</h3>
                                <form action="../inc/forget-password.php" method="POST">
                                    <input type="hidden" name="u" value="<?php echo $u; ?>">
                                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                                    <div class="form-group">
                                        <label>New Password</label>

                                        <div class="input-group input-group-flush mb-3">
                                            <input type="text" class="form-control form-control-prepended"
                                                   placeholder="New Password" name="password">
                                            <div class="input-group-prepend" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <div class="input-group input-group-flush mb-3">
                                            <input type="text" class="form-control form-control-prepended"
                                                   placeholder="Confirm Password">
                                            <div class="input-group-prepend" name="conf-password" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn text-uppercase btn-block  btn-primary" name="recover-account">
                                            Reset Password
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
    <?php include_once('inc/js.php');?>
    <?php include_once('inc/search-bar.php');?>
</html>