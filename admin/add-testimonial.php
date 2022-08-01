<?php 
    include_once("../inc/config.php");
    $pageName="Add /Edit Testimonial";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }

    if(isset($_POST['submit'])){
        $name = mysqli_real_escape_string($conn,ak_secure_string($_POST['name']));
        $designation = mysqli_real_escape_string($conn,ak_secure_string($_POST['designation']));
        $review = htmlspecialchars($_POST['review']);
        $rating = mysqli_real_escape_string($conn,ak_secure_string($_POST['rating']));

        if(isset($_GET['id'])){
            $query = mysqli_query($conn,"UPDATE `".$tblPrefix."testimonial` SET `name`='$name',`designation`='$designation',`review`='$review',`rating`='$rating' WHERE id=".$_GET['id']);
            $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
        }else{
            $query = mysqli_query($conn,"INSERT INTO `".$tblPrefix."testimonial`(`name`, `designation`, `review`, `rating`, `date_time`, `status`) VALUES ('$name','$designation','$review','$rating','$cTime',2)");
            $id = mysqli_insert_id($conn);
        }

        if($query == true){
            $tmpName = $_FILES['image']['tmp_name'];
            if(file_exists($tmpName)){
                $fileName = $_FILES['image']['name'];
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if($ext=='jpg' || $ext=='jpeg' || $ext=='png'){
                    $fileName = rand(11111,99999).".".$ext;
                    if(move_uploaded_file($tmpName, '../assets/img/testimonial/'.$fileName)==true){
                        mysqli_query($conn, "UPDATE `".$tblPrefix."testimonial` SET `media`='$fileName' WHERE `id`='$id'");
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
            $_SESSION['toast']['msg']="Testimonial Successfully Saved";
            header('location:manage-testimonial.php');
            exit();
        }else{
            $_SESSION['toast']['type']="error";
            $_SESSION['toast']['msg']="Something went wrong, Please try again later.";        
        }
    }


    // Get Data
    if(isset($_GET['id'])){
        $dataTQ = mysqli_query($conn,"SELECT * FROM `".$tblPrefix."testimonial` WHERE id=".$_GET['id']." AND `status` = 2");
        $dataT = mysqli_fetch_assoc($dataTQ);
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
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group col-md-12">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="Name" value="<?php if(isset($_GET['id'])){echo $dataT['name'];}?>" name="name" autocomplete="OFF" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="designation">Designation</label>
                                            <input type="text" class="form-control" id="designation" placeholder="designation" value="<?php if(isset($_GET['id'])){echo $dataT['designation'];}?>" name="designation" autocomplete="OFF" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="review">Review</label>
                                            <textarea class="form-control" id="review" name="review">
                                                <?php if(isset($_GET['id'])){echo $dataT['review'];}?>
                                            </textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="head">Rating</label>
                                            <select class="form-control" name="rating" autocomplete="off" required="">
                                                <option value="0" selected="" disabled="">Select Rating</option>
                                                <option value="1" <?php if(isset($_GET['id'])){if($dataT['rating']==1){echo "selected";}}?>>1 Star</option>
                                                <option value="2" <?php if(isset($_GET['id'])){if($dataT['rating']==2){echo "selected";}}?>>2 Star</option>
                                                <option value="3" <?php if(isset($_GET['id'])){if($dataT['rating']==3){echo "selected";}}?>>3 Star</option>
                                                <option value="4" <?php if(isset($_GET['id'])){if($dataT['rating']==4){echo "selected";}}?>>4 Star</option>
                                                <option value="5" <?php if(isset($_GET['id'])){if($dataT['rating']==5){echo "selected";}}?>>5 Star</option>
                                            </select>
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
                                        <img src="../assets/img/testimonial/<?php if(isset($_GET['id'])){echo $dataT['media'];}else{echo 'default.png';}?>" class="img-fluid img-responsive m-auto mx-2"  >
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