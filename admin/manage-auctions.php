<?php 
    include_once("../inc/config.php");
    $pageName="Auction's";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }

        //change status...
    if(isset($_POST['id']) && $_POST['status']){
        $id = mysqli_real_escape_string($conn, ak_secure_string($_POST['id']));
        $status = mysqli_real_escape_string($conn, ak_secure_string($_POST['status']));
        mysqli_query($conn, "UPDATE `".$tblPrefix."auctions` SET `status` = '$status' WHERE `id`=$id");
        exit();
    }
    // Delete
    if(isset($_GET['delete-row'])){
        $id = mysqli_real_escape_string($conn, ak_secure_string($_GET['delete-row']));
        $dataQ = mysqli_query($conn, "UPDATE `".$tblPrefix."auctions` SET `status` = 0 WHERE `id`=$id" ); 
        if($dataQ==true){
            $_SESSION['toast']['msg']="Succesfully Deleted";
            header("location:manage-auctions.php");
            exit();
        }else{
            $_SESSION['toast']['msg']="Something Went Wrong";
        }
    }
    $dataA = mysqli_query($conn,"SELECT ac.*,ct.name as category FROM `".$tblPrefix."auctions` ac LEFT JOIN `".$tblPrefix."category` ct ON ac.cat = ct.id WHERE ac.status > 0 AND ac.status < 3");
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
                                <div class="card-body row">
                                    <div class="table-responsive p-t-10">
                                        <table id="example" class="table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Category</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Starting On</th>
                                                <th>Capacity</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $i=0;
                                                while($data = mysqli_fetch_assoc($dataA)){ 
                                                    $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $data['category']?></td>
                                                <td><?php echo auctionType($data['type'])?></td>
                                                <td><?php echo $data['name']?></td>
                                                <td><?php echo date("d/M/Y h:i:s a", strtotime($data['starting_from']))?></td>
                                                <td><?php echo $data['capacity']?></td>
                                               <td>
                                                    <span class="ml-5">
                                                        <label class="cstm-switch">
                                                            <input type="checkbox" data-this-id="<?php echo $data['id'];?>" <?php if($data['status']==2){ echo 'checked';}?>  name="option" class="cstm-switch-input change-status">
                                                            <span class="cstm-switch-indicator"></span>
                                                        </label>
                                                    </span>
                                               </td>
                                               <td> 
                                                    <a href="add-auction.php?id=<?php echo $data['id'];?>" class="btn btn-primary">
                                                        <i class="mdi mdi-grease-pencil"></i>
                                                    </a>
                                                    
                                                    <a href="#" class="btn btn-danger delete-row" data-this-id="<?php echo $data['id'];?>">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php }?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Category</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Starting On</th>
                                                <th>Capacity</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </main>
<a href="add-auction.php" class="btn-floating btn btn-primary" id="Add Section" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add">
    <i class="mdi mdi-plus"></i>
</a>
</body>
    <?php include_once('inc/js.php');?>
    <?php include_once('inc/search-bar.php');?>
</html>