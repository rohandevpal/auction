<?php 
  require_once 'inc/config.php';
  $pageName="Home";

  //News Data 
    $howitWorks = mysqli_query($conn,"SELECT `type`, `title`, `desc` FROM `".$tblPrefix."cms_pages` WHERE type = 2 and status > 1 LIMIT 4");
    $banner = mysqli_query($conn,"SELECT `title`, `sub-title`, `image` FROM `".$tblPrefix."banner` WHERE type = 1 and status = 2");
    $newsQuery = mysqli_query($conn,"SELECT `id`,`name`,`url`,`img`,`short_desc`,`post_date` FROM `".$tblPrefix."blog` WHERE `status` = 2 ORDER BY id DESC"); 
    $testimonial = mysqli_query($conn,"SELECT `name`,`designation`,`review`,`rating`,`media` FROM `".$tblPrefix."testimonial` WHERE status = 2  LIMIT  5");
    $packages = mysqli_query($conn,"SELECT `id`, `name`, `description`, `sale_price` FROM `".$tblPrefix."packages` WHERE status = 2 LIMIT 4");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once 'inc/head.php';?>
  <style>
    .steps_num{
      height: 140px;
      width: 140px;
      border-radius: 100%;
      border:1px solid var(--LightRedColor);
      color:var(--LightRedColor);
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 60px;
      font-weight: 700;
    }
  </style>
</head>

