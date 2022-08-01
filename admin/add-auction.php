<?php 
    include_once("../inc/config.php");
    $pageName="Add/Edit Auction";

    if(isset($_POST['submit'])){
        $cat = mysqli_real_escape_string($conn,ak_secure_string($_POST['cat']));
        $type = mysqli_real_escape_string($conn,ak_secure_string($_POST['type']));
        $name = mysqli_real_escape_string($conn,ak_secure_string($_POST['name']));
        $storePrice = mysqli_real_escape_string($conn,ak_secure_string($_POST['storePrice']));
        $startingPrice = mysqli_real_escape_string($conn,ak_secure_string($_POST['startingPrice']));
        $startFrom = mysqli_real_escape_string($conn,$_POST['startFrom']);
        $startTime = mysqli_real_escape_string($conn,$_POST['startTime']);
        $capacity = mysqli_real_escape_string($conn,$_POST['capacity']);
        $entryPrice =  mysqli_real_escape_string($conn,$_POST['entryPrice']);
        $short_desc = mysqli_real_escape_string($conn,ak_secure_string($_POST['short_desc']));
        $desc = htmlspecialchars($_POST['desc']);
        $dateTime = $startFrom.' '.$startTime.':00';
        if(isset($_GET['id'])){
            $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
            $query = mysqli_query($conn,"UPDATE `".$tblPrefix."auctions` SET `cat`='$cat',`type`='$type',`name`='$name',`short_desc`='$short_desc',`desc`='$desc',`store_price`='$storePrice',`starting_price`='$startingPrice', `entry_price`='$entryPrice',`starting_from`='$dateTime', `capacity` = $capacity,`date_time`='$cTime' WHERE id = '$id'") ;
            $auction_check = mysqli_query($conn,"SELECT * FROM `bnmi_Time` WHERE `auction_id`='$id'");
         if(mysqli_num_rows($auction_check)>0){
            $data = mysqli_query($conn,"UPDATE `bnmi_Time` SET `time`='$dateTime' WHERE  `auction_id`='$id' ");
            }
            else{
                $ids = mysqli_insert_id($conn);
                $data = mysqli_query($conn,"INSERT INTO `bnmi_Time`(`auction_id`, `time`) VALUES ('$id', '$dateTime')");
            }
        }else{
            $query = mysqli_query($conn,"INSERT INTO `".$tblPrefix."auctions`( `cat`, `type`, `name`, `short_desc`, `desc`, `store_price`, `starting_price`, `entry_price`, `starting_from`, `capacity`, `date_time`, `status`) VALUES ('$cat','$type','$name','$short_desc','$desc','$storePrice','$startingPrice', '$entryPrice','$dateTime', '$capacity','$cTime',2)") ;
            $id = mysqli_insert_id($conn);
            $data = mysqli_query($conn,"INSERT INTO `bnmi_Time`(`auction_id`, `time`) VALUES ('$id', '$dateTime')");
        }



        if($query == true){
            $tmpName = $_FILES['image']['tmp_name'];
            if(file_exists($tmpName)){
                $fileName = $_FILES['image']['name'];
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if($ext=='jpg' || $ext=='jpeg' || $ext=='png'){
                    $fileName = rand(11111,99999).".".$ext;
                    if(move_uploaded_file($tmpName, '../assets/img/auction/'.$fileName)==true){
                        mysqli_query($conn, "UPDATE `".$tblPrefix."auctions` SET `image`='$fileName' WHERE `id`='$id'");
                        $_SESSION['toast']['type']="success";
                        $_SESSION['toast']['msg']="Successfully updated.";
                        header('refresh:0');
                        exit();
                    }else{
                        $_SESSION['toast']['msg']="Something went wrong, Please try again.";
                    }
                }else{
                        $_SESSION['toast']['msg']="Upload only image format(jpg,jpeg,png).";
                    }
            }
            $_SESSION['toast']['type']="success";
            $_SESSION['toast']['msg']="Successfully updated.";
            header('refresh:0');
            exit();
        }else{
            $_SESSION['toast']['type']="error";
            $_SESSION['toast']['msg']="Something went wrong, Please try again.";
            header('refresh:0');
            exit();
        }

    }

    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
        $data = mysqli_query($conn,"SELECT `id`, `cat`, `type`, `name`, `image`, `short_desc`, `desc`, `store_price`, `starting_price`, `entry_price`, `starting_from`, `capacity`, `date_time`, `status` FROM `".$tblPrefix."auctions` WHERE `id` = '$id'");
        $dataAuc = mysqli_fetch_assoc($data);
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
                                            <label for="head">Auction Category</label>
                                            <select class="form-control" name="cat" autocomplete="off" required="">
                                                <option value="" selected="" disabled="">Select Category</option>
                                                <?php 
                                                    $dataCat=mysqli_query($conn,"SELECT `id`,`name` FROM `".$tblPrefix."category` WHERE status=2 AND type = 2 ");
                                                    while($cat=mysqli_fetch_assoc($dataCat)){
                                                ?>
                                                <option value="<?php echo $cat['id'];?>" <?php if(isset($_GET['id'])){if($dataAuc['cat']==$cat['id']){echo "selected";}}?> > <?php echo $cat['name'];?></option>
                                            <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="head">Auction Type</label>
                                            <select class="form-control" name="type" autocomplete="off" required="">
                                                <option value="" selected="" disabled="">Select Type</option>
                                                <?php 
                                                    foreach(auctionType(0) as $key =>  $value){
                                                ?>
                                                <option value="<?php echo $key;?>" <?php if(isset($_GET['id'])){if($key==$dataAuc['type']){echo "selected";}}?> > <?php echo $value;?></option>
                                            <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="name" value="<?php if(isset($_GET['id'])){  echo $dataAuc['name']; } ?>" name="name" autocomplete="OFF" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="storePrice">Store Price</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number" name="storePrice" placeholder="Store Price" value="<?php if(isset($_GET['id'])){   echo $dataAuc['store_price']; }?>" class="form-control" aria-label="Amount (to the nearest dollar)">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="startingPrice">Starting Price</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number" name="startingPrice" placeholder="Starting Price" value="<?php  if(isset($_GET['id'])){  echo $dataAuc['starting_price'];}?>" class="form-control" aria-label="Amount (to the nearest dollar)">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="entryPrice">Entry Price in Tokens</label>
                                            <input type="text" class="form-control" id="entryPrice" placeholder="Entry Price" value="<?php if(isset($_GET['id'])){   echo $dataAuc['entry_price'];}?>" name="entryPrice" autocomplete="OFF" required="">
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label for="startFrom">Starting Date </label>
                                                <input type="date" class="form-control" placeholder="Select a Date" value="<?php if(isset($_GET['id'])){   echo date("Y-m-d",strtotime($dataAuc['starting_from']));}?>" name="startFrom" autocomplete="OFF" required="">
                                            </div>
                                            <div class="col-6">
                                                <label for="startFrom">Starting Time</label>
                                                <input type="time" class="form-control" placeholder="Select a Time" value="<?php if(isset($_GET['id'])){   echo date("H:i",strtotime($dataAuc['starting_from']));}?>" name="startTime" autocomplete="OFF" required="">

                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="capacity">Capacity</label>
                                            <input type="text" class="form-control" id="capacity" placeholder="Capacity" value="<?php if(isset($_GET['id'])){   echo $dataAuc['capacity'];}?>" name="capacity" autocomplete="OFF" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="short_desc">Short Description</label>
                                            <textarea class="form-control" name="short_desc" id="short_desc"><?php if(isset($_GET['id'])){echo $dataAuc['short_desc'];}?></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                                <label for="text">Description</label>
                                               <textarea class="form-control" name="desc" id="editor"><?php if(isset($_GET['id'])){echo htmlspecialchars_decode($dataAuc['desc']);}?></textarea>
                                            </div> 
                                        <div class="form-group col-md-12">
                                            <div class="custom-file mt-3">
                                                <input type="file" name = "image" class="custom-file-input" id="inputllogo02">
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
                                        <img src="../assets/img/auction/<?php if(isset($_GET['id'])){echo $dataAuc['image'] ;}else{echo 'default.png';}?>" class="img-fluid img-responsive m-auto mx-2"  >
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