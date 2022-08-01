<?php
//alertify...
function toast($side){
	if(isset($_SESSION['toast'])){
		if(!isset($_SESSION['toast']['duration'])){
			$_SESSION['toast']['duration']=3; //In seconds...
		}

		if(isset($_SESSION['toast']['type'])){
			$type = $_SESSION['toast']['type'];
		}else{
			$type = "";
		}

		if($_SESSION['toast']['msg'] != ""){
			if($side==1){
				if($type=='alert'){
					$toastMsg ="<script>ps_alertify('".$_SESSION['toast']['msg']."');</script>";
				}elseif($type=='success'){
					$toastMsg ="<script>alertify.success('".$_SESSION['toast']['msg']."',".$_SESSION['toast']['duration'].");</script>";
				}elseif($type=='error'){
					$toastMsg ="<script>alertify.error('".$_SESSION['toast']['msg']."',".$_SESSION['toast']['duration'].");</script>";
				}elseif($type=='warning'){
					$toastMsg ="<script>alertify.warning('".$_SESSION['toast']['msg']."',".$_SESSION['toast']['duration'].");</script>";
				}else{
					$toastMsg ="<script>alertify.message('".$_SESSION['toast']['msg']."',".$_SESSION['toast']['duration'].");</script>";
				}
			}else{
				$toastMsg = "<script> Materialize.toast('".$_SESSION['toast']['msg']."',3000);</script>";
			}

			$_SESSION['toast']['msg'] = "";
			unset($_SESSION['toast']['type']);
			unset($_SESSION['toast']['duration']);
			return $toastMsg;
		}
	}
}

function auctionType($id){
	$auctionType = array(
		3=>'FEATURED AUCTIONS',
	);

	if($id==0){
		return $auctionType;
	}else{
		return $auctionType[$id];
	}
}

function ak_secure_string($param){
	//remove vulnerable params...
	$param = str_replace('"', "\"", str_replace("'", '\'', str_replace('</script>', '', str_replace('<script>', '', $param))));

	return $param;
}

function getGeneral($param){
	if($param != NULL)
		return $_SESSION['general'][$param];
	else
		return "Null";
}

function getSocialLinks($param){
	if($param != NULL)
		return $_SESSION['general'][$param];
	else
		return "#";
}

function getUserData($param){
	if($param != NULL)
		return $_SESSION['user'][$param];
	else
		return "Null";
}

function star_rating($rating){
	if($rating==0){
		$stars = '<i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>';
	}elseif($rating<1){
		$stars = '<i class="fas fa-star-half-o" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>';
	}elseif ($rating==1) {
		$stars = '<i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>';
	}elseif($rating>1 && $rating <2){
		$stars = '<i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star-half-o" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>';
	}elseif($rating==2){
		$stars = '<i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>';
	}elseif($rating>2 && $rating<3){
		$stars = '<i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star-half-o" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>';

	}elseif($rating==3){
		$stars = '<i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>';
	}elseif($rating>3 && $rating<4){
		$stars = '<i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star-half-o" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>';
	}elseif($rating==4){
		$stars = '<i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true" style="color:#ccc;"></i>';
	}elseif($rating>4 && $rating <5){
		$stars = '<i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star-half-o" aria-hidden="true"></i>';
	}else{
		$stars = '<i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>
	            <i class="fas fa-star" aria-hidden="true"></i>';
	}
	return $stars;
}

function getUsersJoined($auction_id){
	global $conn,$tblPrefix;

	$queryA = mysqli_fetch_assoc(mysqli_query($conn,"SELECT count(user_id) as usersJoined FROM `".$tblPrefix."auction_participant` WHERE auction_id = $auction_id"))['usersJoined'];
	 
	return $queryA;
}

