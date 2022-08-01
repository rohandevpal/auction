<?php   
  require_once 'inc/config.php';
  $pageName = "Payment Success";

  if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn,ak_secure_string($_GET['id']));
    $payData = mysqli_query($conn,"SELECT `id`, `user`, `package`, `data`, `status`, `date_time` FROM `".$tblPrefix."wallet_transactions` WHERE id='$id'");
    $pay = mysqli_fetch_assoc($payData);
    $json = json_decode($pay['data']);
  }
  if(isset($_SESSION['userWallet'])){
    $_SESSION['userWallet'] = getWallet($_SESSION['user']['id']);
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once 'inc/head.php';?>

  <link rel="stylesheet" href="./assets/style/PaymentSuccessful.css">
<style>
  .payment_content h4,.payment_content h5{
    font-size:14px;
  }
</style>
</head>

<body>

  <!-- Header -->
  <?php require_once 'inc/header.php';?>
  <!-- Header -->

  <!-- main -->
  <main>
    <section class="payment_successful">
      <div class="container padding_Two">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-12 col-md-6 d-flex align-items-center justify-content-center">
            <div class="paymentCard text-center px-4">
              <img src="https://i.pinimg.com/originals/35/f3/23/35f323bc5b41dc4269001529e3ff1278.gif" class="img-fluid"
                alt="">

              <h4 class="py-3" >Payment Successful</h4>

              <div class="payment_content py-5">
                <div class="row mb-3">
                  <div class="col-12 d-flex justify-content-sm-start justify-content-center col-sm-6 col-md-6">
                    <h4>Payment Type</h4>
                  </div>
                  <div
                    class="col-12 d-flex justify-content-center  justify-content-sm-end mt-2 mt-sm-0 col-sm-6 col-md-6">
                    <h5>PayPal</h5>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-12 d-flex justify-content-sm-start justify-content-center col-sm-6 col-md-6">
                    <h4>Email</h4>
                  </div>
                  <div
                    class="col-12 d-flex justify-content-center  justify-content-sm-end mt-2 mt-sm-0 col-sm-6 col-md-6">
                    <h5><?php echo $json->email;?></h5>
                  </div>
                </div>

                <div class="row mt-4 mb-4 amountPaid">
                  <div class="col-12 d-flex justify-content-sm-start justify-content-center col-sm-6 col-md-6">
                    <h4>Amount Paid</h4>
                  </div>
                  <div
                    class="col-12 d-flex justify-content-center  justify-content-sm-end mt-2 mt-sm-0 col-sm-12 col-md-6">
                    <h5>$<?php echo $json->amount;?></h5>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-12 d-flex justify-content-sm-start justify-content-center col-sm-6 col-md-6">
                    <h4>Transaction id</h4>
                  </div>
                  <div
                    class="col-12 d-flex justify-content-center justify-content-sm-end mt-2 mt-sm-0 col-sm-6 col-md-6">
                    <h5><?php echo $json->orderId;?></h5>
                  </div>
                </div>

                <div class="row mt-0 mt-sm-5">
                  <div class="col-12 d-flex justify-content-center  mt-2 mt-sm-0  col-sm-12">
                    <a href="./index.php" class="print btn View_More_Button text-white">Continue Shopping</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- main -->


  <!-- Footer -->
  <?php require_once 'inc/footer.php';?>
  <!-- Footer -->

  <?php require_once 'inc/js.php';?>

</body>

</html>