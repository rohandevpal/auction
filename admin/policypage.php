<?php 
    include_once("../inc/config.php");
    $pageName="Policy Page";
    
    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }
    // Privacy Policy
    if(isset($_POST['submit-privacy'])){
    	$privacy=htmlspecialchars($_POST['privacy']);
    	$query=mysqli_query($conn,"UPDATE `".$tblPrefix."general` SET `key_value`='$privacy' WHERE id=501");
    	if($query==true){
    		$_SESSION['toast']['type']="success";
    		$_SESSION['toast']['msg']="Succesfully Submited";
    		header("location:policypage.php");
    		exit();
    	}
    }
    // Terms & Condition
    if(isset($_POST['submit-terms'])){
    	$terms=htmlspecialchars($_POST['terms']);
    	$query=mysqli_query($conn,"UPDATE `".$tblPrefix."general` SET `key_value`='$terms' WHERE id=502");
    	if($query==true){
    		$_SESSION['toast']['type']="success";
    		$_SESSION['toast']['msg']="Succesfully Submited";
    		header("location:policypage.php");
    		exit();
    	}
    }
    // Legal
    if(isset($_POST['submit-legal'])){
    	$legal=htmlspecialchars($_POST['legal']);
    	$query=mysqli_query($conn,"UPDATE `".$tblPrefix."general` SET `key_value`='$legal' WHERE id=504");
    	if($query==true){
    		$_SESSION['toast']['type']="success";
    		$_SESSION['toast']['msg']="Succesfully Submited";
    		header("location:policypage.php");
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
    <link rel='stylesheet' href="assets/vendor/trumbowyg/ui/trumbowyg.min.css"/>
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
                                <ul class="nav nav-tabs tab-line" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#line-home" role="tab" aria-controls="home" aria-selected="true">Privacy Policy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link show" id="profile-tab2" data-toggle="tab" href="#line-profile" role="tab" aria-controls="profile" aria-selected="false">Terms & Condition</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link show" id="profile-tab3" data-toggle="tab" href="#legal-tab" role="tab" aria-controls="profile" aria-selected="false">Legal</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="line-home" role="tabpanel" aria-labelledby="home-tab">
                                    	<div class="col-lg-12 mt-4">
	                                        <form method="POST" enctype="multipart/form-data">
	                                            <h3 class="text-center">Privacy Policy</h3>
	                                            <textarea class="form-control" id="editor" name="privacy">
	                                            	<?php echo $_SESSION['general']['privacy'];?>
	                                            </textarea>
	                                            <button type="submit" class="btn btn-success m-auto" name="submit-privacy">Save</button>
				                            </form>
                                    	</div>
                                    </div>
                                    <div class="tab-pane fade" id="line-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    	<div class="col-lg-12 mt-4">
	                                         <form method="POST" enctype="multipart/form-data">
	                                            <h3 class="text-center">Terms & Condition</h3>
	                                            <textarea class="form-control" id="editor2" name="terms">
	                                            	<?php echo $_SESSION['general']['terms'];?>
	                                            </textarea>
	                                            <button type="submit" class="btn btn-success m-auto" name="submit-terms">Save</button>
	                                        </form>
                                    	</div>
                                    </div>
                                    <div class="tab-pane fade" id="legal-tab" role="tabpanel" aria-labelledby="legal-tab">
                                    	<div class="col-lg-12 mt-4">
	                                        <form method="POST" enctype="multipart/form-data">
	                                            <h3 class="text-center">Legal</h3>
	                                            <textarea class="form-control" id="editor3" name="legal">
	                                            	<?php echo $_SESSION['general']['legal'];?>
	                                            </textarea>
	                                            <button type="submit" class="btn btn-success m-auto" name="submit-legal">Save</button>
	                                        </form>
                                    	</div>
                                    </div>
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
    <script type="text/javascript" src="assets/vendor/trumbowyg/trumbowyg.min.js"></script>
</html>