<?php
   require_once 'inc/config.php';
   $pageName="Blog";

   if(isset($_GET['slug']) && isset($_GET['blog'])){
      $slug = mysqli_real_escape_string($conn,ak_secure_string($_GET['slug']));
      $blog = mysqli_real_escape_string($conn,ak_secure_string($_GET['blog']));
      $query = mysqli_query($conn, "SELECT `id`, `name`, `url`, `cat`, `img`, `short_desc`, `desc`, `post_date`, `meta_title`, `meta_keyword`, `meta_desc`, `status` FROM `bnmi_blog` WHERE `id` = '$blog' AND `url` = '$slug' AND `status` = 2");
      
      if(mysqli_num_rows($query) != 1 ){
         $_SESSION['toast']['type'] = "warning";
         $_SESSION['toast']['msg'] = "Blog, Not found.";
         header('location:index.php');
         exit();
      }else{
         $data = mysqli_fetch_assoc($query);
      }

   }
   if(isset($_POST['post-comment'])){
      $user = mysqli_real_escape_string($conn, $_POST['user']);
      $comment = mysqli_real_escape_string($conn, $_POST['comment']);
      $parent = mysqli_real_escape_string($conn, $_POST['parent-id']);
  
      $actionQ = "INSERT INTO `".$tblPrefix."blog_comments`(`blog_id`, `parent_id`, `user`, `comment`, `date_time`, `status`) VALUES ($blog, $parent, '$user', '$comment', '$cTime', 2)";
  
      if(mysqli_query($conn, $actionQ)==true){
         $_SESSION['toast']['type'] = "success";
         $_SESSION['toast']['msg']="Comment successfully posted.";
      }else{
         $_SESSION['toast']['type'] = "warning";
         $_SESSION['toast']['msg']="Something went wrong, Please try again.";
      }
  
  }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php require_once 'inc/head.php';?>
      <link rel="stylesheet" href="./assets/style/blog.css" />
   </head>

   <body>
      <!-- Header -->
      <?php require_once 'inc/header.php';?>
      <!-- Header -->

      <!-- main -->
      <main>
         <!-- blog head -->
         <section class="blog_banner_section padding_one main_bg">
            <div class="container-fluid side_padding">
               <div class="row">
                  <div class="col-12 col-md-6 col-lg-6">
                     <h1><?php echo $data['name']; ?></h1>
                  </div>
                  <div class="col-12 col-md-6 col-lg-6 d-flex user_icons_blog align-items-center justify-content-end">
                     <img src="./assests/icons&images/useGrop.svg" alt="" />
                     <div>
                        <p>bretskymd@gmail.com</p>
                        <p><?php echo date("M d, Y",strtotime($data['post_date'])); ?></p>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- blog head -->

         <section class="blogs main_bg py-4">
            <div class="container">
               <div class="row">
                  <div class="col-12 text-center">
                     <img src="./assets/img/blog/<?php echo $data['img']; ?>" alt="<?php echo $data['name']; ?>" class="img-fluid" />
                  </div>
                  <div class="col-12 side_padding">
                     <p class="ms-0 ms-md-3 mt-5 light_para">
                        <?php echo $data['short_desc']; ?>
                     </p>
                  </div>
               </div>
            </div>
         </section>

         <section class="blogs main_bg py-4">
            <div class="container">
               <div class="row">
                  <div class="col-12 side_padding">
                     <p class="ms-0 ms-md-3 light_para">
                        <?php echo htmlspecialchars_decode($data['desc']); ?>
                     </p>
                  </div>
               </div>
            </div>
         </section>

         <!-- Comments -->
         <section class="comments_section main_bg">
            <div class="container">
               <div class="row">
                  <div class="col-6 mb-3">
                     <h1>Comments</h1>
                  </div>
                  <div class="col-6">
                     <button class="btn View_More_Button" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Comment</button>
                  </div>

                  <?php 
                     $commentQ = mysqli_query($conn, "SELECT blc.id, blc.blog_id, blc.user, blc.comment, blc.date_time, us.name,us.img FROM `".$tblPrefix."blog_comments` blc LEFT JOIN `".$tblPrefix."users` us ON blc.user = us.id WHERE blc.status=2 AND blc.parent_id=0 AND blc.blog_id='$blog' ");
                        while ($commentData = mysqli_fetch_assoc($commentQ)) {
                  ?>
                  <div class="row my-3">
                     <div class="col-12 col-md-2">
                        <img src="./assets/img/user/<?php echo $commentData['img'];?>" alt="<?php echo $commentData['name'];?>" />
                     </div>
                     <div class="col-12 col-md-10 pt-3 pt-md-0 commentsUsers">
                        <h3><?php echo $commentData['name'];?> <span class="comment_date light_para ms-2"><?php echo date("M d, Y",strtotime($commentData['date_time'])); ?></span></h3>
                        <p class="light_para">
                           <?php echo $commentData['comment'];?>
                        </p>

                        <button class="replay_Button reply"  data-bs-toggle="modal" data-bs-target="#exampleModal" data-parent="<?php echo $commentData['id'];?>">Reply</button>

                        <?php
                           $parentId = $commentData['id'];
                           $commentQ1 = mysqli_query($conn, "SELECT blc.id, blc.blog_id, blc.user, blc.comment, blc.date_time, us.name,us.img FROM `".$tblPrefix."blog_comments` blc LEFT JOIN `".$tblPrefix."users` us ON blc.user = us.id WHERE blc.status=2 AND blc.parent_id='$parentId' AND blc.blog_id='$blog'");
                           while ($commentData1 = mysqli_fetch_assoc($commentQ1)) {
                        ?>
                        <?php }?>
                        <div class="row commentReply my-3">
                           <div class="col-12 col-md-2">
                              <img src="./assets/img/user/<?php echo $commentData['img'];?>" alt="<?php echo $commentData['name'];?>" />
                           </div>
                           <div class="col-12 col-md-10 pt-3 pt-md-0 commentsUsers">
                              <h3><?php echo $commentData['name'];?> <span class="comment_date light_para ms-2"><?php echo date("M d, Y",strtotime($commentData['date_time'])); ?></span></h3>
                              <p class="light_para">
                                 <?php echo $commentData['comment'];?>
                              </p>
                        </div>
                     </div>
                  </div>
                  <?php } ?>
               </div>
            </div>
         </section>
         <!-- Comments -->

      </main>
      <!-- main -->

      <?php require_once 'inc/footer.php';?>

      <!-- Footer -->

      <?php require_once 'inc/js.php';?>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">LEAVE A REPLY</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <!-- Comment box -->
                  <section class="comments_box ">
                     <div class="container">
                        <div class="row gx-0">
                           <div class="col-12">
                              <p class="light_para">Your email address will not be published. Required fields are marked *</p>
                           </div>
                           
                           <form method="POST">
                              <input type="hidden" name="parent-id" value="0" >
                              <input type="hidden" name="user" value="<?php if(isset($_SESSION['user'])){echo $_SESSION['user']['id']; }?>" >
                              <div class="row gx-0 py-3 message_aria">
                                 <div class="col-12 col-md-6">
                                    <input type="text" placeholder="Name" name="name" value="<?php if(isset($_SESSION['user'])){echo $_SESSION['user']['name']; }?>" autocomplete="off" required />
                                 </div>
                                 <div class="col-12 col-md-6 ps-0 ps-md-2 mt-2 mt-md-0">
                                    <input type="email" name="email" id="" placeholder="Email" value="<?php if(isset($_SESSION['user'])){echo $_SESSION['user']['email']; }?>" autocomplete="off" required />
                                 </div>
                              </div>

                              <div class="col-12 message_aria">
                                 <textarea id="" cols="30" rows="10" placeholder="Comment" name="comment" autocomplete="off" required></textarea>
                              </div>

                              <div class="row">
                                 <div class="d-flex">
                                    <button class="post_button mt-3" name="post-comment" type="submit" >POST COMMENT</button>
                                 </div>
                              </div>
                           </form>

                        </div>
                     </div>
                  </section>
                  <!-- Comment box -->
               </div>
            </div>
         </div>
      </div>
<script>
   $('.reply').on('click', function(){
      var parentId = $(this).data('parent');
      //alert(parentId);
      $('input[name="parent-id"]').val(parentId);
   });
</script>
   </body>
</html>
