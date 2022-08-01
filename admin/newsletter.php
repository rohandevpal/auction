<?php 
    include_once("../inc/config.php");
    $pageName="Newsletter";
    $icon = "far fa-envelope"; 
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }
    // Delete Query
    if(isset($_GET['delete-row'])){
        $id = mysqli_real_escape_string($conn, ak_secure_string($_GET['delete-row']));
        $dataQ = mysqli_query($conn, "UPDATE `".$tblPrefix."subscriptions` SET `status` = 0 WHERE `id`=$id"); 
        if($dataQ==true){
            $_SESSION['toast']['msg']="Succesfully Deleted";
            header("location:newsletter.php");
            exit();
        }else{
            $_SESSION['toast']['msg']="Something Went Wrong";
        }
    }
    
    // Change Status
    if(isset($_POST['id']) && isset($_POST['status'])){
        $id=mysqli_real_escape_string($conn,$_POST['id']);
        $status=mysqli_real_escape_string($conn,$_POST['status']);
        mysqli_query($conn,"UPDATE `".$tblPrefix."subscriptions` SET `status`=$status WHERE id=$id");
        exit();
    }

    if(isset($_POST['SendMails'])){
        if(isset($_POST['nid'])){
            $emails = $_POST['nid'];
            $template = mysqli_real_escape_string($conn,$_POST['template']);
            
            if(count($emails) > 0 ){
                $mailarray = array();
                $idMail = array(); //string
                foreach($emails as $mail => $eid){                
                    array_push($mailarray,$eid);              	
                }
                $in = '(' . implode(',', $mailarray) .')';

                $emailData= mysqli_query($conn,"SELECT `email` FROM `bnmi_subscriptions` WHERE id IN $in");
                while($obj = mysqli_fetch_assoc($emailData)){
                    if($obj){
                        array_push($idMail,$obj['email']);
                    }
                 }
               
                $campmMails = smtp_bulk_mailer($idMail,$template);

                if($campmMails ==true){
                    $_SESSION['toast']['type']="success";
                    $_SESSION['toast']['msg']="Campaign mails successfully sent.";
                    header("location:newsletter.php");
                    exit();
                }else{
                    $_SESSION['toast']['type']="error";
                    $_SESSION['toast']['msg']="Something went wrong, Please try again later.";
                    header("location:newsletter.php");
                    exit();
                }

            }else{
                $_SESSION['toast']['type']="warning";
                $_SESSION['toast']['msg']="Please, select emails to proceed.";
                header("location:newsletter.php");
                exit();
            }
        }else{
            $_SESSION['toast']['type']="warning";
            $_SESSION['toast']['msg']="Please, select emails to proceed.";
            header("location:newsletter.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <?php include_once('inc/css.php');?>
    <title><?php echo $pageName ." | ". SITE_NAME?></title>
    <style>
        .select2{
            width:100% !important;
        }
        .select2-search {
            display:none;
        }
    </style>
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
                        <div class="col-lg-12 mx-auto mt-2">
                            <div class="card py-3 m-b-30">
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="table-responsive p-t-10">
                                            <div class="row">
                                                <div class="form-group col-2">
                                                    <button type="button" id="ckbCheckAll" class="btn btn-primary">Select All & Send</button>
                                                </div>
                                                <div class="form-group col-2">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Select & Send</button>
                                                </div>
                                            </div>
                                            <table id="example" class="table" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Select</th>
                                                    <th>Id</th>
                                                    <th>Email</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                    $p=0;
                                                    $dataProject=mysqli_query($conn,"SELECT `id`,`email`,`status`,`date_time` FROM `".$tblPrefix."subscriptions` WHERE status>0 ");
                                                    while($dataP=mysqli_fetch_assoc($dataProject)){
                                                        $p++;
                                                ?>
                                                <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input id_checkBox" name="nid[]" value="<?php echo $dataP['id'];?>" id="customCheck<?php echo $p;?>">
                                                        <label class="custom-control-label" for="customCheck<?php echo $p;?>"></label>
                                                    </div>
                                                </td>
                                                <td><?php echo $p;?></td>
                                                <td><?php echo $dataP['email'];?></td>
                                                <td><?php echo date("d-M-Y, h:i a",strtotime($dataP['date_time']));?></td>
                                                <td>
                                                        <label class="cstm-switch">
                                                            <input type="checkbox" name="option" value="1" class="cstm-switch-input change-status" data-this-id="<?php echo $dataP['id'];?>" <?php if($dataP['status']==2){ echo ' checked';}?>>
                                                            <span class="cstm-switch-indicator "></span>
                                                        </label>
                                                </td>
                                                <td> 
                                                        <a href="reply-newsletter.php?id=<?php echo $dataP['id'];?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Reply">
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
                                                    <th>Select</th>
                                                    <th>Id</th>
                                                    <th>Email</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>     
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Send Bulk Mail</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body pb-5">
                                                        <input type="hidden" name="email_id[]">
                                                        <div class="form-group col-md-12">
                                                            <label for="head">Subject</label>
                                                            <input type="subject" class="form-control" id="subject" placeholder="subject"  name="subject" autocomplete="off" required="">
                                                        </div>
                                                        <div class="form-group ">
                                                            <label  class="font-secondary">Select Campaign template </label>
                                                            <select  class="form-control js-select2 w-100" name="template" autocomplete="off" required >
                                                                <option selected value="0" disabled>Select Template</option>
                                                                <?php
                                                                    $campTemp = mysqli_query($conn,"SELECT `id`, `name` FROM `".$tblPrefix."campaign` WHERE `status`=2"); 
                                                                    while($dataCamp = mysqli_fetch_assoc($campTemp)){
                                                                ?>
                                                                    <option value="<?php echo $dataCamp['id']?>"><?php echo $dataCamp['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary" name="SendMails">Submit</button>
                                                    </div>
                                                </div>
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
    <script>
        $(document).ready(function () {
            $("#ckbCheckAll").click(function () {
                $(".id_checkBox").attr('checked', "checked");
                $('.bd-example-modal-lg').modal('show');
            });
        });
    </script>
    </body>
</html>