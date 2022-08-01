<?php 
    include_once("../inc/config.php");
    $pageName="Add/Edit Banner";

    if(isset($_POST['submit'])){
        $title = mysqli_real_escape_string($conn,ak_secure_string($_POST['title']));
        $subTitle = mysqli_real_escape_string($conn,ak_secure_string($_POST['sub-title']));
        
        if(isset($_GET['id'])){
            $id=mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
            $query=mysqli_query($conn,"UPDATE `".$tblPrefix."banner` SET `title`='$title',`sub-title`='$subTitle',`date_time`='$cTime' WHERE id = " . $id);
        }else{
            $query=mysqli_query($conn,"INSERT INTO `".$tblPrefix."banner`(`type`, `title`, `sub-title`, `date_time`, `status`) VALUES (1,'$title','$subTitle','$cTime',2)");
            $id = mysqli_insert_id($conn);
        }

        if($query == true){
            $tmpName = $_FILES['backgroundImage']['tmp_name'];
            if(file_exists($tmpName)){
                $fileName = $_FILES['backgroundImage']['name'];
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if($ext=='jpg' || $ext=='jpeg' || $ext=='png'){
                    $fileName = rand(11111,99999).".".$ext;
                    if(move_uploaded_file($tmpName, '../assets/img/banner/'.$fileName)==true){
                        mysqli_query($conn, "UPDATE `".$tblPrefix."banner` SET `image`='$fileName' WHERE `id`='$id'");
                        $_SESSION['toast']['type']="success";
                        $_SESSION['toast']['msg']="Successfully updated.";
                    }else{
                        $_SESSION['toast']['msg']="Something went wrong, Please try again.";
                    }
                }else{
                        $_SESSION['toast']['msg']="Upload only image format(jpg,jpeg,png).";
                    }
            }

        }else{
            $_SESSION['toast']['type']="error";
            $_SESSION['toast']['msg']="Something went wrong, Please try again.";
        }

    }

    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
        $data = mysqli_query($conn,"SELECT `title`, `sub-title`, `image`, `date_time`, `status` FROM `bnmi_banner` WHERE id = $id");
        $bannerData = mysqli_fetch_assoc($data);
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
                        <div class="col-lg-8 mx-auto mt-2">
                            <div class="card py-3 m-b-30">
                                <div class="card-body">

                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group col-md-12">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" placeholder="Title" value="<?php echo $bannerData['title'];?>" name="title" autocomplete="OFF" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="sub-title">Sub Title</label>
                                            <input type="text" class="form-control" id="sub-title" placeholder="Sub Title" value="<?php echo $bannerData['sub-title'];?>" name="sub-title" autocomplete="OFF" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="custom-file mt-3">
                                                <input type="file" class="custom-file-input" id="inputllogo02" name="backgroundImage">
                                                <label class="custom-file-label" for="inputllogo02">Banner Background Image</label>
                                            </div>
                                        </div>

                                        <div class="form-row pt-3">
                                            <div class="form-group col-md-12">
                                                <button type="submit" class="btn btn-success m-auto" name="submit">Save</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class= "col-lg-4 mx-auto mt-2">
                            <div class="card py-3 m-b-30">
                                <div class="card-body">
                                    <h3 class="card-title text-center">Media<h3>
                                    <div class="col-lg-12 mb-3 text-center">
                                        <img src="../assets/img/banner/<?php if(isset($_GET['id'])){echo $bannerData['image'];}else{echo 'default.png';}?>" class="img-fluid img-responsive m-auto mx-2"  >
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