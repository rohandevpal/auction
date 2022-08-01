<?php 
    include_once("../inc/config.php");
    $pageName="Feedback";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }
    // Delete Query
    if(isset($_GET['delete-row'])){
        $id = mysqli_real_escape_string($conn, ak_secure_string($_GET['delete-row']));
        $dataQ = mysqli_query($conn, "UPDATE `".$tblPrefix."query` SET `status` = 0 WHERE `id`=$id"); 
        if($dataQ==true){
            $_SESSION['toast']['msg']="Succesfully Deleted";
            header("location:feedback.php");
            exit();
        }else{
            $_SESSION['toast']['msg']="Something Went Wrong";
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
                        <div class="col-lg-10 mx-auto mt-2">
                            <div class="card py-3 m-b-30">
                                <div class="card-body">
                                    <div class="table-responsive p-t-10">
                                        <table id="example" class="table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $p=0;
                                                $dataProject=mysqli_query($conn,"SELECT `id`,`name`,`email`,`msg`,`status`,`date_time` FROM `".$tblPrefix."query` WHERE status>0 ");
                                                while($dataP=mysqli_fetch_assoc($dataProject)){
                                                    $p++;
                                            ?>
                                            <tr>
                                               <td><?php echo $p;?></td>
                                               <td><?php echo $dataP['name'];?></td>
                                               <td><?php echo $dataP['email'];?></td>
                                               <td><?php echo substr($dataP['msg'],0,70);?>...</td>
                                               <td><?php echo date("d-M-Y, h:i a",strtotime($dataP['date_time']));?></td>
                                               <td>
                                                <?php if($dataP['status']==1){
                                                    echo'Pending';
                                                }elseif($dataP['status']==2){
                                                    echo'Replied';
                                                }?>
                                               </td>
                                               <td> 
                                                    <a href="reply-mail.php?id=<?php echo $dataP['id'];?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Reply">
                                                        <i class="mdi mdi-reply"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger delete-row" data-this-id="<?php echo $dataP['id'];?>" data-toggle="tooltip" data-placement="top" data-original-title="Delete">
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
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Date</th>
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
</body>
    <?php include_once('inc/js.php');?>
    <?php include_once('inc/search-bar.php');?>
</html>