<?php
include './includes/db.php';

$query_foot1 = "SELECT * FROM manufacturers where manufacturer_top = 'yes' LIMIT 14";
$result_foot1 = mysqli_query($con, $query_foot1);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .footer_social_media {
    margin-top: 20px;
  }

  .social_media_list {
    list-style: none;
    padding: 0;
    display: flex;
    gap: 20px;
  }

  .social_media_list li {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .social_media_list li a {
    font-size: 25px;
    color: #555;
    text-decoration: none;
    transition: color 0.3s;
  }

  .social_media_list li a:hover {
    color: #d16527;
    /* Change to the desired color on hover */
  }
</style>

<footer class="site_footer">
  <div class="footer_content_area section_space_lg bg_gray_dark">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="footer_about pe-lg-5">
            <div class="site_logo">
              <a class="site_link" href="#"><img
                  class="dark_theme_logo"
                  src="./Moto Dresser/Moto_dresser.png" style="margin-left: 20px;"
                  alt="Site Logo – ProMotors – Car Service & Detailing Template" />
                <img
                  class="light_theme_logo"
                  src="./Moto Dresser/Moto_dresser.png" style="margin-left: 20px;"
                  alt="Site Logo – ProMotors – Car Service & Detailing Template" /></a>
            </div>
            <p>
              Moto Dresser: Premium motorcycle gear and accessories for riders, offering quality and style.
            </p>
            <div class="footer_hotline">
              <span>Support center 24/7</span>
              <a class="hotline_number" href="tel:919669196692">+91 9669196692</a>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
          <div class="info_list_wrap">
            <h3 class="list_title">Our Pages</h3>
            <ul class="info_list unordered_list_block text-uppercase">
              <li>
                <a href="index"><span class="info_icon"><img
                      src="assets/images/icons/icon_square.svg"
                      alt="ProMotors - Icon Square" /> </span><span class="info_text">Home</span></a>
              </li>
              <li>
                <a href="shop"><span class="info_icon"><img
                      src="assets/images/icons/icon_square.svg"
                      alt="ProMotors - Icon Square" /> </span><span class="info_text">Shop</span></a>
              </li>
              <li>
                <a href="blog"><span class="info_icon"><img
                      src="assets/images/icons/icon_square.svg"
                      alt="ProMotors - Icon Square" /> </span><span class="info_text">Blog</span></a>
              </li>
              <li>
                <a href="contact"><span class="info_icon"><img
                      src="assets/images/icons/icon_square.svg"
                      alt="ProMotors - Icon Square" /> </span><span class="info_text">Contact Us</span></a>
              </li>
              <!-- <li>
                <a href="#!"><span class="info_icon"><img
                      src="assets/images/icons/icon_square.svg"
                      alt="ProMotors - Icon Square" /> </span><span class="info_text">FAQ</span></a>
              </li> -->
              <li>
                <a href="about"><span class="info_icon"><img
                      src="assets/images/icons/icon_square.svg"
                      alt="ProMotors - Icon Square" /> </span><span class="info_text">About Us</span></a>
              </li>
              <li>
                <a href="return"><span class="info_icon"><img
                      src="assets/images/icons/icon_square.svg"
                      alt="ProMotors - Icon Square" /> </span><span class="info_text">Return/Exchange</span></a>
              </li>
              <li>
                <a href="refund_policy"><span class="info_icon"><img
                      src="assets/images/icons/icon_square.svg"
                      alt="ProMotors - Icon Square" /> </span><span class="info_text">Refund Policy</span></a>
              </li>
              <li>
                <a href="t_and_c"><span class="info_icon"><img
                      src="assets/images/icons/icon_square.svg"
                      alt="ProMotors - Icon Square" /> </span><span class="info_text">Terms and Condition</span></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="info_list_wrap">
            <h3 class="list_title">Brand</h3>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <ul class="info_list unordered_list_block text-uppercase" style="columns: 2; padding: 10px; width: 400px;">

                  <?php while ($post = mysqli_fetch_assoc($result_foot1)) : ?>
                    <li><a href="shop_brands?id=<?= $post['manufacturer_id'] ?>"><span class="info_icon"><img
                            src="assets/images/icons/icon_square.svg"
                            alt="ProMotors - Icon Square" /> </span><span class="info_text"><?= $post['manufacturer_title'] ?></span></a></li>
                  <?php endwhile; ?>

                  <!-- <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">Axor</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">smk</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">bison</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">bega</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">Hjg</span></a>
                  </li>

                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">studds</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">moto tag</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">rows one</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">rohgear</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">Powershift</span></a>
                  </li> -->
                </ul>
              </div>

              <!-- <div class="col-md-6 col-sm-6">

                <ul class="info_list unordered_list_block text-uppercase">
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">studds</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">moto tag</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">rows one</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">rohgear</span></a>
                  </li>
                  <li>
                    <a href="#"><span class="info_icon"><img
                          src="assets/images/icons/icon_square.svg"
                          alt="ProMotors - Icon Square" /> </span><span class="info_text">Powershift</span></a>
                  </li>
                </ul>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="footer_subscribe_form">
            <h3 class="list_title">Subscribe</h3>
            <div class="form-group">
              <label for="input_email">Your Email</label>
              <input
                type="email"
                name="email"
                class="form-control"
                id="input_email"
                placeholder="Enter Your Email Address" required />
            </div>
            <button type="button" class="btn btn-primary" onclick="subscribeUser()">
              <span class="btn_text">Subscribe</span>
            </button>
            <div id="subscription_message"></div>
          </div>

          <!-- Social Media Icons Section -->
          <div class="footer_social_media">
            <ul class="social_media_list">
              <li>Social Links - </li>
              <li>
                <a href="https://www.instagram.com/motodresser/profilecard/?igsh=MWN6YW1tYWF4dm95aA==" target="_blank">
                  <i class="fa fa-instagram"></i>
                </a>
              </li>
              <li>
                <a href="https://youtube.com/@motodresser?si=AHWs_yffWQ2qYaH6" target="_blank">
                  <i class="fa fa-youtube"></i>
                </a>
              </li>
              <li>
                <a href="https://www.facebook.com/share/vAGuqUY2EfymoCZ7/?mibextid=LQQJ4d" target="_blank">
                  <i class="fa fa-facebook"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="copyright_widget">
    <div class="container">
      <p class="copyright_text text-center mb-0">
        <a href="https://sarovi.tech/">Sarovi Tech</a> ©
        <b>MOTODRESSER</b> All rights reserved Copyrights 2024
      </p>
    </div>
  </div>
</footer>

<script>
  function subscribeUser() {
    const email = document.getElementById('input_email').value;

    if (email) {
      // Display a processing message with SweetAlert
      Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we process your subscription.',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Make the AJAX request to the server
      $.ajax({
        url: 'subscribe', // Adjust the URL if necessary
        type: 'POST',
        data: {
          email: email
        },
        success: function(response) {
          const res = JSON.parse(response);

          if (res.success) {
            // Show success message using SweetAlert
            Swal.fire({
              title: 'Subscribed!',
              text: 'You have been subscribed successfully!',
              icon: 'success',
              confirmButtonText: 'OK'
            });
          } else {
            // Show error message using SweetAlert
            Swal.fire({
              title: 'Subscription Failed',
              text: res.message,
              icon: 'error',
              confirmButtonText: 'Try Again'
            });
          }
        },
        error: function() {
          // Show error message using SweetAlert if the AJAX request fails
          Swal.fire({
            title: 'Error!',
            text: 'An error occurred. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      });
    } else {
      // Show a warning if the email input is empty
      Swal.fire({
        title: 'Invalid Input!',
        text: 'Please enter a valid email address.',
        icon: 'warning',
        confirmButtonText: 'OK'
      });
    }
  }
</script>