<?php 
    include_once("../inc/config.php");
    $pageName="Auction Details";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }

    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));

        $sql = mysqli_query($conn,"SELECT `winner_name`, `Winner_email`, `amount`, `auction_name` FROM `".$tblPrefix."winnig` WHERE `auction_id` = '$id' ");
        $winnerData = mysqli_fetch_assoc($sql);
        // $winadd = mysqli_query($conn,"");
        $winEmail = $winnerData['Winner_email'];
        $winadd = mysqli_query($conn,"SELECT * FROM `bnmi_userdata` Where user_email = '$winEmail'");
        $address = $winadd= mysqli_fetch_assoc($winadd);
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
                                <div class="card-body row">
                                    <h3 class="w-100 text-center">Winner Details</h3>
                                    <div class="col-6 py-2">Name: <?php echo $winnerData['winner_name'];?></div>
                                    <div class="col-6 py-2">Email: <?php echo $winnerData['Winner_email'];?></div>
                                    <div class="col-6 py-2">Auction: <?php echo $winnerData['auction_name'];?></div>
                                    <div class="col-6 py-2">Bid Amount: <?php echo $winnerData['amount'];?> Tokens</div>
                                    <div class="col-6 py-2"> <?php echo 'Address : '.$address['Add1'].'  '.$address['Add 2'].' <br> City:  '.$address['city'].'<br> Zip :  '.$address['zip'].' <br>  country:  '.$address['country'].' '?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mx-auto mt-2">
                            <div class="card py-3 px-3 m-b-30 p-2">
                                <div class="card-body row">
                                    <h3>User's Participated</h3>
                                    <div class="table-responsive p-t-10">
                                        <table id="myTable" class="table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <td>Id</td>
                                                <td>Name</td>
                                                <td>Email</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $j= 0;
                                                $data = mysqli_query($conn,"SELECT us.name,us.email FROM `".$tblPrefix."auction_participant` ap LEFT JOIN `".$tblPrefix."users` us ON ap.user_id = us.id WHERE ap.auction_id = '$id'");
                                                    while($participtitant = mysqli_fetch_assoc($data)){
                                                        $j++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $j;?></td>
                                                    <td><?php echo $participtitant['name'];?></td>
                                                    <td><?php echo $participtitant['email'];?></td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td>Id</td>
                                                <td>Name</td>
                                                <td>Email</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mx-auto mt-2">
                            <div class="card py-3 px-3 m-b-30">
                                <div class="card-body row ">
                                    <h3>User's Atended</h3>
                                    <div class="table-responsive p-t-10">
                                        <table id="example" class="table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <td>Id</td>
                                                <td>Name</td>
                                                <td>Email</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $k= 0;
                                                $data = mysqli_query($conn,"SELECT us.name,us.email FROM `".$tblPrefix."auction_participant` ap LEFT JOIN `".$tblPrefix."users` us ON ap.user_id = us.id WHERE ap.auction_id = '$id'");
                                                    while($participtitant = mysqli_fetch_assoc($data)){
                                                        $k++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $k;?></td>
                                                    <td><?php echo $participtitant['name'];?></td>
                                                    <td><?php echo $participtitant['email'];?></td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td>Id</td>
                                                <td>Name</td>
                                                <td>Email</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mx-auto mt-2">
                            <div class="card py-3 px-3 m-b-30">
                                <div class="card-body row ">
                                    <h3>Bids</h3>
                                    <div class="table-responsive p-t-10">
                                        <table id="myTable1" class="table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <td>Id</td>
                                                <td>Bid Amount<small>(in Tokens)</small></td>
                                                <td>Bid User</td>
                                                <td>Bid Time</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $k= 0;
                                                $data = mysqli_query($conn,"SELECT bb.email,bb.amount,bb.time,us.name,us.email FROM `".$tblPrefix."bid` bb LEFT JOIN `".$tblPrefix."users` us ON bb.email = us.email WHERE bb.auction_id = '$id' ORDER BY bb.id DESC");
                                                    while($participtitant = mysqli_fetch_assoc($data)){
                                                        $k++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $k;?></td>
                                                    <td><?php echo $participtitant['amount'];?></td>
                                                    <td><?php echo $participtitant['name'];?></td>
                                                    <td><?php echo date("d/M/Y H:i:s a",strtotime($participtitant['time']));?></td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td>Id</td>
                                                <td>Bid Amount<small>(in Tokens)</small></td>
                                                <td>Bid User</td>
                                                <td>Bid Time</td>
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
        $(document).ready( function () {
            $('#myTable').DataTable();
            $('#myTable1').DataTable();
        } );
    </script>
</html>