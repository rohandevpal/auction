<?php 
    include_once("../inc/config.php");
    $pageName="Banner";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
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
    <?php include_once('inc/sidebar.php');?>
    <main class="admin-main">
        <?php include_once('inc/nav.php');?>
        <section class="admin-content ">
            <?php include_once("inc/breadcrum.php");?>
            <section class="pull-up">
                <div class="container">
                    <div class="row ">
                        <div class="col-lg-10 mx-auto mt-2">
                            <div class="card py-3 m-b-30">
                                <div class="card-body row justify-content-center">
                                    <div class="col-lg-12 m-b-30">
                                        <div class="card m-b-30">
                                            <div class="card-media">
                                                <img class="card-img-top" src="assets/img/social/s18.jpg" alt="Card image cap">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Card title</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                                    of the card's content.</p>
                                                <a href="add-package.php?id=" class="btn btn-primary">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                    
                                                    <a href="#" class="btn btn-danger delete-row" data-this-id="">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </a>

                                                    <span class="ml-5">
                                                        <label class="cstm-switch">
                                                            <input type="checkbox" data-this-id=">" name="option" class="cstm-switch-input change-status" <?php if($dataPackage['status']==2){ echo 'checked';}?>>
                                                            <span class="cstm-switch-indicator"></span>
                                                        </label>
                                                    </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </main>

</body>
    <?php include_once('inc/js.php');?>
    <?php include_once('inc/search-bar.php');?>
</html>