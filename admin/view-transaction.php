<?php 
    include_once("../inc/config.php");
    $pageName="View Transaction";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }

    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));

        $query = mysqli_query($conn,"SELECT wlt.*, us.name as userName, us.email as userEmail,pk.type,pk.name as packageName,pk.token FROM `".$tblPrefix."wallet_transactions` wlt LEFT JOIN `".$tblPrefix."users` us ON wlt.user = us.id LEFT JOIN `".$tblPrefix."packages` pk ON wlt.package = pk.id WHERE wlt.id = $id");
        
        if(mysqli_num_rows($query) == 0 ){
            $_SESSION['toast']['type'] = "warning";
            $_SESSION['toast']['msg'] = "No Data Found.";
            header('location:wallet-transactions.php');
        }else{
            $data = mysqli_fetch_assoc($query);
        }
    }
    
    $json = json_decode($data['data']);
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <?php include_once('inc/css.php');?>
    <title><?php echo $pageName ." | ". SITE_NAME?></title>
    <style>
        .transactionData{
            font-size:18px;
        }
        .transactionKeys{
            text-transform: capitalize;
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
                        <div class="col-lg-8 mx-auto mt-2">
                            <div class="card py-3 m-b-30">
                                <div class="card-body">
                                    <div class='row transactionData py-2'>
                                        <div class='col-6 transactionKeys'>User: </div>
                                        <div class='col-6 transactionValues text-right'><?php echo $data['userName']; ?></div>
                                    </div>
                                    <div class='row transactionData py-2'>
                                        <div class='col-6 transactionKeys'>Packgae: </div>
                                        <div class='col-6 transactionValues text-right'><?php echo $data['packageName']; ?></div>
                                    </div>
                                    <div class='row transactionData py-2'>
                                        <div class='col-6 transactionKeys'>Tokens: </div>
                                        <div class='col-6 transactionValues text-right'><?php echo $data['token']; ?></div>
                                    </div>
                                    <div class='row transactionData py-2'>
                                        <div class='col-6 transactionKeys'>Paypal Order Id: </div>
                                        <div class='col-6 transactionValues text-right'><?php echo $json->orderId; ?></div>
                                    </div>
                                    <div class='row transactionData py-2'>
                                        <div class='col-6 transactionKeys'>Currency : </div>
                                        <div class='col-6 transactionValues text-right'><?php echo $json->currency; ?></div>
                                    </div>
                                    <div class='row transactionData py-2'>
                                        <div class='col-6 transactionKeys'>Amount Paid : </div>
                                        <div class='col-6 transactionValues text-right'><?php echo $json->amount; ?></div>
                                    </div>
                                    <div class='row transactionData py-2'>
                                        <div class='col-6 transactionKeys'>User  : </div>
                                        <div class='col-6 transactionValues text-right'><?php echo $json->name; ?></div>
                                    </div>
                                    <div class='row transactionData py-2'>
                                        <div class='col-6 transactionKeys'>Email : </div>
                                        <div class='col-6 transactionValues text-right'><?php echo $json->email; ?></div>
                                    </div>
                                    <div class='row transactionData py-2'>
                                        <div class='col-6 transactionKeys'>Transasction Time : </div>
                                        <div class='col-6 transactionValues text-right'><?php echo date("d/M/Y h:i:s a",strtotime($json->time)); ?></div>
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