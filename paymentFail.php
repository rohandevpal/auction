<?php   
  require_once 'inc/config.php';
  $pageName = "Payment Failed";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once 'inc/head.php';?>

  <link rel="stylesheet" href="./assets/style/PaymentSuccessful.css">
  <link rel="stylesheet" href="./assets/style/paymentFail.css">

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
            <div class="paymentCard failedCard text-center px-4">
              <img src="https://cdn.dribbble.com/users/251873/screenshots/9388228/error-img.gif" class="img-fluid"
                alt="">

              <h3>Sorry, payment Failed!</h3>

              <div class="failed_content py-4">
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti, ut numquam? Explicabo
                  ducimus
                  dolores iure placeat ad fugit rem nihil quo iste ullam aliquam fugiat assumenda accusantium commodi
                  optio quidem reiciendis exercitationem dolor dolorem tempora at, sint ipsam, accusamus ut? Quod
                  reprehenderit, quisquam tenetur voluptatibus error voluptatem? Fugit, perspiciatis unde!</p>

                  <a href="./index.php" class="print btn View_More_Button text-white">Continue Shopping</a>

                <p class="my-3">Having trouble? <a href="./cotact.html" class="text-dark fw-bold">Submit a ticket</a> and we will get back to you.
                </p>
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