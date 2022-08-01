<?php 
    include_once("../inc/config.php");
    $pageName="Add/Edit Campaign";
    $icon="fas fa-flag";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }

    if(isset($_GET['id'])){
        $id=mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
        $data=mysqli_query($conn,"SELECT * FROM `".$tblPrefix."campaign` WHERE id='$id'");
        $query=mysqli_fetch_assoc($data);
    }
    
    if(isset($_POST['submit'])){
        $name=mysqli_real_escape_string($conn,ak_secure_string($_POST['name']));
        $title=mysqli_real_escape_string($conn,ak_secure_string($_POST['title']));
        $button=mysqli_real_escape_string($conn,ak_secure_string($_POST['button']));
        $message=htmlspecialchars($_POST['message']);

        if(isset($_GET['id'])){
            $id=mysqli_real_escape_string($conn,$_GET['id']);
            $Dataquery = mysqli_query($conn,"UPDATE `".$tblPrefix."campaign` SET `name`='$name',`title`='$title',`content`='$message',`link`='$button' WHERE id=$id");
        }else{
            $Dataquery = mysqli_query($conn,"INSERT INTO `".$tblPrefix."campaign`(`name`, `title`, `content`, `link`, `status`, `date_time`) VALUES ('$name','$title','$message','$button',2,'$cTime')");
            $id = mysqli_insert_id($conn);
        }

        if($Dataquery == true){
            $tmpNameImg = $_FILES['banner']['tmp_name'];
            if(file_exists($tmpNameImg)){
                $fileNameImg = $_FILES['banner']['name'];
                $ext = pathinfo($fileNameImg, PATHINFO_EXTENSION);
                if($ext=='jpg' || $ext=='jpeg' || $ext=='png'){
                $fileNameImg= rand(11111,99999).$id.".".$ext;
                    if(move_uploaded_file($tmpNameImg, '../assets/img/campaign/'.$fileNameImg)==true){
                        mysqli_query($conn, "UPDATE `".$tblPrefix."campaign` SET `image`='$fileNameImg' WHERE id=".$id);
                        $_SESSION['toast']['type']="success";
                        $_SESSION['toast']['msg']="Successfully saved";
                        // header("refresh:0");
                        // exit();
                    }
                }else{
                    $_SESSION['toast']['msg']="Enter Image Format Only(jpg,jpeg,png).";
                }
            }
            $_SESSION['toast']['type']="success";
            $_SESSION['toast']['msg']="Successfully saved";
            // header("refresh:0");
            // exit();
        }else{
            $_SESSION['toast']['type']="error";
            $_SESSION['toast']['msg']= "Something went wrong, Please try again.";
            // header("refresh:0");
            // exit();
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
                                            <label for="head">Campaign Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="Name" value="<?php if(isset($_GET['id'])){echo $query['name'];}?>" name="name" autocomplete="off" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="head">Campaign Template Title</label>
                                            <input type="text" class="form-control" id="Title" placeholder="Title" value="<?php if(isset($_GET['id'])){echo $query['title'];}?>" name="title" autocomplete="off" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" name="banner" class="custom-file-input" id="inputGroupFile02">
                                                    <label class="custom-file-label" for="inputGroupFile02"
                                                        >Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="head">Campaign Template Message</label>
                                             <textarea id="editor" class="form-control" name="message">
                                                <?php if(isset($_GET['id'])){echo $query['content'];}?>
                                                </textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="head">Campaign Template Button Link</label>
                                            <input type="text" class="form-control" id="button" value="#" placeholder="button" value="<?php if(isset($_GET['id'])){echo $query['link'];}?>" name="button" autocomplete="off" required="">
                                        </div>
                                        <div class="form-row pt-3">
                                            <div class="form-group col-md-12">
                                                <button type="submit" class="btn btn-success m-auto" name="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-2">
                            <div class="card py-3 m-b-30">
                                <div class="card-body">
                                    <h5>Campaign Template Image</h5>
                                    <img src="../assets/img/campaign/<?php if(isset($_GET['id'])){echo $query['image']; }else{echo 'default.png';}?>" alt="Image">
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
</html>