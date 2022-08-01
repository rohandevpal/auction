<?php
include_once("../../inc/config.php");
// Check Slug
if(isset($_POST['slug'])){
    $slug = mysqli_real_escape_string($conn,ak_secure_string($_POST['slug']));
    $checkSlug = mysqli_query($conn,"SELECT `url` FROM `".$tblPrefix."blog` WHERE `url` = '$slug' ");
    if(mysqli_num_rows($checkSlug)>0){
        echo 0;
    }else{
        echo 1;
    }
}