<?php 
    include_once("../inc/config.php");
    $pageName="Add/ Edit Who We Are";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }


if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn,ak_secure_string($_POST['name']));
    $content = htmlspecialchars_decode($_POST['content']);
    
    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
        $query= mysqli_query($conn,"UPDATE `".$tblPrefix."cms_pages` SET `title`='$name',`desc`='$content',`date_time`='$cTime' WHERE id = ".$id);
    }else{
        $query = mysqli_query($conn,"INSERT INTO `".$tblPrefix."cms_pages`(`type`, `title`, `desc`, `date_time`, `status`) VALUES (4,'$name','$content','$cTime',2)");
        $id = mysqli_insert_id($conn);
    }
    
    if($query == true){
        $tmpName = $_FILES['image']['tmp_name'];
            if(file_exists($tmpName)){
                $fileName = $_FILES['image']['name'];
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if($ext=='jpg' || $ext=='jpeg' || $ext=='png'){
                    $fileName = rand(11111,99999).".".$ext;
                    if(move_uploaded_file($tmpName, '../assets/img/'.$fileName)==true){
                        mysqli_query($conn, "UPDATE `".$tblPrefix."cms_pages` SET `img`='$fileName' WHERE `id`='$id'");
                        $_SESSION['toast']['type']="success";
                        $_SESSION['toast']['msg']="Successfully updated.";
                    }else{
                        $_SESSION['toast']['msg']="Something went wrong, Please try again.";
                    }
                }else{
                        $_SESSION['toast']['msg']="Upload only image format(jpg,jpeg,png).";
                    }
            }
        $_SESSION['toast']['type']="success";
        $_SESSION['toast']['msg']="Successfully Saved";
        header('location:who-we-are.php');
        exit();
    }else{
        $_SESSION['toast']['type']="error";
        $_SESSION['toast']['msg']="Something went wrong, Please try again later.";
    }
}

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
    $dataQHit = mysqli_query($conn,"SELECT `id`, `type`, `title`, `img`, `desc`, `date_time`, `status` FROM `".$tblPrefix."cms_pages` WHERE type = 
    4 AND id = ".$_GET['id']);
    $hitData = mysqli_fetch_assoc($dataQHit);
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
                        <div class="mx-auto mt-2 col-lg-8">
                            <div class="card py-3 m-b-30">
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group col-md-12">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="name" value="<?php  if(isset($_GET['id'])){echo $hitData['title'];}?>" name="name" autocomplete="OFF" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="content">Content</label>
                                            <textarea name="content" autocomplete="OFF" required="" id="editor"><?php  if(isset($_GET['id'])){echo $hitData['desc'];}?></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="custom-file mt-3">
                                                <input type="file" class="custom-file-input" id="inputllogo02" name="image">
                                                <label class="custom-file-label" for="inputllogo02">Image</label>
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
                                        <img src="../assets/img/<?php if(isset($_GET['id'])){echo $hitData['img']; }else{echo 'default.png';}?>" class="img-fluid img-responsive m-auto mx-2" >
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