<body>
<!-- <div class="loader_div">
    <img src="./assets/icons&images/mybit/download.svg" alt="">
  </div> -->
  <!-- Header -->
  <?php require_once 'inc/header.php';?>

  <!-- Header -->

  <!-- Main -->
  <main>
  <?php if(mysqli_num_rows($banner)>0){ 
    $dataBanner = mysqli_fetch_assoc($banner);
  ?>
    <!-- banner section -->
    <section class="header_banner_section" style="background-image: url(assets/img/banner/<?php echo $dataBanner['image'];?>);">
      <div class="banner_section_inner banner_padding">
        <div class="container-fluid side_padding">
          <div class="row">
            <div class="col-12 col-lg-6">
              <h1 class="text-white"><?php echo $dataBanner['title'];?></h1>
              <p class="text-white"> <?php echo $dataBanner['sub-title']?> </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- banner section -->
    <?php }?>
  <?php if(mysqli_num_rows($howitWorks)>0){ ?>
    <!-- How it works -->
    <section class="how_it_works_section padding_one main_bg">
      <div class="container-fluid side_padding">

        <!-- How it works heading -->
        <div class="row">
          <div class="col-12 ">
            <div class="hot_it_works_heading text-center py-3">
              <h1>HOW IT <span class="span_color_2">WORKS</span></h1>
              <div class="line_div my-4"></div>
            </div>
          </div>
        </div>
        <!-- How it works heading -->

        <!-- How it works box seaction -->
        <div class="row">
          <?php   
            $i = 0;
            while($datahit = mysqli_fetch_assoc($howitWorks)){
              $i++;
          ?>
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 text-center">
            <!-- Step Images -->
            <div class="steps_num">
              0<?php echo $i;?>
            </div>
            <!-- Step Images -->

            <div class="step_Content_Div my-4">
              <h3><?php echo $datahit['title'];?></h3>
              <div class="line_div my-3"></div>
              <p><?php echo htmlspecialchars_decode(substr($datahit['desc'],0,120));?></p>
            </div>
          </div>
          <?php }?>
        </div>
        <!-- How it works box seaction -->
      </div>
    </section>
    <!-- How it works -->
    <?php }?>


    <!-- Upcomming changes section -->
    <section class="upcomming_auction padding_one main_bg">
      <div class="container-fluid side_padding">

        <!-- Upcomming changes section heading -->
        <div class="row">
          <div class="col-12 ">
            <div class="hot_it_works_heading text-center py-3">
              <h1>UPCOMING <span class="span_color_2">AUCTIONS</span></h1>
              <div class="line_div my-4"></div>
              <p class="light_para">You are welcome to attend and join in the action at any of our upcoming auctions.
              </p>
            </div>
          </div>
        </div>
        <!-- Upcomming changes section heading -->

        <!-- Upcomming changes section tabs div -->
        <!--<div class="row mb-4">-->
        <!--  <div class="col-12">-->
        <!--    <div class="upcomming_auction_div_tabs_div d-flex justify-content-center">-->
        <!--      <ul class="nav nav-pills mb-3 py-2 tabs_card d-flex justify-content-around align-items-center" id="pills-tab" role="tablist">-->
        <!--        <li class="nav-item" role="presentation">-->
        <!--          <button class="nav-link active" id="pills-auction" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">All</button>-->
        <!--        </li>-->
        <!--        <li class="nav-item" role="presentation">-->
        <!--          <button class="nav-link" id="pills-end" data-bs-toggle="pill" data-bs-target="#pills-ended" type="button" role="tab" aria-controls="pills-ended" aria-selected="false"><?php echo auctionType(3);?></button>-->
        <!--        </li>-->
        <!--      </ul>-->
        <!--    </div>-->
        <!--</div>-->
        <!-- Upcomming changes section tabs div -->

        <!-- Upcomming changes section products -->
        <div class="row justify-content-center  pb-5 mt-5 p-2">
           <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-auction">
                <div class="row justify-content-center  pb-5 p-2">
                  <?php echo auctionCard(0,8);?>
                  <!-- Popular cards -->
                </div>
              </div>
            </div>
          </div>
          <!-- Popular cards -->
        </div>
        <!-- Upcomming changes section products -->

      </div>
    </section>
    <!-- Upcomming changes section -->

    <!-- Featured auction section -->
    <section class="deal_of_the_day padding_one">
      <div class="container-fluid side_padding">
        <div class="row py-5">
          <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
            <div class="deal_of_the_day_banne_div">

              <div class="Featured_auction_banner_div Featured_Banner_One">
                <div>
                  <h1>Modern ideas for electronic shops</h1>
                  <a href="./currentAuctions.html">
                    <!--<button class="View_More_Button mt-3 mb-2">View More</button>-->
                  </a>
                </div>
              </div>
              <div class="Featured_auction_banner_div Featured_Banner_Two">
                <div>
                  <h1>you wan’t believe you eyes</h1>
                  <a href="./currentAuctions.html">
                    <!--<button class="View_More_Button mt-3 mb-2">View More</button>-->
                  </a>
                </div>
              </div>

            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
            <!-- Featured auction section content -->
            <div class="row py-3 deal_of_main_div">
              <div class="col-12">
                <div class="Deal_of_heading_div">
                  <h1>FEATURED <span class="span_color_2">AUCTIONS</span></h1>
                </div>
              </div>
            </div>
            <!-- Featured auction section content -->
            <!-- Featured auction section products -->
            <div class="row pt-5 slider">
              <?php echo auctionCard(3,4)?>
            </div>
            <!-- Featured auction section products -->
          </div>
        </div>
      </div>
    </section>
    <!-- Featured auction section -->
  <?php if(mysqli_num_rows($testimonial)>0){?>
    <!-- Testimonials Section -->
    <section class="testimonial_section padding_one main_bg">
      <div class="container-fluid side_padding">

        <!-- Testimonial Section header -->
        <div class="row mb-4">
          <div class="col-12 ">
            <div class="hot_it_works_heading text-center py-3">
              <h1>TESTMONIALS OF OUR <span class="span_color_2">WINNERS</span></h1>
              <div class="line_div my-4"></div>
            </div>
          </div>
        </div>
        <!-- Testimonial Section header -->

        <!-- Testimonial Cards -->
        <div class="row slider2">
        <?php 
            while($dataTestimonial = mysqli_fetch_assoc($testimonial)){
          ?>
          <div class="col-12 col-sm-12 col-md-6 col-lg-12 p-3 slider_two item">
            <div class="userCard_testimonial">
              <!-- Testimonial cards content -->
              <img src="assets/img/testimonial/<?php echo $dataTestimonial['media'];?>" alt="<?php echo $dataTestimonial['name'];?>" class="img-fluid user_profile">
              <!-- Testimonial cards content -->

              <div>
                <div class="d-flex justify-content-between">
                  <span class="my-3 ps-3">
                    <?php echo star_rating($dataTestimonial['rating']);?>
                  </span>
                  <img src="./assests/icons&images/Group 124.svg" alt="">
                </div>
                <p class="user_content_details"><?php echo htmlspecialchars_decode($dataTestimonial['review']);?></p>
                <h4><?php echo $dataTestimonial['name'];?></h4>
                <h5><?php echo $dataTestimonial['designation'];?></h5>
              </div>
            </div>
          </div>
          <?php }?>
        </div>
        <!-- Testimonial Cards -->

      </div>
    </section>
    <!-- Testimonials Section -->
    <?php }?>

    <!-- Our Pricing Plans -->
    <section class="our_pricing_plan  main_bg">
      <div class="container-fluid side_padding">


        <!-- Our Pricing plan heading -->
        <div class="row ">
          <div class="col-12 ">
            <div class="hot_it_works_heading text-center py-3">
              <h1 class="white_heading">OUR PRICING <span class="span_color_2">PLANS</span></h1>
              <div class="line_div my-4"></div>
            </div>
          </div>
        </div>
        <!-- Our Pricing plan heading -->

      </div>
    </section>
    <!-- Our Pricing Plans -->

    <?php if(mysqli_num_rows($packages)){?>
    <!-- Price_Cards -->
    <section class="products_price_div padding_one main_bg ">
      <div class="container-fluid price_card_margin_div pb-5 side_padding">
        <div class="row justify-content-center">
          <?php
            while($dataPackages = mysqli_fetch_assoc($packages)){
          ?>
          <!-- Price div cards -->
          <div class="col-11 col-sm-9 col-md-6 col-xl-5 col-xxl-3 my-3 my-sm-3 my-md-3 my-lg-0 my-xxl-0 ">
            <div class="price_plan_card_inner_div">

              <div class="price_plan_heading activeBar_plan text-center">
                <h1 class="my-4"><?php echo $dataPackages['name'];?></h1>
              </div>

              <div class="price_plan_heading_content px-4 py-3 text-center">
                <p class="light_para my-4"><?php echo $dataPackages['description'];?></p>

                <h2 class="Price_Dolar "><span>CA$ </span><?php echo $dataPackages['sale_price'];?></h2>

                <a href="payments.php?type=token&package=<?php echo $dataPackages['id'];?>"class="View_More_Button my-3">Buy Now</a>
              </div>
            </div>
          </div>
          <!-- Price div cards -->
          <?php }?>
        </div>
      </div>
    </section>
    <!-- Price_Cards -->
    <?php } ?>

    <!-- Register for free start -->
    <?php require_once 'inc/register.php';?>
    <!-- Register for free start -->
    <?php if(mysqli_num_rows($newsQuery)>0){?>
    <!-- Latest News Update -->
    <section class="Latest_News_update padding_one main_bg">
      <div class="container-fluid side_padding">

        <!-- Our Pricing plan heading -->
        <div class="row ">
          <div class="col-12 ">
            <div class="hot_it_works_heading text-center py-3">
              <h1>LATEST NEWS <span class="span_color_2">UPDATE</span></h1>
              <div class="line_div my-4"></div>
            </div>
          </div>
        </div>
        <!-- Our Pricing plan heading -->

        <!-- News Post Div -->
        <div class="row py-3">
          <?php 
            while ($newsData = mysqli_fetch_assoc($newsQuery)){
          ?>
          <div class="col-12 col-sm-12 col-md-6 col-lg-4">
            <!-- Posts -->
            <div class="post_div  my-3 my-sm-3 my-md-3 my-lg-0 my-xxl-0">
              <!-- Post Previwe -->
              <div class="post_img_div">
                <img src="./assets/img/blog/<?php echo $newsData['img']?>" alt="">
                <div class="post_date_div">
                  <h3 class="text-white"><?php echo date("d",strtotime($newsData['post_date'])); echo '<span>'; date("Y",strtotime($newsData['post_date'])); echo'</span>'; ?></h3>
                </div>
              </div>
              <!-- Post Previwe -->
              <!-- Post Details -->
              <div class="my-3 d-flex align-items-center">
                <img src="./assests/icons&images/Group 4.svg" alt="">
                <p class="ms-3 light_para">By Giulia May</p>
              </div>

              <h1><?php echo $newsData['name'];?></h1>

              <p class="post_discription light_para mb-3"><?php echo $newsData['short_desc'];?></p>
              <a href="./blog.html">
                <a href = "blog.php?slug=<?php echo urlencode($newsData['url']); ?>&blog=<?php echo $newsData['id']; ?>" class="Read_more_button ">Read More <img src="./assests/icons&images/Vector (2).svg"
                    alt=""></a>
                    
                <!-- Post Details -->
              </a>
            </div>
            <!-- Posts -->
          </div>
          <?php }?>
        </div>
        <!-- News Post Div -->

      </div>
    </section>
    <!-- Latest News Update -->
    <?php }?>

    <!-- News Letter Section -->
  <?php require_once 'inc/newsletter.php';?>
    <!-- News Letter Section -->

  </main>
  <!-- Main -->

  <!-- Footer -->
  <?php require_once 'inc/footer.php';?>
  <!-- Footer -->

  <?php require_once 'inc/js.php'; ?>

  <!-- jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- slick -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

  <!-- Bootsrap 5 script CDN -->
  
  <!-- Alertify -->
  <script type="text/javascript" src="./assets/js/alertify.min.js"></script>

  <?php echo toast(1);?>
  <!-- Script File CDN -->
  <script src="./assests/js/main.js"></script>
  <script>

    $('.slider').slick({
      dots: false,
      infinite: true,
      speed: 300,
      slidesToShow: 3,
      slidesToScroll: 2,
      responsive: [
        {
          breakpoint: 1300,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
    $('.slider2').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 2,
      slidesToScroll: 2,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
  </script>
</body>

</html>