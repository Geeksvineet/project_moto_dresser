<?php
session_start();
include './includes/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$limit = 9; // Number of blogs per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM products where manufacturer_id = $id LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);

$query2 = "SELECT * FROM product_categories where p_cat_top = 'yes'";
$result2 = mysqli_query($con, $query2);

$query3 = "SELECT * FROM manufacturers where manufacturer_top = 'yes'";
$result3 = mysqli_query($con, $query3);

$query4 = "SELECT * FROM products LIMIT 3";
$result4 = mysqli_query($con, $query4);

$query5 = "SELECT * FROM manufacturers";
$result5 = mysqli_query($con, $query5);

$totalQuery = "SELECT COUNT(*) as total FROM products where manufacturer_id = $id";
$totalResult = mysqli_query($con, $totalQuery);
$totalBlogs = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalBlogs / $limit);

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<!-- Mirrored from html.merku.love/promotors/shop by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:05 GMT -->

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width,initial-scale=1,shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Our Shop – ProMotors – Car Service & Detailing Template</title>
  <?php
  include 'includes/head-links.php';
  ?>
</head>

<body>
  <?php
  include 'includes/top-bar.php';
  ?>
  <div class="page_wrapper">

    <?php
    include 'includes/header.php';
    ?>
    <main class="page_content" style="margin-top: 140px; padding-bottom: 100px;">
      <section
        class="page_banner"
        style="background-image: url('assets/images/shapes/tyre_print_3.svg')">
        <div class="container">
          <ul class="breadcrumb_nav unordered_list">
            <li><a href="index">Home</a></li>
            <li><a href="shop">Our Shop</a></li>
          </ul>
          <h1 class="page_title wow" data-splitting>Our Shop</h1>
        </div>
      </section>
      <section class="shop_section section_space_lg pb-0">
        <div class="container">
          <div class="row">
            <div class="col-lg-9">
              <div class="row">

              <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($post = mysqli_fetch_assoc($result)) : ?>
                  <?php
                    $product_id = $post['product_id'];
                    $query10 = "SELECT * FROM product_images where product_id = $product_id";
                    $result10 = mysqli_query($con, $query10);
                    $post10 = mysqli_fetch_assoc($result10);
                    ?>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="product_item">
                      <ul class="badge_group unordered_list">
                        <li><span class="badge badge-primary"><?= $post['product_label'] ?></span></li>
                      </ul>
                      <a class="item_image" href="shop_details?id=<?= $post['product_id'] ?>"><img
                          src="admin_area/product_images/<?= $post10['image'] ?>"
                          alt="ProMotors - Product Image" /></a>
                      <div class="item_content">
                        <h3 class="item_title">
                          <a href="shop_details?id=<?= $post['product_id'] ?>"><?= $post['product_title'] ?></a>
                        </h3>
                        <!-- <a class="item_brand" href="shop_details?id=<?= $post['product_id'] ?>"><?= $post['product_keywords'] ?></a> -->
                        <div class="item_footer">
                          <div class="item_price">
                            <span class="sale_price">₹<?= $post['product_psp_price'] ?></span>
                            <del class="remove_price">₹<?= $post['product_price'] ?></del>
                          </div>
                          <a class="btn-link" href="shop_details?id=<?= $post['product_id'] ?>"><span class="btn_icon"><i class="fa fa-angle-right"></i></span>
                            <span class="btn_text"><small>Shop Now</small>
                              <small>Shop Now</small></span></a>
                        </div>
                      </div>
                      <ul class="cart_btns_group unordered_list_block">


                        <?php
                        // session_start();

                        // Check if the user is logged in by verifying the presence of a session variable (e.g., 'user_id')
                        if (isset($_SESSION['user_id'])) {
                          echo '<li>
        <a href="add_to_wishlist?product_id=' . $post["product_id"] . '"><i class="fa-light fa-heart"></i></a>
      </li>';
                        }
                        ?>
                        <li>
                          <a href="shop_details?id=<?= $post['product_id'] ?>"><i class="fa-light fa-eye"></i></a>
                        </li>
                        <!-- <li>
                          <a href="#!"><i class="fa-light fa-code-compare"></i></a>
                        </li> -->
                      </ul>
                    </div>
                  </div>
                <?php endwhile; ?>
                <?php else: ?>
                  <p>No Products found.</p>
                <?php endif; ?>

              </div>

              <div class="pagination_wrap">
                <ul class="pagination_nav unordered_list">
                  <?php if ($page > 1): ?>
                    <li><a href="?page=<?= $page - 1 ?>"><i class="fa fa-angle-left"></i></a></li>
                  <?php endif; ?>
                  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="<?= $page == $i ? 'active' : '' ?>"><a href="?page=<?= $i ?>"><?= $i ?></a></li>
                  <?php endfor; ?>
                  <?php if ($page < $totalPages): ?>
                    <li><a href="?page=<?= $page + 1 ?>"><i class="fa fa-angle-right"></i></a></li>
                  <?php endif; ?>
                </ul>
              </div>

            </div>
            <div class="col-lg-3">
              <aside class="sidebar style_2">
                <!-- <div class="widget">
                  <h3 class="widget_title">Search</h3>
                  <div class="form-group mb-0">
                    <input
                      type="search"
                      name="search"
                      class="form-control"
                      placeholder="Search…" />
                  </div>
                </div> -->
                <div class="widget">
                  <h3 class="widget_title">Product Categories</h3>
                  <ul class="info_list unordered_list_block">
                    <?php while ($post = mysqli_fetch_assoc($result2)) : ?>
                      <li>
                        <a href="shop_product_category?id=<?= $post['p_cat_id'] ?>"><span class="info_icon"><img
                              src="assets/images/icons/icon_square.svg"
                              alt="Icon Square" /> </span><span class="info_text"><?= $post['p_cat_title'] ?></span></a>
                      </li>
                    <?php endwhile; ?>
                  </ul>
                </div>
                <div class="widget">
                  <h3 class="widget_title">Popular Brands</h3>
                  <ul class="tags_list unordered_list">

                    <?php while ($post = mysqli_fetch_assoc($result3)) : ?>
                      <li><a href="shop_brands?id=<?= $post['manufacturer_id'] ?>"><?= $post['manufacturer_title'] ?></a></li>
                    <?php endwhile; ?>
                  </ul>
                </div>
                <!-- <div class="widget">
                  <h3 class="widget_title">Filter By Price</h3>
                  <div class="price-range-area clearfix">
                    <div id="slider-range" class="slider-range"></div>
                    <div class="price-text">
                      <span>Price:</span>
                      <input type="text" id="amount" readonly="readonly" />
                    </div>
                  </div>
                </div> -->
                <div class="widget">
                  <h3 class="widget_title">Featured Products</h3>
                  <div class="small_products_list">

                    <?php while ($post = mysqli_fetch_assoc($result4)) : ?>
                      <?php
                    $product_id = $post['product_id'];
                    $query10 = "SELECT * FROM product_images where product_id = $product_id";
                    $result10 = mysqli_query($con, $query10);
                    $post10 = mysqli_fetch_assoc($result10);
                    ?>

                      <div class="small_products_item">
                        <a class="item_image" href="shop_details?id=<?= $post['product_id'] ?>"><img
                            src="admin_area/product_images/<?= $post10['image'] ?>"
                            alt="Product Image" /></a>
                        <div class="item_content">
                          <ul class="badge_group unordered_list">
                            <!-- <li>
                              <span class="badge badge-danger"><?= $post['product_label'] ?></span>
                            </li> -->
                          </ul>
                          <h3 class="item_title">
                            <a href="shop_details?id=<?= $post['product_id'] ?>"><?= $post['product_title'] ?></a>
                          </h3>
                          <!-- <a class="item_brand" href="shop_details?id=<?= $post['product_id'] ?>"><?= $post['product_keywords'] ?></a> -->
                          <div class="item_price">
                            <span class="sale_price">₹<?= $post['product_psp_price'] ?></span>
                            <del class="remove_price">₹<?= $post['product_price'] ?></del>
                          </div>
                        </div>
                      </div>
                    <?php endwhile; ?>

                  </div>
                </div>
              </aside>
            </div>
          </div>
        </div>
      </section>

      <!-- <section class="promotion_product_section section_space_lg pb-0">
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <div class="row">
                <div class="col-12">
                  <div class="promotion_product_item">
                    <div class="item_content">
                      <h3 class="item_title">
                        <a href="shop_details">Garage & Auto Shop Equipment</a>
                      </h3>
                      <p>
                        Essential equipment for auto repair and maintenance.
                        In hac habitasse platea dictumst vestibulum rhoncus
                      </p>
                      <div class="item_price">
                        <sub>from</sub> <span class="sale_price">$49.99</span>
                      </div>
                      <div class="btn_wrap pb-0">
                        <a class="btn-link" href="shop_details"><span class="btn_icon"><i class="fa-regular fa-angle-right"></i></span>
                          <span class="btn_text"><small>Shop Now</small>
                            <small>Shop Now</small></span></a>
                      </div>
                    </div>
                    <div class="item_image">
                      <img
                        src="assets/images/products/promotion_product_img_1.png"
                        alt="ProMotors - Promotion Product Image" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class="promotion_product_item small_content">
                    <div class="item_content">
                      <h3 class="item_title">
                        <a href="shop_details">0W20 Synthetic Motor Oil, 5-L</a>
                      </h3>
                      <div class="item_price">
                        <span class="sale_price">$34</span>
                        <del class="remove_price">$44</del>
                      </div>
                      <div class="btn_wrap pb-0">
                        <a class="btn-link" href="shop_details"><span class="btn_icon"><i class="fa-regular fa-angle-right"></i></span>
                          <span class="btn_text"><small>Shop Now</small>
                            <small>Shop Now</small></span></a>
                      </div>
                    </div>
                    <div class="item_image">
                      <img
                        src="assets/images/products/promotion_product_img_2.png"
                        alt="ProMotors - Promotion Product Image" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class="promotion_product_item small_content">
                    <div class="item_content">
                      <h3 class="item_title">
                        <a href="shop_details">U1 12-Volt 32 Ah Battery</a>
                      </h3>
                      <div class="item_price">
                        <span class="sale_price">$129</span>
                        <del class="remove_price">$134</del>
                      </div>
                      <div class="btn_wrap pb-0">
                        <a class="btn-link" href="shop_details"><span class="btn_icon"><i class="fa-regular fa-angle-right"></i></span>
                          <span class="btn_text"><small>Shop Now</small>
                            <small>Shop Now</small></span></a>
                      </div>
                    </div>
                    <div class="item_image">
                      <img
                        src="assets/images/products/promotion_product_img_3.png"
                        alt="ProMotors - Promotion Product Image" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="promotion_product_item d-block">
                <div class="item_content mb-5">
                  <h3 class="item_title">
                    <a href="shop_details">Save up to $99 on your purchase of any set of Michelin
                      tires</a>
                  </h3>
                  <p>
                    The instant savings will be deducted in the shopping cart
                    on qualifying products
                  </p>
                  <div class="item_price">
                    <sub>Up To</sub> <span class="sale_price">$99</span>
                  </div>
                  <div class="btn_wrap pb-0">
                    <a class="btn btn-primary" href="shop_details"><span class="btn_text">Shop NOW</span>
                      <span class="btn_icon ms-1"><i class="fa-solid fa-angles-right"></i></span></a>
                  </div>
                </div>
                <div class="item_image">
                  <img
                    src="assets/images/products/promotion_product_img_4.png"
                    alt="ProMotors - Promotion Product Image" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->

      <!-- <section class="workprocess_section section_space_lg pb-0">
        <div class="container">
          <div class="row">
            <div class="col-lg-4">
              <div class="section_heading pe-lg-5">
                <h2 class="heading_text wow" data-splitting>
                  Placing an Order – Step by Step
                </h2>
                <p class="heading_description mb-0">
                  Egestas integer eget aliquet nibh praesent tristique magna.
                  Penatibus et magnis dis parturient montes nascetur ridiculus
                </p>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="row">
                <div class="col-md-6 col-sm-6">
                  <div class="workprocess_item">
                    <h3 class="item_title">
                      <span class="serial_number">01</span>
                      <span class="title_text">make an appointment</span>
                    </h3>
                    <p class="mb-0">
                      Tempor id eu nisl nunc mi ipsum faucibus. Ac feugiat sed
                      lectus vestibulum. Pellentesue habitant morbi tristique
                      senectus
                    </p>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class="workprocess_item">
                    <h3 class="item_title">
                      <span class="serial_number">02</span>
                      <span class="title_text">Select service</span>
                    </h3>
                    <p class="mb-0">
                      Pretium quam vulputate dignissim suspendisse in est
                      ante. Neque tempus quam pellentesque nec nam aliquam
                    </p>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class="workprocess_item">
                    <h3 class="item_title">
                      <span class="serial_number">03</span>
                      <span class="title_text">Confirm request</span>
                    </h3>
                    <p class="mb-0">
                      Ullamcorper eget nulla facilisi etiam. Integer eget
                      aliquet nibh praesent tristique magna sit. Placerat
                      vestibulum lectus mauris ultrices
                    </p>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class="workprocess_item">
                    <h3 class="item_title">
                      <span class="serial_number">04</span>
                      <span class="title_text">get your car</span>
                    </h3>
                    <p class="mb-0">
                      Faucibus ornare suspendisse sed nisi lacus sed viverra
                      tellus in. Tortor pretium viverra suspendisse potenti
                      nullam
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->

      <!-- <section class="brand_logo_section section_space_lg text-center">
        <div class="container">
          <div class="section_heading">
            <h2 class="heading_text mb-0 wow" data-splitting>
              Best Multi Brand Car Repair Service
            </h2>
          </div>
        </div>
        <div
          class="brand_logo_carousel brand_logo_blur_effect row align-items-center"
          data-slick='{"dots":false, "arrows": false}'>

          <?php while ($post = mysqli_fetch_assoc($result5)) : ?>
            <div class="col-">
              <a class="brand_logo_item" href="#!"><img
                  src="admin_area/other_images/<?= $post['manufacturer_image'] ?>"
                  alt="ProMotors - TOYOTA Logo" /></a>
            </div>
          <?php endwhile; ?>
      </section> -->
    </main>
    <?php
    include 'includes/footer.php';
    ?>
  </div>
  <?php
  include 'includes/script-links.php';
  ?>
</body>
<!-- Mirrored from html.merku.love/promotors/shop by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:05 GMT -->

</html>