<?php 
    include_once("../inc/config.php");
    $pageName="Add/Edit Blog";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }

    if(isset($_POST['submit'])){ 
        $name=mysqli_real_escape_string($conn,ak_secure_string($_POST['name']));
        $url=mysqli_real_escape_string($conn,ak_secure_string($_POST['url']));
        $cat=mysqli_real_escape_string($conn,ak_secure_string($_POST['cat']));
        $descShort=mysqli_real_escape_string($conn,ak_secure_string($_POST['short']));
        $desc=htmlspecialchars($_POST['desc']);
        $mTitle=mysqli_real_escape_string($conn,ak_secure_string($_POST['mtitle']));
        $mDesc=mysqli_real_escape_string($conn,ak_secure_string($_POST['mdesc']));
        $mKeyword=mysqli_real_escape_string($conn,ak_secure_string($_POST['mkeyword']));
        if(isset($_GET['id'])){
            $id=mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
            $query="UPDATE `".$tblPrefix."blog` SET `name`='$name',`url`='$url',`cat`='$cat',`short_desc`='$descShort',`desc`='$desc',`post_date`='$cTime',`meta_title`='$mTitle',`meta_keyword`='$mKeyword',`meta_desc`='$mDesc' WHERE `id`='$id'";
        }else{
            $query="INSERT INTO `".$tblPrefix."blog`(`name`, `url`, `cat`, `short_desc`, `desc`, `post_date`, `meta_title`, `meta_keyword`, `meta_desc`, `status`) VALUES ('$name','$url','$cat','$descShort','$desc','$cTime','$mTitle','$mKeyword','$mDesc',2)";
            $id = mysqli_insert_id($conn);
        }
        if(mysqli_query($conn,$query)==true){
            $tmpName = $_FILES['image']['tmp_name'];
            if(file_exists($tmpName)){
                $fileName = $_FILES['image']['name'];
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if($ext=='jpg' || $ext=='jpeg' || $ext=='png'){
                    $fileName = rand(11111,99999).".".$ext;
                    if(move_uploaded_file($tmpName, '../assets/img/blog/'.$fileName)==true){
                        mysqli_query($conn, "UPDATE `".$tblPrefix."blog` SET `img`='$fileName' WHERE `id`='$id'");
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

    // Update data 
    if(isset($_GET['id'])){
        $id=mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
        $data=mysqli_query($conn,"SELECT * FROM `".$tblPrefix."blog` WHERE id='$id'");
        $dataB=mysqli_fetch_assoc($data);
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
                        <div class= "mx-auto mt-2 col-lg-8">
                            <div class="card py-3 m-b-30">
                                <div class="card-body">
                                    <h3 class="card-title text-center"><?php echo $pageName;?></h3>
                                    <div class="col-lg-12 mb-3">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="form-group col-md-12">
                                                <label for="head">Blog Name</label>
                                                <input type="text" class="form-control" id="name" placeholder="Heading" value="<?php if(isset($_GET['id'])){echo $dataB['name'];}?>" name="name" autocomplete="off" required="">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="head">Blog Url</label>
                                                <input type="text" class="form-control slug" id="url" placeholder="Heading" value="<?php if(isset($_GET['id'])){echo $dataB['url'];}?>" name="url" autocomplete="off" required="">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="head">Blog Category</label>
                                                <select class="form-control" name="cat" autocomplete="off" required="">
                                                    <option value="" selected="" disabled="">Select Category</option>
                                                    <?php 
                                                        $dataCat=mysqli_query($conn,"SELECT `id`,`name` FROM `".$tblPrefix."category` WHERE status=2 AND type = 1 ");
                                                        while($cat=mysqli_fetch_assoc($dataCat)){
                                                    ?>
                                                    <option value="<?php echo $cat['id'];?>" <?php if(isset($_GET['id'])){if($dataB['cat']==$cat['id']){echo "selected";}}?> > <?php echo $cat['name'];?></option>
                                                <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="custom-file mt-3">
                                                    <input type="file" class="custom-file-input" id="inputllogo02" name="image">
                                                    <label class="custom-file-label" for="inputllogo02">Image</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="text">Blog Short Content</label>
                                               <textarea class="form-control" name="short"><?php if(isset($_GET['id'])){echo htmlspecialchars_decode($dataB['short_desc']);}?></textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="text">Blog Content</label>
                                               <textarea class="form-control" name="desc" id="editor"><?php if(isset($_GET['id'])){echo htmlspecialchars_decode($dataB['desc']);}?></textarea>
                                            </div> 
                                            <div class="form-group col-md-12">
                                                <label for="mtitle">Blog Meta Title</label>
                                                <input type="text" class="form-control" id="mtitle" placeholder="Heading" value="<?php if(isset($_GET['id'])){echo $dataB['meta_title'];}?>" name="mtitle" autocomplete="off" required="">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="keyword">Blog Meta Keyword</label>
                                                <input type="text" class="form-control" id="keyword" placeholder="Heading" value="<?php if(isset($_GET['id'])){echo $dataB['meta_keyword'];}?>" name="mkeyword" autocomplete="off" required="">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="mdesc">Blog Meta Description</label>
                                                <input type="text" class="form-control" id="mdesc" placeholder="Heading" value="<?php if(isset($_GET['id'])){echo $dataB['meta_desc'];}?>" name="mdesc" autocomplete="off" required="">
                                            </div>
                                            <div class="form-row pt-3">
                                                <div class="form-group col-md-12">
                                                    <button type="submit" class="btn btn-success m-auto submitButton" name="submit">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class= "col-lg-4 mx-auto mt-2">
                            <div class="card py-3 m-b-30">
                                <div class="card-body">
                                    <h3 class="card-title text-center">Media<h3>
                                    <div class="col-lg-12 mb-3 text-center">
                                        <img src="../assets/img/blog/<?php if(isset($_GET['id'])){echo $dataB['img'];}else{echo 'default.png';}?>" class="img-fluid img-responsive m-auto mx-2"  >
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

    <script>
        const slug = document.querySelector(`.slug`);
        const submitButton = document.querySelector('.submitButton')

        slug.addEventListener('blur', function () {
            $.ajax({
                type: 'post',
                url : 'inc/checkSlug.php',
                data: {slug : slug.value},
                success: function(response){
                        console.log(response);
                    if(response == 1){
                        // alertify.message("Changes saved.", 3000);
                    }else{
                        alertify.message("Slug already exists .", 3000);
                        submitButton.disabled = true
                    }
                },
                error: function(response){
                    console.log(response);
                    alertify.message("Something went wrong, Please try again.", 3000);
                }
            });
        });
    </script>

</html>