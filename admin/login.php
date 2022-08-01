<?php 
    include_once("../inc/config.php");
    $pageName="Login";
    
    if(isset($_SESSION['adminUser'])){
        $_SESSION['toast']['type']="success";
        $_SESSION['toast']['msg']="Logged in ";
        header("location:index.php");
        exit();
    }

// Sign In
if(isset($_POST['login'])){
  $email= trim(strtolower(mysqli_real_escape_string($conn,ak_secure_string($_POST['email']))));
  $pass=mysqli_real_escape_string($conn,$_POST['password']);
  $password=hash('sha512',$pass.HASH_KEY);

    $checkAdmin=mysqli_query($conn,"SELECT * FROM `".$tblPrefix."users` WHERE `email`='$email' AND `password`='$password' AND status>1 AND `type` = 1");
    if(mysqli_num_rows($checkAdmin)>0){
        $adminData=mysqli_fetch_assoc($checkAdmin);
        $_SESSION['adminUser']=$adminData;
        if(isset($_SESSION['adminUser'])){
            unset($_SESSION['adminUser']['password']);
            $_SESSION['toast']['type']="success";
            $_SESSION['toast']['msg']="Successfully logged In.";
            header("location:index.php");
            exit();
      }else{
            $_SESSION['toast']['msg']='Something went wrong, Please try again.';
      }
    }else{
        $_SESSION['toast']['msg']='Currently you are not registered with us, Or your account is deactivated. <br> Please contact to senior admin.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <?php include_once('inc/css.php');?>
    <title><?php echo $pageName ." | ". SITE_NAME?></title>
</head>
<body class="sidebar-pinned ">
    <main class="admin-main p-0">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-4  bg-white">
                    <div class="row align-items-center m-h-100">
                        <div class="mx-auto col-md-8">
                            <div class="p-b-20 text-center">
                                <p>
                                    <img src="assets/img/logo.svg" width="80" alt="">
                                </p>
                                <p class="admin-brand-content">
                                    Auction
                                </p>
                            </div>
                            <h3 class="text-center p-b-20 fw-400">Login</h3>
                            <form class="needs-validation" method="POST">
                                <div class="form-row">
                                    <div class="form-group floating-label col-md-12">
                                        <label>Email</label>
                                        <input type="email" required class="form-control" placeholder="Email" autocomplete="off" name="email">
                                    </div>
                                    <div class="form-group floating-label col-md-12">
                                        <label>Password</label>
                                        <input type="password" required class="form-control"  autocomplete="off" placeholder="Password" name="password">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block btn-lg" name="login">Login</button>
                            </form>
                            <p class="text-right p-t-10">
                                <a href="#!" class="text-underline">Forgot Password?</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 d-none d-md-block bg-cover" style="background-image: url('assets/img/login.svg');">
                </div>
            </div>
        </div>
    </main>
</body>
    <?php include_once('inc/js.php');?>
    <?php include_once('inc/search-bar.php');?>
</html>