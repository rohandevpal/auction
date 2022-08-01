<?php 
    include_once("../inc/config.php");
    $pageName="Wallet Trasnsactions";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }

    $dataWallet = mysqli_query($conn,"SELECT wlt.*, us.name as userName, us.email as userEmail,pk.type,pk.name as packageName,wl.balance FROM `".$tblPrefix."wallet_transactions` wlt LEFT JOIN `".$tblPrefix."users` us ON wlt.user = us.id LEFT JOIN `".$tblPrefix."packages` pk ON wlt.package = pk.id LEFT JOIN `".$tblPrefix."wallet` wl ON wlt.user = wl.user_id WHERE wlt.status != '0' ");
    if(isset($_GET['delete-row'])){
        $id = mysqli_real_escape_string($conn, ak_secure_string($_GET['delete-row']));
        $dataQ = mysqli_query($conn, "UPDATE `".$tblPrefix."wallet_transactions` SET `status` = 0 WHERE `id`=$id" ); 
        if($dataQ==true){
            $_SESSION['toast']['msg']="Succesfully Deleted";
            header("location:wallet-transactions.php");
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
                        <div class="col-lg-12 mx-auto mt-2">
                            <div class="card py-3 m-b-30">
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="">
                                            <table id="example" class="table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>User Name</th>
                                                        <th>User Email</th>
                                                        <th>Package</th>
                                                        <th>Wallet balance</th>
                                                        <th>Transaction time</th>
                                                        <th>Transaction Status</th>
                                                        <th>Action</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $i = 0;
                                                        while($data = mysqli_fetch_assoc($dataWallet)){
                                                            $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i;?></td>
                                                        <td><?php echo $data['userName']?></td>
                                                        <td><?php echo $data['userEmail']?></td>
                                                        <td><?php echo $data['packageName']?></td>
                                                        <td><?php echo $data['balance']?> Tokens</td>
                                                        <td><?php
                                                            $time = json_decode($data['data']);
                                                            echo date("d/M/Y H:i:s a",strtotime($time->time));
                                                        ?></td>
                                                        <td><?php echo $data['status']?></td>
                                                        <td>
                                                            <a href="view-transaction.php?id=<?php echo $data['id'];?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="View Transaction">
                                                                <i class="mdi mdi-eye"></i>
                                                            </a>
                                                <a href="#" class="btn btn-danger delete-row" data-this-id="<?php echo $data['id'];?>">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </a>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                        }
                                                    ?>
                                                </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>User Name</th>
                                                        <th>User Email</th>
                                                        <th>Package</th>
                                                        <th>Wallet balance</th>
                                                        <th>Transaction time</th>
                                                        <th>Transaction Status</th>
                                                        <th>Action</th> 
                                                    </tr>
                                                </tfoot>
                                            </table>
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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

    <?php include_once('inc/js.php');?>
    <?php include_once('inc/search-bar.php');?>

    </body>
</html>