function auctionCard ($type,$limit,$category=null){
	global $conn,$tblPrefix,$cTime;
	$condition = "";
	if($type == 2){
		$condition .= " AND type = 2";
	}else if($type == 3){
		$condition .= " AND type = 3";
	}else if($type == 1){
		$condition .= " AND type = 1";
	}else if($type == 0){
		$condition .= "";
	}

	if($category != null){
		$condition .= " AND categrory = ".$category;
	}

	if($limit != 0 ) {
		$condition .= " LIMIT " . $limit;
	}

	$queryCards = mysqli_query($conn,"SELECT `id`, `name`, `image`, `store_price`, `starting_price`, `starting_from`, `capacity` FROM `".$tblPrefix."auctions` WHERE status = 2 $condition ");

	
	while($cards=mysqli_fetch_assoc($queryCards)){
		
 	$usersJoined = getUsersJoined($cards['id']);
	 	$totalUsers = $cards['capacity'];
	 	$percentage = ($usersJoined  / $totalUsers ) * 100;

		// echo $percentage;
				 if($percentage > 99){
			  $percentage= 100;
			  $button = "";
		 }
		 else{
			 $percentage ;
			 $button = '<div class="mt-4 mb-4">
			  <a href="auction.php?auction='.urldecode($cards["name"]).'&id='.$cards["id"].'" class="Subcribe_button">Subscribe for CA $'.$cards['starting_price'].'</a>
			</div>';
		 }

		echo '<div class="col-12 col-sm-9 col-md-6 col-xl-5 col-xxl-3 my-3">
		<!-- Popular cards -->
		<div class="popular_auction_card_div text-center py-3">

		  <!-- Auction Products badge-->
		  <div class="Auction_products_badge">
			<p class="text-white">Trend</p>
		  </div>
		  <!-- Auction Products badge-->

		  <!-- Products Images -->
		  <img src="./assets/img/auction/'.$cards['image'].'" alt="'.$cards['name'].'" class="img-fluid img-responsive m-auto">
		  <!-- Products Images -->
		  <!-- Products Content -->
		  <div class="Auction_products_content mt-3">
			<h2>'.$cards['name'].'</h2>
			<p class="my-3 light_para">Auction house filled at:</p>

			<!-- Product Input Progress bar -->
			<div class="progress auction_progress_bar mt-2 mb-4">
			<div class="progress-bar" role="progressbar" style="width: '.$percentage.'%;" aria-valuenow="'.$percentage.'" aria-valuemin="0"	aria-valuemax="100">'.$percentage.'%</div>
			</div>
			<!-- Product Input Progress bar -->

			<!-- Auction Price div -->
			<div class="auction_price_div py-2 d-flex justify-content-around align-items-center">
			  <!-- Store price -->
			  <div class="auction_price_inner_div">
				<p class="light_para">Store price</p>
				<h3>CA$ '.$cards['store_price'].'</h3>
			  </div>
			  <!-- Start Price -->
			  <div class="auction_price_inner_div">
				<p class="light_para">Starting price</p>
				<h3>CA$ '.$cards['starting_price'].'</h3>
			  </div>
			</div>
			<!-- Auction Price div -->
            <div class="imageBox">
		 		<img src="/assets/img/'. $_SESSION['general']['tokenImage'].'" class="img-responsive img-fluid" style="height: 100px;margin: 10px auto;" />
			</div>
			<!-- Subcribe button -->
			'.$button.'
			<!-- Subcribe button -->

			<!-- Shecdule time div -->
			<div class="Shedule_div py-2">
			  <h3 class="text-white mb-3"> Scheduled on '.date("d/m/Y h:i:s a",strtotime($cards['starting_from'])).' </h3>
			</div>
			<!-- Shecdule time div -->
		  </div>
		  <!-- Products Content -->
		</div>
		<!-- Popular cards -->
	  </div>';
	}
	
}


function validateWallet($token){
	global $conn,$tblPrefix;

	$user = $_SESSION['user']['id'];

	$checkTokens = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `balance` FROM `".$tblPrefix."wallet` WHERE user_id = '$user'"))['balance'];
	
	if($checkTokens > $token){
		return TRUE;
	}else{
		return FALSE;
	}
}

