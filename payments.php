<?php
   require_once 'inc/config.php';
   $pageName="Payments";

   $dataPackagesType1 = mysqli_query($conn,"SELECT `id`, `type`, `name`, `description`, `price`, `sale_price` FROM `".$tblPrefix."packages` WHERE status = 2 AND type = 1");
   $dataPackagesType2 = mysqli_query($conn,"SELECT `id`, `type`, `name`, `description`, `price`, `sale_price` FROM `".$tblPrefix."packages` WHERE status = 2 AND type = 2");
   
?>
<!DOCTYPE html>
<html lang="en">

<head>

   <?php require_once 'inc/head.php';?>

   <link rel="stylesheet" href="./assets/style/logIn.css" />
   <link rel="stylesheet" href="./assets/style/howItWorks.css" />
   <link rel="stylesheet" href="./assets/style/buy_token.css" />
   <style>
       .summaryRow{
           border-bottom:1px solid #e5e5e5;
           font-size:16px;
           font-weight:600;
       }
   </style>
</head>

<body>
   <!-- Header -->
   <?php require_once 'inc/header.php';?>
   <!-- Header -->

   <!-- Main -->
   <main>
      <!-- Banner section -->
      <section class="Banner_Section_div">
         <h1 class="text-white banner_heading"><span>PAYMENTS</span></h1>
      </section>
        <?php if(isset($_GET['type']) == "token" && isset($_GET['package'])){ 
            $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['package']));
                $tokenData = mysqli_query($conn,"SELECT `id`, `type`, `name`, `sale_price` FROM `".$tblPrefix."packages` WHERE id='$id' ");
                $token  = mysqli_fetch_assoc($tokenData);
        ?>
            <section class="padding_one">
                <div class="container side_padding">
                    <div class="row justify-content-center align-content-center">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                            <h2 class="text-center fw-bold mb-4">SUMMARY</h2>
                            <div class="row summaryRow align-items-center py-3">
                                <div class="col-6 text-muted ">
                                    DDP(Delivered Duty Paid)
                                </div>
                                <div class="col-6 text-muted text-end">Purchase Pack Tokens <?php echo $token['name']?></div>
                            </div>
                            <div class="row summaryRow align-items-center py-3">
                                <div class="col-6 text-muted ">
                                    Sub-Total
                                </div>
                                <div class="col-6 text-muted text-end">CA$<?php echo $token['sale_price']?></div>
                            </div>
                            <div class="row summaryRow align-items-center py-3">
                                <div class="col-6 text-muted ">
                                    Total to Pay
                                </div>
                                <div class="col-6 text-muted text-end">CA$<?php echo $token['sale_price']?></div>
                            </div>
                            <div class="row my-5">
                                <div class="col-12">
                                    <div id="paypal-button-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <script src="https://www.paypal.com/sdk/js?client-id=AcTObTeIojUsjhJGuZaMSnfXfK1DzYs8ducHPujLK3RqK-p3dS__7A3-yR6-3h-S4OSPckBTsLVVBbpz&locale=en_US&commit=true&currency=USD&debug=false&disable-funding=credit,card"></script>
            <script>
                paypal.Buttons({
                    createOrder: function(data, actions) {
                        // This function sets up the details of the transaction, including the amount and line item details.
                        return actions.order.create({
                        purchase_units: [{
                            amount: {
                            value: '<?php echo $token['sale_price'];?>'
                            }
                        }]
                        });
                    },
                    onApprove: function(data, actions) {
                        // This function captures the funds from the transaction.
                        return actions.order.capture().then(function(details) {
                            const userDetails = {
                                userId : <?php echo $_SESSION['user']['id'];?>,
                                package : <?php echo $token['id'];?>,
                                orderId : details.id,
                                currency : details.purchase_units[0].amount.currency_code,
                                amount : details.purchase_units[0].amount.value,
                                name : details.payer.name.given_name + " " + details.payer.name.surname,
                                email : details.payer.email_address,
                                status : details.status,
                                time : details.create_time
                            }
                            const transactionData = JSON.stringify(userDetails);
                            $.ajax({
                                url: 'inc/payment-success.php',
                                type: 'post',
                                data: {user: transactionData},
                                success: function(response){
                                    //do whatever.
                                    console.log(typeof response);
                                    if(response == "error"){
                                        alertify.error('Something went wrong, Please try again later',3)
                                    }else if(response == "failed"){
                                        alertify.error('Something went wrong, Please try again later',3)
                                    }else{
                                        window.location.href = "./PaymentSuccessful.php?id="+response+""
                                    }
                                }
                            });
                        })
                    },
                    onCancel: function (data) {
                        // Show a cancel page, or return to cart
                        window.location.href = "./paymentFail.php"
                    },
                    onError: function (err) {
                        // For example, redirect to a specific error page
                        window.location.href = "./paymentFail.php"
                    }
                }).render('#paypal-button-container');
            </script>
        <?php }?>
   </main>
   <!-- Main -->

   <!-- Footer -->
   <!-- Footer -->

   <?php require_once 'inc/footer.php';?>

   <?php require_once 'inc/js.php';?>
</body>

</html>