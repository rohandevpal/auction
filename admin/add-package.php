<?php 
    include_once("../inc/config.php");
    $pageName="Add/ Edit Packages";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }


    if(isset($_POST['submit'])){
        $name = mysqli_real_escape_string($conn,ak_secure_string($_POST['name']));
        $token = mysqli_real_escape_string($conn,ak_secure_string($_POST['token']));
        $type = mysqli_real_escape_string($conn,ak_secure_string($_POST['type']));
        $description = htmlspecialchars($_POST['description']);
        $amount = mysqli_real_escape_string($conn,ak_secure_string($_POST['amount']));

        if(isset($_GET['id'])){
            $query = mysqli_query($conn,"UPDATE `".$tblPrefix."packages` SET `type` = '$type', `token`='$token', `name`='$name',`description`='$description',`sale_price`='$amount' WHERE id = ".$_GET['id']);
            $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
        }else{
            $query = mysqli_query($conn,"INSERT INTO `".$tblPrefix."packages`(`type`, `token`, `name`, `description`, `price`, `sale_price`, `date_time`, `status`) VALUES ('$type', '$token','$name','$description','$amount','$amount','$cTime',2)");
            $id = mysqli_insert_id($conn);
        }

        if($query == true){
            $_SESSION['toast']['type']="success";
            $_SESSION['toast']['msg']="Package Successfully Saved";
            header('location:manage-packages.php');
            exit();
        }else{
            $_SESSION['toast']['type']="error";
            $_SESSION['toast']['msg']="Something went wrong, Please try again later.";
        }
    }

    $dataQ = mysqli_query($conn,"SELECT * FROM `bnmi_packages` WHERE id = ".$_GET['id']);
    $dataP = mysqli_fetch_assoc($dataQ);

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
                                    <form method="POST">
                                        <div class="form-group col-md-12">
                                            <label for="head">Package Type</label>
                                            <select class="form-control" name="type" autocomplete="off" required="">
                                                <option value="0" selected="" disabled="">Select Type</option>
                                                <option value="1" <?php if($dataP['type']==1){echo "selected";}?> >Normal</option>
                                                <option value="2" <?php if($dataP['type']==2){echo "selected";}?> >VIP</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="name" value="<?php if(isset($_GET['id'])){echo $dataP['name'];}?>" name="name" autocomplete="OFF" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="token">Number of Tokens</label>
                                            <input type="text" class="form-control" id="token" placeholder="token" value="<?php if(isset($_GET['id'])){echo $dataP['token'];}?>" name="token" autocomplete="OFF" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description">
                                                <?php if(isset($_GET['id'])){echo $dataP['description'];}?>
                                            </textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="text" name="amount" placeholder="Amount" value="<?php if(isset($_GET['id'])){echo $dataP['sale_price'];}?>" class="form-control" aria-label="Amount (to the nearest dollar)">
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
                    </div>
                </div>
            </section>
        </section>
    </main>

</body>
    <?php include_once('inc/js.php');?>
    <?php include_once('inc/search-bar.php');?>
</html>