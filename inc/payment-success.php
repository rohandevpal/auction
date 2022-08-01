<?php
    require_once 'config.php';

    if(isset($_POST['user'])){
        $data = $_POST['user'];

        $decoded = json_decode($data, true);

        $user = $decoded['userId'];
        $status = $decoded['status'];
        $package = $decoded['package'];
        $time = $decoded['time'];
        $user = $_SESSION['user']['id'];
        $query = mysqli_query($conn,"INSERT INTO `bnmi_wallet_transactions`(`user`, `package`, `data`, `status`, `date_time`) VALUES ('$user','$package', '$data','$status','$cTime')");
        $id = mysqli_insert_id($conn);

        if($query == TRUE) {
            $tokens = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `token` FROM `".$tblPrefix."packages` WHERE id='$package' "))['token'];
            $wallet = mysqli_query($conn,"UPDATE `".$tblPrefix."wallet` SET `balance`= `balance`+ '$tokens',`last_transiction`='$cTime' WHERE `user_id` = '$user' ");
            if($wallet == TRUE){
                echo $id;
            }else{
                echo 'error';
            }
        }else{
            echo 'failed';
        }
    }