function updateWallet($token){
	global $conn,$tblPrefix,$cTime;

	$user = $_SESSION['user']['id'];

	if(mysqli_query($conn,"UPDATE `".$tblPrefix."wallet` SET `balance`= `balance`- $token ,`last_transiction`='$cTime' WHERE user_id = '$user'") == TRUE){
		return TRUE;
	}else{
		return FALSE;
	}
}

function makeAuctionTransaction($token,$auction_id){
	global $conn,$tblPrefix,$cTime;

	$user = $_SESSION['user']['id'];
	$query = mysqli_query($conn,"INSERT INTO `".$tblPrefix."auction_transactions`(`user_id`, `auction_id`, `token`, `date_time`, `status`) VALUES ('$user','$auction_id','$token','$cTime','2')");
	if($query==TRUE){
		if(updateWallet($token)){
			return TRUE;
		}else { 
			return FALSE;
		}
	}else{
		return FALSE;
	}
}
function isUserAlreadyInAuction($auction_id){
	global $conn,$tblPrefix;

	$user = $_SESSION['user']['id'];
	
	$query = mysqli_query($conn,"SELECT `id` FROM `".$tblPrefix."auction_participant` WHERE user_id = '$user' AND auction_id = $auction_id");
	
	if(mysqli_num_rows($query) == 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

function getWallet($userId){
	global $conn,$tblPrefix;

	$query = mysqli_fetch_assoc(mysqli_query($conn,"SELECT  `balance` FROM `bnmi_wallet` WHERE user_id = '$userId' "))['balance'];
	
	return $query;
}
	
function getTokens($packageId){
	global $conn,$tblPrefix;
	$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `sale_price` FROM `".$tblPrefix."packages` WHERE id = ".$packageId))['sale_price'];
	return $data;
}

function auctionDeactivate($id){
	global $conn,$tblPrefix;
	$deactivateAuction =  mysqli_query($conn,"UPDATE  ".$tblPrefix."auctions  SET  status= '3' WHERE id = $id");
	return $deactivateAuction;
}

function Endauction($id, $name ,$img){
    	global $conn,$tblPrefix;
	try {
		$amountData = mysqli_query($conn,"SELECT * FROM ".$tblPrefix."winnig  WHERE auction_id = $id");
		$res = mysqli_fetch_assoc($amountData);
		if($res['amount']== null){
			$data ="";
		}
		else{
			$data = $res['amount'];
		}
	}
	catch (exception $e) {
	return $data = $e;
	}
	echo '   <div
	class="col-12 col-sm-9 col-md-6 col-xl-5 col-xxl-4 mb-5 d-flex justify-content-center align-items-center">
	<!-- Products Cards -->
	
	<div class="Auctions_products_cards text-center p-3">
	   <a href="winningPage.php?auction='.$id.' ">
	   <!-- Products Images -->
	   <img src="./assets/img/auction/'.$img.'" alt="" class="img-fluid my-4" />
	   <!-- Products Images -->

	   <!-- content -->
	   <div class="Auction_Products_Cards_content">
		  <h3 class ="text-dark">'.$name.'</h3>
		  <h5  class ="text-dark">Headphones</h5>

		  <!-- Instead price -->
		  <div class="Instead_Price_div d-flex align-items-center justify-content-center my-3 text-dark">
		   <h3 class="me-2">Final Price CA$ '.$data.'</h3>
			
			 <h4>Closed</h4>
		  </div>
		  <!-- Instead price -->

		  <!-- Add to card -->
		  <!-- <button class="Add_to_cart mb-3">Add to Cart</button> -->
		  <!-- Add to card -->
	   </div>
	   <!-- content -->
	   </a>
	</div>
	<!-- Products Cards -->
 </div>';
}