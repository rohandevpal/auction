<?php 
    include_once("../inc/config.php");
    $pageName="Campaign";
    $icon = "fas fa-flag"; 
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }
    // Delete Query
    if(isset($_GET['delete-row'])){
        $id = mysqli_real_escape_string($conn, ak_secure_string($_GET['delete-row']));
        $dataQ = mysqli_query($conn, "UPDATE `".$tblPrefix."campaign` SET `status` = 0 WHERE `id`=$id"); 
        if($dataQ==true){
            $_SESSION['toast']['msg']="Succesfully Deleted";
            header("location:campaign.php");
            exit();
        }else{
            $_SESSION['toast']['msg']="Something Went Wrong";
        }
    }
        
    // Change Status
    if(isset($_POST['id']) && isset($_POST['status'])){
        $id=mysqli_real_escape_string($conn,$_POST['id']);
        $status=mysqli_real_escape_string($conn,$_POST['status']);
        
        mysqli_query($conn,"UPDATE `".$tblPrefix."campaign` SET `status`=$status WHERE id=$id");
        exit();
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
                                    
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="add-campaign.php"class="btn btn-primary">Create Campaign +</a>
                                        </div>
                                    </div>
                                    <div class="table-responsive p-t-10">
                                        <table id="example" class="table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $campaign=mysqli_query($conn,"SELECT `id`, `name`,  `title`, `status`, `date_time` FROM `".$tblPrefix."campaign` WHERE `status`>0"); 
                                                    $i=0;
                                                    while($cData = mysqli_fetch_assoc($campaign)){
                                                        $i++;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $i;?>
                                                    </td>
                                                    <td>
                                                        <?php echo $cData['name'];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $cData['title'];?>
                                                    </td>
                                                    <td>
                                                        <?php echo date("d-M-Y",strtotime($cData['date_time']));?>
                                                    </td>
                                                    <td>
                                                        <label class="cstm-switch">
                                                            <input type="checkbox" name="option" value="1" class="cstm-switch-input change-status" data-this-id="<?php echo $cData['id'];?>" <?php if($cData['status']==2){ echo ' checked';}?>>
                                                            <span class="cstm-switch-indicator "></span>
                                                        </label>
                                                    </td>
                                                    <td> 
                                                        <a href="add-campaign.php?id=<?php echo $cData['id'];?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-danger delete-row" data-this-id="<?php echo $cData['id'];?>" data-toggle="tooltip" data-placement="top" data-original-title="Delete">
                                                            <i class="mdi mdi-trash-can"></i>
                                                        </a>
                                                    </td>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Title</th>
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
    <script>
        //change status..
        $('.change-status').on('change', function(){
            var id = $(this).data('this-id'),
                status =0;

            if($(this).prop('checked')==true){
                status = 2;
            }else{
                status = 1;
            }

            $.ajax({
                type: 'post',
                url : '',
                data: {id : id, status: status},
                success: function(data){
                    Materialize.toast("Changes saved.", 3000);

                },
                error: function(data){
                    Materialize.toast("Something went wrong, Please try again.", 3000);
                }
            });
        });
    </script>
</html>