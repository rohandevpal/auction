<?php 
    include_once("../inc/config.php");
    $pageName="Manage Banners";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }

    $dataB = mysqli_query($conn,"SELECT `id`, `type`, `title`, `sub-title`, `image`, `date_time`, `status` FROM `bnmi_banner` WHERE status > 0");

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
                                <?php while($data = mysqli_fetch_assoc($dataB)){ ?>
                                <div class="card-body">
                                    <div class="card ">
                                        <div class="card-media">
                                            <img class="card-img-top" src="../assets/img/banner/<?php echo $data['image']?>" alt="Banner">

                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $data['title']?></h5>
                                            <p class="card-text"><?php echo $data['sub-title']?></p>
                                            <a href="add-banner.php?id=<?php echo $data['id']?>" class="btn btn-primary">Edit</a>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
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