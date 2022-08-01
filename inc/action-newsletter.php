<?php 
    if(isset($_POST['submitNewsletter'])){
        $email = mysqli_real_escape_string($conn,ak_secure_string($_POST['newsletterEmail']));

        $checkNewsletter = mysqli_query($conn,"SELECT `email` FROM `".$tblPrefix."subscriptions` WHERE `email` = '$email' ");
        if(mysqli_num_rows($checkNewsletter) == 0){
            $subscription = mysqli_query($conn,"INSERT INTO `".$tblPrefix."subscriptions`(`email`, `date_time`, `status`) VALUES ('$email','$cTime',2)");
            if($subscription == TRUE){
                $_SESSION['toast']['type'] = "success";
                $_SESSION['toast']['msg'] = "Newsletter subscribed successfully";
                header("refresh:0");
                exit();
            }else{
                $_SESSION['toast']['type'] = "error";
                $_SESSION['toast']['msg'] = "Something went wrong, Please try again later";
                header("refresh:0");
                exit();
            }
        }else{
                $_SESSION['toast']['type'] = "warning";
                $_SESSION['toast']['msg'] = "You`ve already subscribed to the newsletter";
                header("refresh:0");
                exit();
        }
    }
?>