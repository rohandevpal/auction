<?php 
    include_once("../inc/config.php");
    $pageName="User Profile";

    if(!isset($_SESSION['adminUser'])){
        $_SESSION['toast']['msg']="Please, Log-in to continue.";
        header("location:login.php");
        exit();
    }
$userId=$_SESSION['adminUser']['id'];
// Profile
    if(isset($_POST['submit_profile'])){
        $name=mysqli_real_escape_string($conn,ak_secure_string($_POST['name']));
        $designation=mysqli_real_escape_string($conn,ak_secure_string($_POST['designation']));
        $phone=mysqli_real_escape_string($conn,ak_secure_string($_POST['phone']));
        $city=mysqli_real_escape_string($conn,ak_secure_string($_POST['city']));
        $state=mysqli_real_escape_string($conn,ak_secure_string($_POST['state']));
        $address=mysqli_real_escape_string($conn,ak_secure_string($_POST['address']));

        $action=mysqli_query($conn,"UPDATE `".$tblPrefix."users` SET `name`='$name',`phone`='$phone',`city`='$city',`state`='$state',`address`='$address',`designation`='$designation' WHERE `id`='$userId'");

        if($action == true){
            $_SESSION['toast']['type']="success";
            $_SESSION['toast']['msg']="Profile Successfully Updated.";
            $_SESSION['adminUser']['name']=$name;
            $_SESSION['adminUser']['phone']=$phone;
            $_SESSION['adminUser']['city']=$city;
            $_SESSION['adminUser']['state']=$state;
            $_SESSION['adminUser']['address']=$address;
            $_SESSION['adminUser']['designation']=$designation;

            $tmpName = $_FILES['profile_img']['tmp_name'];
            if(file_exists($tmpName)){
                $fileName = $_FILES['profile_img']['name'];
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if($ext=='jpg' || $ext=='jpeg' || $ext=='png'){
                    $fileName = 'user-'.$userId.'.'.$ext;
                    if(move_uploaded_file($tmpName, '../media/img/users/'.$fileName)==true){
                        mysqli_query($conn, "UPDATE `".$tblPrefix."users` SET `img`='$fileName' WHERE id=$userId");
                        $_SESSION['adminUser']['img']=$fileName;
                        $_SESSION['toast']['type']="success";
                        $_SESSION['toast']['msg']="Profile Image Successfully Updated.";
                    }else{
                         $_SESSION['toast']['type']="error";
                        $_SESSION['toast']['msg']="Something went wrong, Please try again.";
                    }
                }else{
                    $_SESSION['toast']['type']="warning";
                    $_SESSION['toast']['msg']="Upload only image format(jpg, jpeg, png).";
                }
            }
        }else{
             $_SESSION['toast']['type']="error";
             $_SESSION['toast']['msg']="Something went wrong.";
        }
    }

    // Socila Media
    if(isset($_POST['submit-social'])){
        $facebook=mysqli_real_escape_string($conn,ak_secure_string($_POST['facebook']));
        $instagram=mysqli_real_escape_string($conn,ak_secure_string($_POST['instagram']));
        $twitter=mysqli_real_escape_string($conn,ak_secure_string($_POST['twitter']));
        $linkedin=mysqli_real_escape_string($conn,ak_secure_string($_POST['linkedin']));

       $socialArr = array('facebook'=> $facebook, 'linkedin'=> $linkedin, 'twitter' => $twitter,'instagram' => $instagram);

        $actionQ = "";
        foreach($socialArr as $key => $value){
            $actionQ .= "UPDATE `".$tblPrefix."general` SET key_value = '$value' WHERE key_name = '$key'; ";
            $_SESSION['general'][$key] = $value;
        }

        if(mysqli_multi_query($conn, $actionQ)==true){
            $_SESSION['toast']['msg']= 'Data successfully updated.';
        }else{
            $_SESSION['toast']['msg'] = 'Something went wrong, Please try again.';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <?php include_once('inc/css.php');?>

</head>
<body class="sidebar-pinned ">
    <?php include_once('inc/sidebar.php');?>
<main class="admin-main">
    <?php include_once("inc/nav.php");?>
    <section class="admin-content ">
        <?php include_once("inc/breadcrum.php");?>
        <section class="pull-up">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-8 mx-auto mt-2">
                        <div class="card py-3 m-b-30">
                            <div class="card-body">
                                <ul class="nav nav-tabs tab-line" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#line-home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link show" id="profile-tab2" data-toggle="tab" href="#line-profile" role="tab" aria-controls="profile" aria-selected="false">Socila Media</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="line-home" role="tabpanel" aria-labelledby="home-tab">
                                        <form method="POST" enctype="multipart/form-data">
                                            <h3 class="text-center">Personal Data</h3>
                                            <p class="text-muted text-center"> Use this page to update your contact information...</p>
                                            <div class="text-center">
                                                <label class="avatar-input"> 
                                                    <span class="avatar avatar-xl"> 
                                                        <img src="../media/img/users/<?php echo $_SESSION['adminUser']['img'];?>" alt="<?php echo $_SESSION['adminUser']['name'];?>" class="avatar-img rounded-circle"> 
                                                        <span class="avatar-input-icon rounded-circle"> 
                                                            <i class="mdi mdi-upload mdi-24px"></i> 
                                                        </span> 
                                                    </span>
                                                    <input type="file" class="avatar-file-picker" name="profile_img">
                                                </label>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="inputEmail6">Name</label>
                                                    <input type="text" value="<?php echo $_SESSION['adminUser']['name'];?>" class="form-control" id="inputEmail6" placeholder="Name" name="name">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="inputEmail6">Designation</label>
                                                    <input type="text" value="<?php echo $_SESSION['adminUser']['designation'];?>" class="form-control" id="inputEmail6" placeholder="Designation" name="designation">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4">Email</label>
                                                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email" value="<?php echo $_SESSION['adminUser']['email'];?>" disabled>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="phone">phone</label>
                                                    <input type="text" class="form-control" id="phone" placeholder="City" value="<?php echo $_SESSION['adminUser']['phone'];?>" name="phone">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="city">City</label>
                                                    <input type="text" class="form-control" id="city" placeholder="City" value="<?php echo $_SESSION['adminUser']['city'];?>" name="city">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="state">State</label>
                                                    <input type="text" class="form-control" id="state" placeholder="City" value="<?php echo $_SESSION['adminUser']['state'];?>" name="state">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputAddress">Address</label>
                                                <input type="text" class="form-control" id="inputAddress" placeholder="Address" value="<?php echo $_SESSION['adminUser']['address'];?>" name="address">
                                            </div>
                                            <button type="submit" class="btn btn-success btn-cta" name="submit_profile">Save changes</button>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="line-profile" role="tabpanel" aria-labelledby="profile-tab">
                                         <form method="POST" enctype="multipart/form-data">
                                            <h3 class="text-center">Personal Data</h3>
                                            <p class="text-muted text-center"> Use this page to update your contact information...</p>
                                            <div class="text-center">
                                                <label class="avatar-input"> 
                                                    <span class="avatar avatar-xl"> 
                                                        <img src="media/img/users/<?php echo $_SESSION['adminUser']['img'];?>" alt="<?php echo $_SESSION['adminUser']['name'];?>" class="avatar-img rounded-circle"> 
                                                        <span class="avatar-input-icon rounded-circle"> 
                                                            <i class="mdi mdi-upload mdi-24px"></i> 
                                                        </span> 
                                                    </span>
                                                    <input type="file" class="avatar-file-picker" name="profile_img">
                                                </label>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="facebook">Facebook</label>
                                                    <input type="text" class="form-control" id="facebook" placeholder="Facebook Link" value="<?php echo $_SESSION['general']['facebook'];?>" name="facebook">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="instagram">Instagram</label>
                                                    <input type="text" class="form-control" id="instagram" placeholder="instagram Link" value="<?php echo $_SESSION['general']['instagram'];?>" name="instagram">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="twitter">Twitter</label>
                                                    <input type="text" class="form-control" id="twitter" placeholder="twitter Link" value="<?php echo $_SESSION['general']['twitter'];?>" name="twitter">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="linkedin">Linkedin</label>
                                                    <input type="text" class="form-control" id="linkedin" placeholder="linkedin Link" value="<?php echo $_SESSION['general']['linkedin'];?>" name="linkedin">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-cta" name="submit-social">Save changes</button>
                                        </form>
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
    <?php require_once("inc/modal.php");?>
    <?php include_once("inc/js.php");?>
    <?php include_once("inc/search-bar.php");?>
</body>
</html>