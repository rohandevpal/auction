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
            mysqli_query($conn,"DELETE FROM `bnmi_bid` WHERE `auction_id` = '$id' ");
            mysqli_query($conn,"DELETE FROM `bnmi_attendance` WHERE `auction_id` = '$id' ");
            mysqli_query($conn,"DELETE FROM `bnmi_auction_participant` WHERE `auction_id` = '$id' ");
            mysqli_query($conn,"DELETE FROM `bnmi_winnig` WHERE `auction_id` = '$id' ");
            
            $_SESSION['toast']['msg']="Succesfully Deleted";
            header("location:completeAuctions.php");
            exit();
        }else{
            $_SESSION['toast']['msg']="Something Went Wrong";
        }
    }
    $dataA = mysqli_query($conn,"SELECT * FROM `".$tblPrefix."auctions` WHERE status = 3");
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
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Capacity</th>
                                                <th>Starting Price</th>
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
                                               <td>
                                                   <?php echo $i;?>
                                               </td>
                                               <td>
                                                   <?php echo $data['name']; ?>
                                               </td>
                                               <td>
                                                    <?php echo date("d/M/Y H:i:s",strtotime($data['starting_from'])); ?>
                                               </td>
                                               <td>
                                                   <?php
                                                        echo $data['capacity'];                                              
                                                   ?>
                                               </td>
                                               <td>
                                                   $<?php echo $data['starting_price'];?>
                                               </td>
                                               <td>
                                                    <a  href="view-auction.php?id=<?php echo $data['id']?>" class="edit-this btn btn-primary">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    
                                                    <a href="#" class="btn btn-danger delete-row" data-this-id="<?php echo $data['id']?>">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </a>

                                               </td>
                                            </tr>
                                        <?php }?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Capacity</th>
                                                <th>Starting Price</th>
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
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
</html>