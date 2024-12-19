<?php
// ob_start();
session_start();

include('includes/db.php');

$query = "SELECT * FROM landing_images where `show` = 'yes' LIMIT 4";
$result = mysqli_query($con, $query);

$query2 = "SELECT * FROM products LIMIT 3";
$result2 = mysqli_query($con, $query2);

$query5 = "SELECT * FROM manufacturers where manufacturer_top = 'yes'";
$result5 = mysqli_query($con, $query5);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<!-- Mirrored from html.merku.love/promotors/home1_repair_service by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:15:44 GMT -->

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width,initial-scale=1,shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>
    Home!!
  </title>

  <?php
  include 'includes/head-links.php';
  ?>
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <style>
    .testimonials-section {
      background-color: #f8f9fa;
      padding: 60px 20px;
      text-align: center;
    }

    .testimonials-section h2 {
      font-size: 28px;
      color: #333;
      margin-bottom: 30px;
    }

    .swiper-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 20px 0;
    }

    .swiper-slide {
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 30px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .testimonial-content {
      text-align: left;
    }

    .testimonial-content h3 {
      font-size: 20px;
      color: #007bff;
      margin-bottom: 5px;
    }

    .testimonial-content p {
      color: #555;
      font-size: 16px;
      margin-bottom: 15px;
    }

    .testimonial-date {
      font-size: 14px;
      color: #888;
      text-align: right;
    }

    .quote-icon {
      font-size: 40px;
      color: #ff5722;
      margin-bottom: 10px;
    }

    /* Swiper Navigation */
    .swiper-button-next,
    .swiper-button-prev {
      background-color: #ff5722;
      border-radius: 50%;
      color: #fff;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
      font-size: 16px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .swiper-slide {
        padding: 20px;
      }

      .testimonials-section h2 {
        font-size: 24px;
      }

      .testimonial-content h3 {
        font-size: 18px;
      }

      .testimonial-content p {
        font-size: 14px;
      }
    }
  </style>

</head>

<body>

  <?php
  include 'includes/top-bar.php';
  ?>

  <div class="page_wrapper">

    <?php
    include 'includes/header.php';
    ?>

    <main class="page_content">
      <section class="hero_section hero_section_1">
        <div class="container">
          <div class="row">
            <div class="col-lg-6" style="margin-top: 80px;">
              <div class="hero_section_content">
                <h1 class="hero_title wow" data-splitting>
                  Gear Up with <br> Moto Dresser
                </h1>
                <p style="font-size: larger;">
                  Ride in Style & Safety, explore a wide range of premium biking gear and accessories tailored for true riders. At Moto Dresser, we combine quality, comfort, and style, ensuring that every ride is as safe and stylish as it is thrilling. Whether you're on a long journey or a short ride, we've got the perfect gear for you.
                </p>
                <a class="btn btn-primary" href="shop"><span class="btn_text">Shop Now</span></a>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="hero_section_image">
                <img
                  data-parallax='{"scale" : 0.6, "smoothness": 8}'
                  src="./photos/pngwing.com (17).png"
                  alt="ProMotors – Car Service Image" />
              </div>
            </div>
          </div>
        </div>
        <div
          class="outline_text" style="font-size: 135px;top: 10%; color: black;"
          data-parallax='{"x" : -200, "smoothness": 8}'>MOTODRESSER</div>
      </section>

      <div class="container1">

        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($post = mysqli_fetch_assoc($result)) : ?>
            <div class="item helmet" style="height: 500px;">
              <a href="shop"><img src="admin_area/landing_images/<?= $post['image'] ?>" alt="<?= $post['title'] ?>"></a>
              <div class="label"> <?= $post['title'] ?> </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No Images found.</p>
        <?php endif; ?>

      </div>
      <div class="con">
        <h1>Featured Products</h1>
        <hr>
        <section class="product-grid">


          <?php if (mysqli_num_rows($result2) > 0): ?>
            <?php while ($post = mysqli_fetch_assoc($result2)) : ?>
              <?php
                    $product_id = $post['product_id'];
                    $query10 = "SELECT * FROM product_images where product_id = $product_id";
                    $result10 = mysqli_query($con, $query10);
                    $post10 = mysqli_fetch_assoc($result10);
                    ?>
              <div class="product-card">
                <img style="height: 170px;" src="admin_area/product_images/<?= $post10['image'] ?>" alt="product img">
                <h3><?= $post['product_title'] ?></h3>
                <!-- <p class="category"><?= $post['product_title'] ?></p> -->
                <p class="price">₹<?= $post['product_psp_price'] ?></p>
                <a href="shop_details?id=<?= $post['product_id'] ?>"><button class="btn">Shop Now</button></a>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p>No Images found.</p>
          <?php endif; ?>

        </section>
      </div>



      <section class="features-section con">
        <h1>We Are Giving
          <hr>
        </h1>
        <div class="container4" style="margin-top: 80px;">
          <div class="feature-box">
            <img src="https://bisonprogear.com/wp-content/uploads/2023/08/globe-free-img.png" alt="PAN India Shipping Icon">
            <h3>PAN India Shipping</h3>
            <p>We understand that receiving your order promptly and securely is essential. That's why we've streamlined our shipping process to ensure a seamless experience from click to delivery.</p>
          </div>

          <div class="feature-box">
            <img src="https://bisonprogear.com/wp-content/uploads/2023/08/quality-free-img.png" alt="Best Quality Icon">
            <h3>Best Quality</h3>
            <p>Revolutionize your ride with our motorcycle gears, setting the benchmark for the industry's best quality in durability, safety, and style.</p>
          </div>

          <div class="feature-box">
            <img src="https://bisonprogear.com/wp-content/uploads/2024/01/safety-icon.png" alt="Safety First Icon">
            <h3>Safety First</h3>
            <p>From cutting-edge materials to precision engineering, our gear is designed with your safety as the utmost priority, allowing you to focus on the joy of the ride.</p>
          </div>

          <div class="feature-box">
            <img src="https://bisonprogear.com/wp-content/uploads/2023/08/lock-free-img.png" alt="Secure Payments Icon">
            <h3>Secure Payments</h3>
            <p>With multiple layers of encryption and advanced fraud prevention measures in place, you can shop confidently, knowing that your sensitive information is shielded from unauthorized access.</p>
          </div>
        </div>
      </section>

      <section class="testimonials-section" style="margin: 40px 0 40px; background-color: white;">
        <h1 style="display: flex; flex-direction: column; align-items: center;">Testimonials
          <hr style="width: 10%; border-bottom: red 3px solid;">
        </h1>
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <?php
            // Fetch testimonials from the database
            $testimonialQuery = "SELECT t_name, t_message, t_date_updated FROM testimonials ORDER BY t_date_created DESC";
            $testimonialResult = $con->query($testimonialQuery);

            if ($testimonialResult && $testimonialResult->num_rows > 0) {
              while ($testimonial = $testimonialResult->fetch_assoc()) {
                echo "
                        <div class='swiper-slide'>
                            <div class='testimonial-content'>
                                <span class='quote-icon'>&ldquo;</span>
                                <h3>{$testimonial['t_name']}</h3>
                                <p>{$testimonial['t_message']}</p>
                                <div class='testimonial-date'>Posted on: " . date('F j, Y', strtotime($testimonial['t_date_updated'])) . "</div>
                            </div>
                        </div>";
              }
            } else {
              echo "<div class='swiper-slide'><p>No testimonials available yet. Be the first to share your experience!</p></div>";
            }
            ?>
          </div>
          <!-- <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div> -->
        </div>
      </section>

      <section class="brand_logo_section section_space_lg text-center" style="background-color: white; margin-bottom: 40px;">
        <div class="container">
          <div class="section_heading">
            <h2 class="heading_text mb-0 wow" style="display: flex; flex-direction: column; align-items: center;" data-splitting>
              <span>Best Brand</span>
              <hr style="width: 10%; border-bottom: red 3px solid;">
            </h2>
          </div>
        </div>
        <div
          class="brand_logo_carousel brand_logo_blur_effect row align-items-center"
          data-slick='{"dots":false, "arrows": false}'>

          <?php while ($post = mysqli_fetch_assoc($result5)) : ?>
            <div class="col-">
              <a class="brand_logo_item" href="shop_brands?id=<?= $post['manufacturer_id'] ?>"><img
                  src="admin_area/other_images/<?= $post['manufacturer_image'] ?>"
                  alt="brandslogo" /></a>
            </div>
          <?php endwhile; ?>
      </section>

      <!-- <section class="blog_section" style="margin-top: 5%;">
          <div class="container">
            <div class="section_heading">
              <h2 class="heading_text mb-0 wow" data-splitting>
                Popular Articles
              </h2>
            </div>
            <div class="blog_item content_above_image">
              <a class="item_image" href="#"
                ><img
                  src="./photos/p2.jpg"
                  alt="ProMotors - Blog Image"
              /></a>
              <div class="item_content">
                <ul class="item_type_list unordered_list">
                  <li><a href="#!">Bike Advice</a></li>
                  <li><a href="#!">Bike Repair</a></li>
                </ul>
                <h3 class="item_title">
                  <a href="#"
                    >Signs Your Bike Battery Has To Be Replaced</a
                  >
                </h3>
                <ul class="post_meta unordered_list">
                  <li>May, 29 2023</li>
                  <li><a href="#!">No Comments</a></li>
                </ul>
                <a class="btn-link" href="#"
                  ><span class="btn_icon"
                    ><i class="fa-regular fa-angle-right"></i
                  ></span>
                  <span class="btn_text"
                    ><small>Read More</small> <small>Read More</small></span
                  ></a
                >
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="blog_item">
                  <a class="item_image" href="#"
                    ><img
                      src="https://static.toiimg.com/thumb/msid-105726718,width-1070,height-580,imgsize-73542,resizemode-6,overlay-toi_sw,pt-32,y_pad-40/photo.jpg"
                      alt="ProMotors - Blog Image"
                  /></a>
                  <div class="item_content">
                    <ul class="item_type_list unordered_list">
                      <li><a href="#!">Bike Advice</a></li>
                    </ul>
                    <h3 class="item_title">
                      <a href="#"
                        >How To Protect The Interior Of Your Bike</a
                      >
                    </h3>
                    <ul class="post_meta unordered_list">
                      <li>May, 29 2023</li>
                      <li><a href="#!">No Comments</a></li>
                    </ul>
                    <a class="btn-link" href="#"
                      ><span class="btn_icon"
                        ><i class="fa-regular fa-angle-right"></i
                      ></span>
                      <span class="btn_text"
                        ><small>Read More</small> <small>Read More</small></span
                      ></a
                    >
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="blog_item">
                  <a class="item_image" href="#"
                    ><img
                      src="https://www.autozone.com/diy/wp-content/uploads/2019/06/common-ignition-problems-870x489.jpg"
                      alt="ProMotors - Blog Image"
                  /></a>
                  <div class="item_content">
                    <ul class="item_type_list unordered_list">
                      <li><a href="#!">Bike Advice</a></li>
                    </ul>
                    <h3 class="item_title">
                      <a href="#"
                        >Is Your Bike’s Check Engine Light Flashing?</a
                      >
                    </h3>
                    <ul class="post_meta unordered_list">
                      <li>May, 29 2023</li>
                      <li><a href="#!">No Comments</a></li>
                    </ul>
                    <a class="btn-link" href="#"
                      ><span class="btn_icon"
                        ><i class="fa-regular fa-angle-right"></i
                      ></span>
                      <span class="btn_text"
                        ><small>Read More</small> <small>Read More</small></span
                      ></a
                    >
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="blog_item">
                  <a class="item_image" href="#"
                    ><img
                      src="https://acko-cms.s3.ap-south-1.amazonaws.com/medium_Bike_Maintenance_Tips_99ef2fcc6f.png"
                      alt="ProMotors - Blog Image"
                  /></a>
                  <div class="item_content">
                    <ul class="item_type_list unordered_list">
                      <li><a href="#!">Bike Advice</a></li>
                    </ul>
                    <h3 class="item_title">
                      <a href="#"
                        >5 Must-Have Things In Your Bike for Safety</a
                      >
                    </h3>
                    <ul class="post_meta unordered_list">
                      <li>May, 29 2023</li>
                      <li><a href="#!">No Comments</a></li>
                    </ul>
                    <a class="btn-link" href="#"
                      ><span class="btn_icon"
                        ><i class="fa-regular fa-angle-right"></i
                      ></span>
                      <span class="btn_text"
                        ><small>Read More</small> <small>Read More</small></span
                      ></a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section> -->

    </main>
    <?php
    include 'includes/footer.php';
    ?>
  </div>

  <?php
  include 'includes/script-links.php';
  ?>

  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper('.swiper-container', {
      loop: true,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      spaceBetween: 20,
      slidesPerView: 1,
    });
  </script>
</body>
<!-- Mirrored from html.merku.love/promotors/home1_repair_service by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:16:03 GMT -->

</html>