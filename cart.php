<?php
// ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<!-- Mirrored from html.merku.love/promotors/cart by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:07 GMT -->

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width,initial-scale=1,shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Cart – ProMotors – Car Service & Detailing Template</title>
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
    <main class="page_content" style="margin-top: 140px;">
      <section
        class="page_banner"
        style="background-image: url('assets/images/shapes/tyre_print_3.svg')">
        <div class="container">
          <ul class="breadcrumb_nav unordered_list">
            <li><a href="index">Home</a></li>
            <li><a href="cart">Cart</a></li>
          </ul>
          <h1 class="page_title wow" data-splitting>Shopping Cart</h1>
        </div>
      </section>

      <section class="cart_section section_space_lg pb-0">
        <div class="container">
          <div class="section_heading">
            <h2 class="heading_text mb-0 wow" data-splitting>
              Shopping Cart -
              <?php
              require './includes/db.php';

              $user_id = $_SESSION['user_id'];
              $cart_query = "SELECT cart.*, products.product_title, products.product_id, products.shipping_charges FROM cart 
                               JOIN products ON cart.p_id = products.product_id 
                               WHERE cart.customer_login_id = '$user_id'";
              $cart_result = $con->query($cart_query);
              $cart_items = $cart_result->num_rows;
              echo $cart_items . ' Items';
              ?>
            </h2>
          </div>
          <div class="row">
            <div class="col-lg-9">
              <div class="cart_table">
                <ul class="table_head unordered_list">
                  <li>Product type</li>
                  <li>Color</li>
                  <li>Size</li>
                  <li>Price</li>
                  <li>QTY</li>
                  <li>Subtotal</li>
                  <li>Remove</li>
                </ul>

                <?php
                $total = 0; // Initialize total for all cart items
                $shipping_total = 0; // Initialize total for shipping charges

                if ($cart_items > 0):
                  while ($cart_row = $cart_result->fetch_assoc()):

                    $product_id = $cart_row['product_id'];
                    $query10 = "SELECT * FROM product_images WHERE product_id = $product_id";
                    $result10 = mysqli_query($con, $query10);
                    $post10 = mysqli_fetch_assoc($result10);

                    $product_title = $cart_row['product_title'];
                    $product_img = $post10['image'];
                    $product_color = $cart_row['color'];
                    $product_size = $cart_row['size'];
                    $product_price = $cart_row['p_price'];
                    $quantity = $cart_row['qty'];
                    $subtotal = $product_price * $quantity;
                    $shipping_charge = $cart_row['shipping_charges']; // Fetch shipping charges
                    $shipping_total += $shipping_charge; // Add to shipping total
                    $total += $subtotal; // Add to the total
                ?>

                    <ul class="unordered_list">
                      <li>
                        <div class="cart_product_item">
                          <div class="item_image">
                            <img src="./admin_area/product_images/<?php echo $product_img; ?>" alt="Product Image" />
                          </div>
                          <div class="item_content">
                            <h3 class="item_title"><?php echo $product_title; ?></h3>
                          </div>
                        </div>
                      </li>
                      <li>
                        <span class="title_text">Color</span>
                        <span class="price_text"><?php echo $product_color; ?></span>
                      </li>
                      <li>
                        <span class="title_text">Size</span>
                        <span class="price_text"><?php echo $product_size; ?></span>
                      </li>
                      <li>
                        <span class="title_text">Price</span>
                        <span class="price_text">₹<?php echo $product_price; ?></span>
                      </li>
                      <li>
                        <span class="title_text">QTY</span>
                        <div class="quantity_form">
                          <button class="input_number_decrement" data-product-id="<?php echo $cart_row['p_id']; ?>" data-action="decrease">
                            <i class="fa fa-minus"></i>
                          </button>
                          <input class="input_number" type="number" value="<?php echo $quantity; ?>" min="1" data-product-id="<?php echo $cart_row['p_id']; ?>" />
                          <button class="input_number_increment" data-product-id="<?php echo $cart_row['p_id']; ?>" data-action="increase">
                            <i class="fa fa-plus"></i>
                          </button>
                        </div>
                      </li>
                      <li>
                        <span class="title_text">Subtotal</span>
                        <span class="price_text subtotal" data-product-id="<?php echo $cart_row['p_id']; ?>">₹<?php echo $subtotal; ?></span>
                      </li>
                      <li>
                        <span class="title_text">Remove</span>
                        <button class="remove_btn" data-product-id="<?php echo $cart_row['p_id']; ?>">
                          <i class="fa-regular fa-trash-can"></i>
                        </button>
                      </li>
                    </ul>

                  <?php endwhile; ?>
                <?php else: ?>
                  <p>Your cart is currently empty.</p>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="order_summary">
                <h3 class="area_title">Order Summary</h3>
                <ul class="unordered_list_block">
                  <li><span>Subtotal</span> <span>₹<?php echo $total; ?></span></li>
                  <li><span>Shipping Charges</span> <span>₹<?php echo $shipping_total; ?></span></li>
                  <li><span>Total</span> <span>₹<?php echo number_format($total + $shipping_total, 2); ?></span></li>
                </ul>
                <a class="btn btn-primary w-100" href="checkout"><span class="btn_text">Checkout</span></a>
                <p class="mb-0">
                  *Taxes and fees are subject to change which may result in a change in your total price.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>



      <!-- <section class="cart_section section_space_lg pb-0">
        <div class="container">
          <div class="section_heading">
            <h2 class="heading_text mb-0 wow" data-splitting>
              Shopping Cart - 2 Items
            </h2>
          </div>
          <div class="row">
            <div class="col-lg-9">
              <div class="cart_table">
                <ul class="table_head unordered_list">
                  <li>Product type</li>
                  <li>Price</li>
                  <li>QTY</li>
                  <li>Subtotal</li>
                  <li>Remove</li>
                </ul>
                <ul class="unordered_list">
                  <li>
                    <div class="cart_product_item">
                      <div class="item_image">
                        <img
                          src="assets/images/products/product_img_1.png"
                          alt="ProMotors - Product Image" />
                      </div>
                      <div class="item_content">
                        <h3 class="item_title">Silent Bloc Ø10-75mm</h3>
                        <a class="item_brand" href="#!">ASDER</a>
                      </div>
                    </div>
                  </li>
                  <li>
                    <span class="title_text">Price</span>
                    <span class="price_text">$12.99</span>
                  </li>
                  <li>
                    <span class="title_text">QTY</span>
                    <div class="quantity_form">
                      <button type="button" class="input_number_decrement">
                        <i class="fa-regular fa-minus"></i>
                      </button>
                      <input class="input_number" type="text" value="1" />
                      <button type="button" class="input_number_increment">
                        <i class="fa-regular fa-plus"></i>
                      </button>
                    </div>
                  </li>
                  <li>
                    <span class="title_text">Subtotal</span>
                    <span class="price_text">$12.99</span>
                  </li>
                  <li>
                    <span class="title_text">Remove</span>
                    <button type="button" class="remove_btn">
                      <i class="fa-regular fa-trash-can"></i>
                    </button>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="order_summary">
                <h3 class="area_title">Order Summary</h3>
                <ul class="unordered_list_block">
                  <li><span>Subtotal</span> <span>$59.99</span></li>
                  <li><span>Pick Up</span> <span>FREE</span></li>
                  <li><span>HST</span> <span>$12.45</span></li>
                  <li><span>Total</span> <span>$95.44</span></li>
                </ul>
                <a class="btn btn-primary w-100" href="#!"><span class="btn_text">Checkout</span></a>
                <p class="mb-0">
                  *Taxes and fees are subject to change which may result in a
                  change in your total price.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section> -->

      <!-- <section class="product_section section_space_lg">
        <div class="container">
          <div class="section_heading">
            <h2 class="heading_text mb-0 wow" data-splitting>
              Your Recently Viewed Items
            </h2>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="product_item">
                <a class="item_image" href="shop_details"><img
                    src="assets/images/products/product_img_1.png"
                    alt="ProMotors - Product Image" /></a>
                <div class="item_content">
                  <h3 class="item_title">
                    <a href="shop_details">Silent Bloc Ø10-75mm</a>
                  </h3>
                  <a class="item_brand" href="#!">WEROO</a>
                  <div class="item_footer">
                    <div class="item_price">
                      <span class="sale_price">$49</span>
                    </div>
                    <a class="btn-link" href="shop_details"><span class="btn_icon"><i class="fa-regular fa-angle-right"></i></span>
                      <span class="btn_text"><small>Add To Cart</small>
                        <small>Add To Cart</small></span></a>
                  </div>
                </div>
                <ul class="cart_btns_group unordered_list_block">
                  <li>
                    <a href="#!"><i class="fa-light fa-heart"></i></a>
                  </li>
                  <li>
                    <a href="#!"><i class="fa-light fa-eye"></i></a>
                  </li>
                  <li>
                    <a href="#!"><i class="fa-light fa-code-compare"></i></a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="product_item">
                <ul class="badge_group unordered_list">
                  <li><span class="badge badge-danger">SALE</span></li>
                </ul>
                <a class="item_image" href="shop_details"><img
                    src="assets/images/products/product_img_2.png"
                    alt="ProMotors - Product Image" /></a>
                <div class="item_content">
                  <h3 class="item_title">
                    <a href="shop_details">Brake Discs Front 282mm 4x100</a>
                  </h3>
                  <a class="item_brand" href="#!">ASCY</a>
                  <div class="item_footer">
                    <div class="item_price">
                      <span class="sale_price">$69</span>
                      <del class="remove_price">$76</del>
                    </div>
                    <a class="btn-link" href="shop_details"><span class="btn_icon"><i class="fa-regular fa-angle-right"></i></span>
                      <span class="btn_text"><small>Add To Cart</small>
                        <small>Add To Cart</small></span></a>
                  </div>
                </div>
                <ul class="cart_btns_group unordered_list_block">
                  <li>
                    <a href="#!"><i class="fa-light fa-heart"></i></a>
                  </li>
                  <li>
                    <a href="#!"><i class="fa-light fa-eye"></i></a>
                  </li>
                  <li>
                    <a href="#!"><i class="fa-light fa-code-compare"></i></a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="product_item">
                <a class="item_image" href="shop_details"><img
                    src="assets/images/products/product_img_8.png"
                    alt="ProMotors - Product Image" /></a>
                <div class="item_content">
                  <h3 class="item_title">
                    <a href="shop_details">Oil Filter 12345</a>
                  </h3>
                  <a class="item_brand" href="#!">QWER</a>
                  <div class="item_footer">
                    <div class="item_price">
                      <span class="sale_price">$49</span>
                    </div>
                    <a class="btn-link" href="shop_details"><span class="btn_icon"><i class="fa-regular fa-angle-right"></i></span>
                      <span class="btn_text"><small>Add To Cart</small>
                        <small>Add To Cart</small></span></a>
                  </div>
                </div>
                <ul class="cart_btns_group unordered_list_block">
                  <li>
                    <a href="#!"><i class="fa-light fa-heart"></i></a>
                  </li>
                  <li>
                    <a href="#!"><i class="fa-light fa-eye"></i></a>
                  </li>
                  <li>
                    <a href="#!"><i class="fa-light fa-code-compare"></i></a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="product_item">
                <ul class="badge_group unordered_list">
                  <li><span class="badge badge-primary">NEW</span></li>
                </ul>
                <a class="item_image" href="shop_details"><img
                    src="assets/images/products/product_img_4.png"
                    alt="ProMotors - Product Image" /></a>
                <div class="item_content">
                  <h3 class="item_title">
                    <a href="shop_details">Oil Filter DF 15A/20A</a>
                  </h3>
                  <a class="item_brand" href="#!">GRIP</a>
                  <div class="item_footer">
                    <div class="item_price">
                      <span class="sale_price">$19.90</span>
                    </div>
                    <a class="btn-link" href="shop_details"><span class="btn_icon"><i class="fa-regular fa-angle-right"></i></span>
                      <span class="btn_text"><small>Add To Cart</small>
                        <small>Add To Cart</small></span></a>
                  </div>
                </div>
                <ul class="cart_btns_group unordered_list_block">
                  <li>
                    <a href="#!"><i class="fa-light fa-heart"></i></a>
                  </li>
                  <li>
                    <a href="#!"><i class="fa-light fa-eye"></i></a>
                  </li>
                  <li>
                    <a href="#!"><i class="fa-light fa-code-compare"></i></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section> -->

      <section class="product_section section_space_lg">
        <div class="container">
          <div class="section_heading">
            <h2 class="heading_text mb-0 wow" data-splitting>
              Other Products
            </h2>
          </div>
          <div class="row">
            <?php
            $query = "SELECT * FROM products LIMIT 4";
            $result = mysqli_query($con, $query);
            while ($post = mysqli_fetch_assoc($result)) : ?>
              <?php
              $product_id = $post['product_id'];
              $query10 = "SELECT * FROM product_images where product_id = $product_id";
              $result10 = mysqli_query($con, $query10);
              $post10 = mysqli_fetch_assoc($result10);
              ?>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="product_item">
                  <ul class="badge_group unordered_list">
                    <li><span class="badge badge-primary"><?= $post['product_label'] ?></span></li>
                  </ul>
                  <a class="item_image" href="shop_details"><img
                      src="admin_area/product_images/<?= $post10['image'] ?>"
                      alt="ProMotors - Product Image" /></a>
                  <div class="item_content">
                    <h3 class="item_title">
                      <a href="shop_details"><?= $post['product_title'] ?></a>
                    </h3>
                    <a class="item_brand" href="#!"><?= $post['product_keywords'] ?></a>
                    <div class="item_footer">
                      <div class="item_price">
                        <span class="sale_price">₹<?= $post['product_psp_price'] ?></span>
                        <del class="remove_price">₹<?= $post['product_price'] ?></del>
                      </div>
                      <a class="btn-link" href="shop_details?id=<?= $post['product_id'] ?>"><span class="btn_icon"><i class="fa-regular fa-angle-right"></i></span>
                        <span class="btn_text"><small>Add To Cart</small>
                          <small>Add To Cart</small></span></a>
                    </div>
                  </div>
                  <ul class="cart_btns_group unordered_list_block">
                    <li>
                      <a href="#!"><i class="fa-light fa-heart"></i></a>
                    </li>
                    <li>
                      <a href="#!"><i class="fa-light fa-eye"></i></a>
                    </li>
                    <li>
                      <a href="#!"><i class="fa-light fa-code-compare"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            <?php endwhile; ?>


            <!-- <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="product_item">
                <a class="item_image" href="shop_details"><img
                    src="assets/images/products/product_img_1.png"
                    alt="ProMotors - Product Image" /></a>
                <div class="item_content">
                  <h3 class="item_title">
                    <a href="shop_details">Silent Bloc Ø10-75mm</a>
                  </h3>
                  <a class="item_brand" href="#!">WEROO</a>
                  <div class="item_footer">
                    <div class="item_price">
                      <span class="sale_price">$49</span>
                    </div>
                    <a class="btn-link" href="shop_details"><span class="btn_icon"><i class="fa-regular fa-angle-right"></i></span>
                      <span class="btn_text"><small>Add To Cart</small>
                        <small>Add To Cart</small></span></a>
                  </div>
                </div>
                <ul class="cart_btns_group unordered_list_block">
                  <li>
                    <a href="#!"><i class="fa-light fa-heart"></i></a>
                  </li>
                  <li>
                    <a href="#!"><i class="fa-light fa-eye"></i></a>
                  </li>
                  <li>
                    <a href="#!"><i class="fa-light fa-code-compare"></i></a>
                  </li>
                </ul>
              </div>
            </div> -->


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


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- <script>
    document.querySelectorAll('.increase-qty').forEach(button => {
      button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const quantityInput = document.getElementById(`qty-${productId}`);
        quantityInput.value = parseInt(quantityInput.value) + 1;
        console.log(quantityInput.value);

        // Call function to update backend
        updateProductQuantity(productId, quantityInput.value);
      });
    });

    document.querySelectorAll('.decrease-qty').forEach(button => {
      button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const quantityInput = document.getElementById(`qty-${productId}`);
        if (parseInt(quantityInput.value) > 1) {
          quantityInput.value = parseInt(quantityInput.value) - 1;

          // Call function to update backend
          updateProductQuantity(productId, quantityInput.value);
        }
      });
    });

    function updateProductQuantity(productId, quantity) {
      const data = {
        productId: productId,
        quantity: quantity
      };

      fetch('update_quantity', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log('Quantity updated successfully.');
          } else {
            console.error('Error updating quantity:', data.error);
          }
        })
        .catch(error => console.error('Error:', error));
    }
  </script> -->

  <script>
    $(document).ready(function() {
      // Update quantity using AJAX
      $(document).ready(function() {
        $('.quantity_form button').on('click', function() {
          const productId = $(this).data('product-id');
          const action = $(this).data('action');

          $.ajax({
            url: 'update_cart',
            type: 'POST',
            data: {
              product_id: productId,
              action: action
            },
            success: function(response) {
              const data = JSON.parse(response);

              // Update the cart dynamically with the new quantity and totals
              $(`.subtotal[data-product-id="${productId}"]`).text('₹' + data.subtotal);
              $('.order_summary .unordered_list_block span:contains("Subtotal")').next().text('₹' + data.total);
              $('.order_summary .unordered_list_block span:contains("HST (18%)")').next().text('₹' + data.tax);
              $('.order_summary .unordered_list_block span:contains("Total")').next().text('₹' + data.grand_total);

              // Show SweetAlert notification with blur effect and reload page on confirmation
              Swal.fire({
                title: 'Quantity Updated',
                text: 'The product quantity has been updated successfully!',
                icon: 'success',
                confirmButtonText: 'OK',
              }).then(() => {
                // Reload the page after the user clicks 'OK'
                location.reload();
              });
            },
            error: function(xhr, status, error) {
              // Handle errors with a SweetAlert notification
              Swal.fire({
                title: 'Error',
                text: 'There was an error updating the quantity. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK',
              });
            }
          });
        });
      });



      // Remove item using AJAX
      $('.remove_btn').on('click', function() {
        const productId = $(this).data('product-id');

        $.ajax({
          url: 'remove_from_cart',
          type: 'POST',
          data: {
            product_id: productId
          },
          success: function(response) {
            Swal.fire('Cart item delete', 'Cart item deleted successfully.', 'success')
              .then(() => {
                location.reload();
              });
          }
        });
      });
    });
  </script>



</body>
<!-- Mirrored from html.merku.love/promotors/cart by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:07 GMT -->

</html>