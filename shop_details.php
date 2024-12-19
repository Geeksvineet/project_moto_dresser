<?php
session_start();
include './includes/db.php';
include './includes/functions.php';

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$sql = "SELECT * FROM products WHERE product_id = $product_id";
$result = $con->query($sql);
$product = $result->fetch_assoc();

// $query3 = "SELECT * FROM product_images where product_id = $product_id";
// $result3 = mysqli_query($con, $query3);

// $query4 = "SELECT * FROM product_images where product_id = $product_id";
// $result4 = mysqli_query($con, $query4);
// $post10 = mysqli_fetch_assoc($result10);

?>



<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<!-- Mirrored from html.merku.love/promotors/shop_details by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:05 GMT -->

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width,initial-scale=1,shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Shop Details – ProMotors – Car Service & Detailing Template</title>
  <?php
  include 'includes/head-links.php';
  ?>

  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">


  <style>
    .rating_star {
      list-style: none;
      padding: 0;
      display: flex;
    }

    .rating_star input[type="radio"] {
      display: none;
      /* Hide radio buttons */
    }

    .rating_star label {
      font-size: 24px;
      color: #ccc;
      /* Default color for unselected stars */
      cursor: pointer;
      transition: color 0.2s ease;
      /* Smooth transition for color change */
    }

    /* Hover effect */
    .rating_star label:hover,
    .rating_star label:hover~label {
      color: #f5a623;
      /* Star color when hovering */
    }

    /* Fill stars based on selection */
    .rating_star input[type="radio"]:checked~label {
      color: #f5a623;
      /* Selected star color */
    }

    .rating_star input[type="radio"]:checked+label,
    .rating_star input[type="radio"]:checked+label~label {
      color: #f5a623;
      /* Change star color when a rating is selected */
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
      <section class="details_section shop_details section_space_lg">
        <div class="container">
          <div class="section_space_sm pt-0">
            <div class="row">
              <div class="col-lg-6">
                <div class="image_gallery_carousel" id="image_gallery_carousel">
                  <?php
                  // Fetch the product ID and selected color (if any)
                  // $product_id = $product['product_id'];
                  $selected_color = isset($_POST['color']) ? $_POST['color'] : null;

                  // Get images based on the selected color
                  $result3 = getImage_vs($product_id, $selected_color);
                  $result4 = getImage_vs($product_id, $selected_color);
                  ?>

                  <div class="details_image_carousel" id="imageCarousel">
                    <?php while ($post = mysqli_fetch_assoc($result3)) : ?>
                      <div class="gallery_image">
                        <img src="./admin_area/product_images/<?php echo htmlspecialchars($post['image']); ?>" alt="Product Image" />
                      </div>
                    <?php endwhile; ?>
                  </div>

                  <?php mysqli_data_seek($result, 0); ?>

                  <div class="details_image_carousel_nav">
                    <?php while ($post = mysqli_fetch_assoc($result4)) : ?>
                      <div class="gallery_image">
                        <img src="./admin_area/product_images/<?php echo htmlspecialchars($post['image']); ?>" alt="Product Image" />
                      </div>
                    <?php endwhile; ?>
                  </div>
                </div>


              </div>
              <div class="col-lg-6">
                <div class="details_content ps-lg-4">
                  <ul class="breadcrumb_nav unordered_list mb-4">
                    <li><a href="index">Home</a></li>
                    <li><a href="shop">Our Shop</a></li>
                    <li><a href="#">Shop Details</a></li>
                  </ul>
                  <h1 class="details_item_title">
                    <?php echo $product['product_title']; ?>
                  </h1>
                  <div class="item_price">
                    <span class="sale_price">₹<?php echo $product['product_psp_price']; ?></span>
                    <del class="remove_price">₹<?php echo $product['product_price']; ?></del>
                  </div>

                  <?php
                  // Assume $product_id is set and valid before using it in the query
                  if (isset($product_id)) {
                    // Fetch reviews for the product and calculate the average rating
                    $sql_reviews = "SELECT AVG(rating) as average_rating, COUNT(*) as review_count FROM reviews WHERE product_id = $product_id";
                    $reviews_result = $con->query($sql_reviews);
                    $review_data = $reviews_result->fetch_assoc();

                    // Get the average rating and round it to one decimal place
                    $average_rating = isset($review_data['average_rating']) ? round($review_data['average_rating'], 1) : 0;
                    $review_count = isset($review_data['review_count']) ? $review_data['review_count'] : 0; // Number of reviews for display
                  } else {
                    // Handle the case where $product_id is not set
                    $average_rating = 0;
                    $review_count = 0;
                  }

                  // Initialize star count variable
                  $filled_stars = floor($average_rating); // Full stars
                  $half_star = ($average_rating - $filled_stars) >= 0.5; // Determine if there's a half star
                  ?>

                  <!-- Display the rating stars -->
                  <ul class="rating_star unordered_list mb-4">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                      <li>
                        <?php if ($i <= $filled_stars): ?>
                          <i class="fa-solid fa-star"></i> <!-- Filled Star -->
                        <?php elseif ($half_star && $i == $filled_stars + 1): ?>
                          <i class="fa-solid fa-star-half-alt"></i> <!-- Half Star -->
                        <?php else: ?>
                          <i class="fa-regular fa-star"></i> <!-- Empty Star -->
                        <?php endif; ?>
                      </li>
                    <?php endfor; ?>
                  </ul>

                  <!-- Display the average rating and number of reviews -->
                  <!-- <p><?= $average_rating ?> out of 5 stars (based on <?= $review_count ?> reviews)</p> -->





                  <!-- <ul class="rating_star unordered_list mb-4">
                    <li><i class="fa-solid fa-star"></i></li>
                    <li><i class="fa-solid fa-star"></i></li>
                    <li><i class="fa-solid fa-star"></i></li>
                    <li><i class="fa-solid fa-star"></i></li>
                    <li><i class="fa-solid fa-star"></i></li>
                  </ul> -->
                  <p>
                    <?php echo $product['product_short_desc']; ?>
                  </p>


                  <!-- Color Selection -->
                  <!-- Color Selection -->
                  <div class="color_selection">
                    <h5>Select Color:</h5>
                    <form id="colorSelectionForm" method="post">
                      <input type="radio" name="color" value="" onchange="document.getElementById('colorSelectionForm').submit();"
                         />
                      <label>All</label>
                      <?php
                      // Fetch product colors
                      $color_query = "SELECT * FROM product_colors WHERE product_id = ?";
                      $stmt = $con->prepare($color_query);
                      $stmt->bind_param("i", $product_id);
                      $stmt->execute();
                      $color_result = $stmt->get_result();

                      while ($color = $color_result->fetch_assoc()) :
                        $color_value = htmlspecialchars($color['color']);
                      ?>
                        <input type="radio" name="color" value="<?php echo $color_value; ?>"
                          onchange="document.getElementById('colorSelectionForm').submit();"
                          <?php if (isset($_POST['color']) && $_POST['color'] === $color_value) echo 'checked'; ?> />
                        <label><?php echo $color_value; ?></label>
                      <?php endwhile; ?>
                    </form>
                  </div>

                  <!-- Size Selection -->
                  <div class="size_selection">
                    <h5>Select Size:</h5>
                    <form id="sizeSelectionForm" method="post">
                      <?php
                      // Fetch product sizes
                      $size_query = "SELECT * FROM product_sizes WHERE product_id = {$product['product_id']}";
                      $size_result = $con->query($size_query);
                      while ($size = $size_result->fetch_assoc()) :
                        $size_value = htmlspecialchars($size['size']);
                      ?>
                        <input type="radio" name="size" value="<?php echo $size_value; ?>"
                          onchange="document.getElementById('addToCartForm').size.value = this.value;"
                          <?php if (isset($_POST['size']) && $_POST['size'] === $size_value) echo 'checked'; ?> />
                        <label><?php echo $size_value; ?></label>
                      <?php endwhile; ?>
                    </form>
                  </div>

                  <!-- Add to Cart Form -->
                  <form method="post" action="add_to_cart.php" style="margin-top: 60px;" id="addToCartForm">
                    <div class="cart_btns_group unordered_list mb-4">
                      <div class="quantity_form" style="margin-right: 60px;">
                        <button type="button" class="input_number_decrement">
                          <i class="fa fa-minus"></i>
                        </button>
                        <input class="input_number" type="number" name="quantity" value="1" min="1" />
                        <button type="button" class="input_number_increment">
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                      <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>" />
                      <input type="hidden" name="price" value="<?php echo $product['product_price']; ?>" />
                      <input type="hidden" name="color" value="<?php echo isset($_POST['color']) ? htmlspecialchars($_POST['color']) : ''; ?>" />
                      <input type="hidden" name="size" value="<?php echo isset($_POST['size']) ? htmlspecialchars($_POST['size']) : ''; ?>" />

                      <button type="submit" class="btn btn-primary" id="addToCartButton">
                        <span class="btn_text">Add To Cart</span>
                      </button>
                    </div>
                  </form>


                  <ul class="product_details_info_list unordered_list_block text-uppercase">
                    <li>
                      <?php
                      $cat_id = $product['cat_id'];
                      $sql_cat = "SELECT * FROM categories WHERE cat_id = $cat_id";
                      $cat_result = $con->query($sql_cat);
                      $cat = $cat_result->fetch_assoc();

                      $cat_id2 = $product['p_cat_id'];
                      $sql_cat2 = "SELECT * FROM product_categories WHERE p_cat_id = $cat_id2";
                      $cat_result2 = $con->query($sql_cat2);
                      $cat2 = $cat_result2->fetch_assoc();
                      ?>
                      <span>Categories: </span><a href="#!"><?php echo $cat['cat_title']; ?>,</a>
                      <a href="#!"><?php echo $cat2['p_cat_title']; ?></a>
                    </li>
                    <li>
                      <?php
                      $cat_id = $product['manufacturer_id'];
                      $sql_cat = "SELECT * FROM manufacturers WHERE manufacturer_id = $cat_id";
                      $cat_result = $con->query($sql_cat);
                      $cat = $cat_result->fetch_assoc();
                      ?>
                      <span>Tags: </span><a href="#!"><?php echo $cat['manufacturer_title']; ?></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="product_additional_info">
            <ul class="nav tab_nav style_3" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="active" data-bs-toggle="tab" data-bs-target="#tab_description" type="button" role="tab" aria-selected="true">
                  Description
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button data-bs-toggle="tab" data-bs-target="#tab_additional_information" type="button" role="tab" aria-selected="false">
                  Additional Information
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button data-bs-toggle="tab" data-bs-target="#tab_reviews" type="button" role="tab" aria-selected="false">
                  Reviews
                </button>
              </li>
            </ul>
            <div class="tab-content p-0 bg-transparent">
              <div class="tab-pane fade show active" id="tab_description" role="tabpanel">
                <h3 class="details_info_title">Product Description</h3>
                <?php echo $product['product_desc']; ?>
              </div>
              <div class="tab-pane fade" id="tab_additional_information" role="tabpanel">
                <?php echo $product['product_features']; ?>
              </div>
              <div class="tab-pane fade" id="tab_reviews" role="tabpanel">
                <?php
                $sql_reviews = "SELECT * FROM reviews WHERE product_id = $product_id";
                $reviews_result = $con->query($sql_reviews);

                // Check if there are any reviews
                if ($reviews_result->num_rows > 0):
                  // Loop through each review if available
                  while ($review = $reviews_result->fetch_assoc()): ?>
                    <div class="review">
                      <strong><?php echo htmlspecialchars($review['name']); ?></strong>
                      <span>(<?php echo $review['rating']; ?> Stars)</span>
                      <p><?php echo htmlspecialchars($review['comment']); ?></p>
                    </div>
                  <?php endwhile;
                else: ?>
                  <!-- Display a message if there are no reviews -->
                  <p>No reviews yet. Be the first to review this product!</p>
                <?php endif; ?>
              </div>

            </div>
          </div>
        </div>
      </section>

      <script>
        document.getElementById('addToCartForm').addEventListener('submit', function(event) {
          // Get selected color and size
          const color = document.querySelector('input[name="color"]:checked');
          const size = document.querySelector('input[name="size"]:checked');

          const selectedColor = document.querySelector('input[name="color"]:checked');
          const selectedSize = document.querySelector('input[name="size"]:checked');

          // Validate selections
          if (!color) {
            event.preventDefault(); // Prevent form submission
            swal("Oops!", "Please select a color.", "warning");
            // alert("Please select a color.");
            return;
          }

          if (!size) {
            event.preventDefault(); // Prevent form submission
            swal("Oops!", "Please select a size.", "warning");
            // alert("Please select a size.");
            return;
          }
        });
      </script>



      <section class="product_section section_space_lg">
        <div class="container">
          <div class="section_heading">
            <h2 class="heading_text mb-0 wow" data-splitting>
              Suggested Product
            </h2>
          </div>
          <div class="row" style="justify-content: center;">
            <?php
            // $product_id = $product['product_id'];

            // Fetch all suggested product IDs related to the current product
            $query12 = "SELECT * FROM product_suggestions WHERE product_id = $product_id";
            $result12 = mysqli_query($con, $query12);

            // Check if any suggested products exist
            if (mysqli_num_rows($result12) > 0) {
              // Loop through each suggested product
              while ($post12 = mysqli_fetch_assoc($result12)) {
                $suggested_product_id = $post12['suggested_product_id'];

                // Fetch product details for each suggested product
                $query = "SELECT * FROM products WHERE product_id = $suggested_product_id";
                $result = mysqli_query($con, $query);

                while ($post = mysqli_fetch_assoc($result)) {
                  // Fetch the first image associated with this product
                  $product_id10 = $post['product_id'];
                  $query10 = "SELECT * FROM product_images WHERE product_id = $product_id10 LIMIT 1";
                  $result10 = mysqli_query($con, $query10);
                  $post10 = mysqli_fetch_assoc($result10);
            ?>

                  <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product_item">
                      <ul class="badge_group unordered_list">
                        <li><span class="badge badge-primary"><?= $post['product_label'] ?></span></li>
                      </ul>
                      <a class="item_image" href="shop_details?id=<?= $post['product_id'] ?>">
                        <img src="admin_area/product_images/<?= $post10['image'] ?>" alt="ProMotors - Product Image" />
                      </a>
                      <div class="item_content">
                        <h3 class="item_title">
                          <a href="shop_details?id=<?= $post['product_id'] ?>"><?= $post['product_title'] ?></a>
                        </h3>
                        <div class="item_footer">
                          <div class="item_price">
                            <span class="sale_price">₹<?= $post['product_psp_price'] ?></span>
                            <del class="remove_price">₹<?= $post['product_price'] ?></del>
                          </div>
                          <a class="btn-link" href="shop_details?id=<?= $post['product_id'] ?>">
                            <span class="btn_icon"><i class="fa fa-angle-right"></i></span>
                            <span class="btn_text"><small>Shop Now</small><small>Shop Now</small></span>
                          </a>
                        </div>
                      </div>
                      <ul class="cart_btns_group unordered_list_block">
                        <?php if (isset($_SESSION['user_id'])): ?>
                          <li>
                            <a href="add_to_wishlist?product_id=<?= $post['product_id'] ?>"><i class="fa-light fa-heart"></i></a>
                          </li>
                        <?php endif; ?>
                        <li>
                          <a href="shop_details?id=<?= $post['product_id'] ?>"><i class="fa-light fa-eye"></i></a>
                        </li>
                      </ul>
                    </div>
                  </div>
            <?php
                }
              }
            } else {
              // Display a message if no suggested products are found
              echo '<div class="col-12"><p>No suggested products are available at the moment.</p></div>';
            }
            ?>
          </div>
        </div>
      </section>







      <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
        document.getElementById('addToCartButton').addEventListener('click', function() {
          const selectedColor = document.querySelector('input[name="color"]:checked');
          const selectedSize = document.querySelector('input[name="size"]:checked');

          if (!selectedColor || !selectedSize) {
            // Show SweetAlert if color or size is not selected
            Swal.fire({
              icon: 'warning',
              title: 'Selection Required',
              text: 'Please select both color and size before adding to cart.',
            });
          } else {
            // Submit the form if both selections are made
            document.getElementById('addToCartForm').submit();
          }
        });
      </script> -->


      <!-- <script>
        function changeColor(color, productId) {
          // Create a new FormData object
          const formData = new FormData();
          formData.append('color', color);
          formData.append('product_id', productId);

          // Send an AJAX request to the server to fetch images for the selected color
          fetch('get_image.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.text())
            .then(data => {
              // Update the image gallery with the new images
              document.getElementById('imageCarousel').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
        }
      </script> -->



      <section class="details_section shop_details section_space_lg">
        <div class="container">
          <div class="section_space_sm pt-0">
            <div class="row">
              <div class="tab-pane" id="tab_reviews" role="tabpanel">
                <div class="review_form">
                  <form id="review_form" action="submit_review.php?id=<?= $product_id ?>" method="POST">
                    <div class="form-group">
                      <label>Your Rating - <span id="rating_value">0</span></label>
                      <ul class="rating_star unordered_list">
                        <li>
                          <input type="radio" name="rating" value="1" id="star1" />
                          <label for="star1" class="star"><i class="fas fa-star"></i></label>
                        </li>
                        <li>
                          <input type="radio" name="rating" value="2" id="star2" />
                          <label for="star2" class="star"><i class="fas fa-star"></i></label>
                        </li>
                        <li>
                          <input type="radio" name="rating" value="3" id="star3" />
                          <label for="star3" class="star"><i class="fas fa-star"></i></label>
                        </li>
                        <li>
                          <input type="radio" name="rating" value="4" id="star4" />
                          <label for="star4" class="star"><i class="fas fa-star"></i></label>
                        </li>
                        <li>
                          <input type="radio" name="rating" value="5" id="star5" />
                          <label for="star5" class="star"><i class="fas fa-star"></i></label>
                        </li>
                      </ul>
                    </div>
                    <div class="form-group">
                      <label for="input_comment">Your Comment</label>
                      <textarea name="comment" class="form-control" id="input_comment" placeholder="Write Your Comment"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="input_name">Your Name</label>
                      <input type="text" name="name" class="form-control" id="input_name" placeholder="Enter Your Name">
                    </div>
                    <div class="form-group">
                      <label for="input_email">Your Email</label>
                      <input type="email" name="email" class="form-control" id="input_email" placeholder="Enter Your Email">
                    </div>
                    <button type="submit" class="btn btn-primary">
                      <span class="btn_text">Submit Review</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>




      <section class="product_section section_space_lg">
        <div class="container">
          <div class="section_heading">
            <h2 class="heading_text mb-0 wow" data-splitting>
              Other Products
            </h2>
          </div>
          <div class="row">
            <?php
            $query = "SELECT * FROM products LIMIT 8";
            $result = mysqli_query($con, $query);
            while ($post = mysqli_fetch_assoc($result)) : ?>
              <?php
              $product_id10 = $post['product_id'];
              $query10 = "SELECT * FROM product_images where product_id = $product_id10";
              $result10 = mysqli_query($con, $query10);
              $post10 = mysqli_fetch_assoc($result10);
              ?>
              <div class="col-lg-3 col-md-6 col-sm-6">
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
                    <!-- <a class="item_brand" href="#!"><?= $post['product_keywords'] ?></a> -->
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
                  </ul>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </section>
    </main>
    <?php
    include 'includes/footer.php';
    ?>
  </div>
  <?php
  include 'includes/script-links.php';
  ?>

  <script>
    // This script handles filling stars and displaying the selected rating.
    const stars = document.querySelectorAll('.rating_star input[type="radio"]');
    const ratingValueDisplay = document.getElementById('rating_value');

    stars.forEach(star => {
      star.addEventListener('click', () => {
        const rating = star.value;
        ratingValueDisplay.textContent = rating; // Update displayed rating

        // Set all stars to their correct states based on the selected rating
        stars.forEach(s => {
          const label = document.querySelector(`label[for="${s.id}"]`);
          if (s.value <= rating) {
            label.style.color = '#f5a623'; // Fill star
          } else {
            label.style.color = '#ccc'; // Unfill star
          }
        });
      });
    });

    // To handle hover effects and reset colors
    stars.forEach(star => {
      star.addEventListener('mouseover', () => {
        const rating = star.value;
        ratingValueDisplay.textContent = rating; // Update displayed rating on hover

        // Fill stars on hover
        stars.forEach(s => {
          const label = document.querySelector(`label[for="${s.id}"]`);
          if (s.value <= rating) {
            label.style.color = '#f5a623'; // Fill star on hover
          } else {
            label.style.color = '#ccc'; // Unfill star on hover
          }
        });
      });

      star.addEventListener('mouseout', () => {
        // Reset colors after hover
        stars.forEach(s => {
          const label = document.querySelector(`label[for="${s.id}"]`);
          if (s.checked) {
            label.style.color = '#f5a623'; // Keep filled stars
          } else {
            label.style.color = '#ccc'; // Reset unfilled stars
          }
        });
        // Reset displayed rating if no star is selected
        const selectedStar = Array.from(stars).find(s => s.checked);
        ratingValueDisplay.textContent = selectedStar ? selectedStar.value : '0';
      });
    });
  </script>

  <script>
    document.getElementById('review_form').addEventListener('submit', function(e) {
      e.preventDefault(); // Prevent form from submitting the default way
      const formData = new FormData(this);

      fetch(this.action, {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Thank you!',
              text: data.message,
              confirmButtonText: 'OK'
            }).then(() => {
              window.location.href = 'shop_details?id=<?= $product_id ?>'; // Redirect back to the product page
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.message,
              confirmButtonText: 'OK'
            });
          }
        })
        .catch(error => {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while submitting your review. Please try again later.',
            confirmButtonText: 'OK'
          });
        });
    });
  </script>

  <!-- SweetAlert JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</body>
<!-- Mirrored from html.merku.love/promotors/shop_details by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:06 GMT -->

</html>