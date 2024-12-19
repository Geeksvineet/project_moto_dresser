<?php
ob_start();
session_start();
include("includes/db.php"); // Database connection
// require './phpmailer_smtp/smtp/PHPMailerAutoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = mysqli_real_escape_string($con, $_POST['name']);
  $phone = mysqli_real_escape_string($con, $_POST['phone']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $response = [];

  $query = "SELECT * FROM customer_login WHERE email = '$email'";
  $result = mysqli_query($con, $query);

  if (mysqli_num_rows($result) > 0) {
    $response['success'] = false;
    $response['message'] = 'Email already registered. Please use another email.';
  } else {
    $insert_query = "INSERT INTO customer_login (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$password')";
    if (mysqli_query($con, $insert_query)) {
      $response['success'] = true;
      $response['message'] = 'User registered successfully.';
    } else {
      $response['success'] = false;
      $response['message'] = 'Registration failed. Please try again.';
    }
  }

  echo json_encode($response);
  exit();
}

?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<!-- Mirrored from html.merku.love/promotors/team by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:10 GMT -->

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width,initial-scale=1,shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>
    Signup
  </title>
  <!-- <link rel="stylesheet" href="./Signup/Signup.css"> -->
  <?php
  include 'includes/head-links.php';
  ?>

  <style>
    .section {
      background-image: url('https://imgd.aeplcdn.com/1280x720/n/cw/ec/103795/yzf-r15-left-front-three-quarter-5.jpeg?isig=0&q=100');
      background-position: left;
      background-repeat: no-repeat;
      background-size: cover;
      padding: 200px 0 200px;
    }

    .container2 {
      width: 400px;
      max-width: 500px;
      margin-left: 200px;
      /* background-color: #fff; */
      background: transparent;
      backdrop-filter: blur(20px);
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      padding: 20px;
      border-radius: 10px;
    }

    .signup-box {
      text-align: center;
    }

    .signup-box h2 {
      margin-bottom: 30px;
      font-size: 24px;
    }

    /* Input Box Styling */
    .input-box {
      position: relative;
      margin-bottom: 30px;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
    }

    .input-box input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid black;
      border-radius: 5px;
      outline: none;
      transition: 0.3s ease;
      background-color: transparent;
      color: black;
    }

    .input-box label {
      position: absolute;
      top: 12px;
      left: 15px;
      font-size: 16px;
      color: black;
      transition: 0.3s ease;
      pointer-events: none;
    }

    .input-box input:focus~label,
    .input-box input:not(:placeholder-shown)~label {
      top: -20px;
      left: 10px;
      font-size: 12px;
      color: #333;
    }

    .input-box input:focus {
      border-color: #333;
    }

    /* Password Strength Pie Chart */
    .password-strength-container {
      position: relative;
    }

    .password-strength-meter {
      position: absolute;
      top: 10px;
      right: 10px;
      width: 90px;
      height: 30px;
      border-radius: 8px;
      background-color: #ddd;
      /* clip-path: circle(50%); */
    }

    /* Cross and Tick icons */
    .input-box .status-icon {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 20px;
      display: none;
    }

    .input-box .status-icon.active {
      display: block;
    }

    /* Buttons and Links */
    .buttonn {
      width: 100%;
      padding: 10px;
      background-color: #333;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .buttonn:hover {
      background-color: #555;
    }

    .login-link {
      margin-top: 20px;
    }

    .login-link a {
      text-decoration: none;
      color: #333;
    }

    /* Icons */
    .fa-check {
      color: blue;
    }

    .fa-times {
      color: red;
    }

    @media screen and (max-width:768px) {
      section {

        padding: 20px;
        margin-top: 35% !important;


      }

      .container2 {

        margin-left: 0px;
        margin-top: 20%;

      }

    }
  </style>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
      <section class="section">
        <div class="container2">
          <div class="signup-box">
            <h2>Sign Up</h2>
            <form id="signupForm" onsubmit="return validateForm()">
              <div class="input-box">
                <input type="text" name="name" id="name" required placeholder=" ">
                <label for="name">Full Name</label>
              </div>
              <div class="input-box">
                <input type="text" name="phone" id="phone" required placeholder=" " maxlength="10" pattern="\d{10}">
                <label for="phone">Phone</label>
              </div>

              <div id="recaptcha-container"></div>
              <button type="button" onclick="sendOTP()" class="buttonn">Send OTP</button>
              <div class="input-box">
                <input type="text" id="otp" required placeholder=" ">
                <label for="otp">Enter OTP</label>
              </div>

              <div class="input-box">
                <input type="email" name="email" id="email" required placeholder=" ">
                <label for="email">Email</label>
              </div>
              <div class="input-box">
                <input id="password" type="password" name="password" required placeholder=" ">
                <label for="password">Password</label>
                <span class="toggle-password" onclick="togglePasswordVisibility('password', 'togglePasswordIcon')">
                  <i id="togglePasswordIcon" class="fas fa-eye"></i>
                </span>
              </div>
              <div class="input-box">
                <input type="password" id="confirm-password" required placeholder=" ">
                <label for="confirm-password">Confirm Password</label>
                <span class="toggle-password" onclick="togglePasswordVisibility('confirm-password', 'toggleConfirmPasswordIcon')">
                  <i id="toggleConfirmPasswordIcon" class="fas fa-eye"></i>
                </span>
              </div>
              <button type="submit" class="buttonn">Sign Up</button>
              <div class="login-link">
                <p>Already have an account? <a href="./Login">Login</a></p>
              </div>
            </form>
          </div>
        </div>
      </section>
    </main>


    <script>
      function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthMeter = document.getElementById('password-strength');
        const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;

        if (strongPasswordPattern.test(password)) {
          strengthMeter.textContent = 'Strong';
          strengthMeter.style.color = 'black';
          strengthMeter.style.backgroundColor = 'green';
        } else if (password.length >= 6) {
          strengthMeter.textContent = 'Weak';
          strengthMeter.style.color = 'black';
          strengthMeter.style.backgroundColor = 'orange';
        } else {
          strengthMeter.textContent = 'Very Weak';
          strengthMeter.style.color = 'black';
          strengthMeter.style.backgroundColor = 'red';
        }
      }

      function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const checkIcon = document.getElementById('check-icon');
        const crossIcon = document.getElementById('cross-icon');

        if (password === confirmPassword) {
          checkIcon.style.display = 'flex';
          crossIcon.style.display = 'none';
        } else {
          checkIcon.style.display = 'none';
          crossIcon.style.display = 'flex';
        }
      }

      function validateForm() {
        const phone = document.getElementById('phone').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        // Phone validation: Ensure 10 digits only
        const phonePattern = /^\d{10}$/;
        if (!phonePattern.test(phone)) {
          Swal.fire({
            icon: 'error',
            title: 'Invalid Phone Number',
            text: 'Phone number must be exactly 10 digits.',
          });
          return false;
        }

        // Email validation: This is handled by the "email" type but you can add extra checks if needed.
        if (email === '') {
          Swal.fire({
            icon: 'error',
            title: 'Email Required',
            text: 'Please enter a valid email address.',
          });
          return false;
        }

        // Password validation: Minimum 6 characters, at least 1 uppercase, 1 lowercase, 1 number, 1 special character
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
        if (!passwordPattern.test(password)) {
          Swal.fire({
            icon: 'error',
            title: 'Weak Password',
            text: 'Password must be at least 6 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.',
          });
          return false;
        }

        // Confirm password validation: Ensure passwords match
        if (password !== confirmPassword) {
          Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'Passwords do not match.',
          });
          return false;
        }

        // Proceed with AJAX request
        submitForm();
        return false; // Prevent default form submission
      }
    </script>

    <script src="https://www.gstatic.com/firebasejs/9.x.x/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.x.x/firebase-auth.js"></script>
    <script>
      // Initialize Firebase
      const firebaseConfig = {
        apiKey: "AIzaSyDjREJR_gW7yYtyAr1XIcu0rtxPoaNbllA",
        authDomain: "vinufirstfirebasepro1.firebaseapp.com",
        projectId: "vinufirstfirebasepro1",
        storageBucket: "vinufirstfirebasepro1.appspot.com",
        messagingSenderId: "427196152043",
        appId: "1:427196152043:web:dd69e0ac2015d31797e6ae",
        measurementId: "G-WFQJ44F4ZP"
      };

      // Initialize Firebase
      const app = firebase.initializeApp(firebaseConfig);
      const auth = firebase.auth();

      // RecaptchaVerifier initialization
      window.onload = function() {
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
          'size': 'invisible',
          'callback': function(response) {
            // reCAPTCHA solved, allow send OTP
            sendOTP();
          },
          'expired-callback': function() {
            alert("Recaptcha expired. Please try again.");
          }
        });
        window.recaptchaVerifier.render().then(function(widgetId) {
          window.recaptchaWidgetId = widgetId; // Store the widget ID for future reference
        });
      };

      function sendOTP() {
        const phone = document.getElementById('phone').value.trim();
        if (!phone) {
          alert("Please enter your phone number before requesting an OTP.");
          return;
        }

        const phoneNumber = `+91${phone}`; // Replace +91 with your country code
        const appVerifier = window.recaptchaVerifier;

        auth.signInWithPhoneNumber(phoneNumber, appVerifier)
          .then((confirmationResult) => {
            window.confirmationResult = confirmationResult;
            alert("OTP Sent! Please check your phone.");
          })
          .catch((error) => {
            alert("Error sending OTP: " + error.message);
          });
      }

      function verifyOTP() {
        const otp = document.getElementById('otp').value;
        if (!otp) {
          alert("Please enter the OTP received on your phone.");
          return;
        }

        window.confirmationResult.confirm(otp)
          .then((result) => {
            const user = result.user;
            alert("Phone verified successfully!");
            // Proceed with submitting the form
            submitForm();
          })
          .catch((error) => {
            alert("Invalid OTP: " + error.message);
          });
      }

      function submitForm() {
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // AJAX request to submit the signup form
        $.ajax({
          url: 'Signup-page.php',
          type: 'POST',
          data: {
            name: name,
            phone: phone,
            email: email,
            password: password
          },
          success: function(response) {
            var res = JSON.parse(response);
            if (res.success) {
              alert("Registration Successful!");
              window.location.href = 'Login-page'; // Redirect to login page
            } else {
              alert("Registration Failed: " + res.message);
            }
          },
          error: function() {
            alert("An error occurred while processing your request.");
          }
        });
      }

      function validateForm() {
        const confirmPassword = document.getElementById('confirm-password').value;
        if (confirmPassword) {
          verifyOTP(); // Verify OTP before submitting the form
        }
        return false; // Prevent default form submission
      }

      function togglePasswordVisibility(passwordFieldId, iconId) {
        const passwordField = document.getElementById(passwordFieldId);
        const icon = document.getElementById(iconId);
        if (passwordField.type === "password") {
          passwordField.type = "text";
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          passwordField.type = "password";
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      }
    </script>

  </div>
  <?php
  include 'includes/footer.php';
  ?>
  </div>
  <?php
  include 'includes/script-links.php';
  ?>

</body>
<!-- Mirrored from html.merku.love/promotors/team by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:10 GMT -->

</html>