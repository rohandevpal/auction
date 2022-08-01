<?php
 require_once 'inc/config.php';
 $productname = $_POST['productid'];
$dataquery = mysqli_query($conn ,"SELECT * FROM ".$tblPrefix."bid WHERE auction_id= $productname  ORDER BY id DESC" );
if(mysqli_num_rows($dataquery)>0){
   while($biddata = mysqli_fetch_assoc($dataquery)){
     $email =$biddata['email'];
     $img = mysqli_query($conn ,"SELECT img FROM ".$tblPrefix."users WHERE email = '$email'" );
     $imgdata = mysqli_fetch_assoc($img);
      echo $output = '<div class="col-12 my-3">
    <div class="userBitting_current">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
          <div class="row">
            <div class="col-4 full_width col-md-4">
              <h1>'.$biddata["auction_name"].'</h1>
              <p class="light_para">'.$biddata["userdata"].'</p>
            </div>
            <div class="col-4 full_width col-md-4 d-flex align-items-center">
              <p class="light_para">0.0025 ETH</p>
            </div>
            <div class="col-4  full_width col-md-4 d-flex align-items-center">
              <p class="light_para">0.0025 ETH</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 pt-3 pt-md-0">
          <div class="row">
            <div class="col-4 full_width col-md-5 d-flex align-items-center">
              <div class="user_icons_profile">
                <img
                  src="assets/img/user/'.$imgdata['img'].'"
                  alt="">
              </div>
              <p class="light_para ms-3">0.0023 ETH</p>
            </div>
            <div class="col-4 full_width col-md-3 d-flex align-items-center">
              <p class="light_para">'.$biddata['time'].'</p>
            </div>
            <div
              class="col-4 full_width col-md-3 d-flex align-items-center justify-content-start justify-content-md-end">
              <p class="light_para">CA$'.$biddata["amount"].'</p>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>';
   }
}

?>
