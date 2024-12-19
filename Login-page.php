<?php
session_start();
include './includes/db.php'; // Include your database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the request is an AJAX POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Prepare the SQL query to get the user by email
  $sql = "SELECT * FROM customer_login WHERE email = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // Prepare a response array
  $response = [];

  // Check if a user with the provided email exists
  if ($result && mysqli_num_rows($result) == 1) {
    // Fetch user data
    $user = mysqli_fetch_assoc($result);

    // Verify the provided password against the hashed password in the database
    if (password_verify($password, $user['password'])) {
      // Set session variables for the logged-in user
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];

      // Successful login
      $response['success'] = true;
    } else {
      // Incorrect password
      $response['success'] = false;
      $response['message'] = 'Invalid email or password. Please try again.';
    }
  } else {
    // No user found with the provided email
    $response['success'] = false;
    $response['message'] = 'Invalid email or password. Please try again.';
  }

  // Return JSON response
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
    Login
  </title>
  <!-- <link rel="stylesheet" href="./Login/Login.css"> -->
  <?php
  include 'includes/head-links.php';
  ?>

  <script src="https://accounts.google.com/gsi/client" async defer></script>

  <style>
    .section {
      background-image: url('https://imgd.aeplcdn.com/1280x720/n/cw/ec/103795/yzf-r15-left-front-three-quarter-5.jpeg?isig=0&q=100');
      background-position: left;
      background-repeat: no-repeat;
      background-size: cover;
      padding: 100px 0 100px;
    }

    .container2 {
      width: 400px;
      max-width: 500px;
      margin-left: 140px;
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
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background-color: #ddd;
      clip-path: circle(50%);
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
      .container2 {

        margin-left: 0px;
      }

      .section {
        padding: 20px;
        margin-top: 35% !important;
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


    <main class="page_content" style="margin-top: 140px;">
      <section class="section">
        <div class="container2">
          <div class="signup-box">
            <h2>Login</h2>
            <form id="loginForm">
              <div class="input-box">
                <input type="email" name="email" id="email" required placeholder=" ">
                <label for="email">Email</label>
              </div>
              <div class="input-box password-strength-container">
                <input type="password" id="password" name="password" required placeholder=" ">
                <label for="password">Password</label>
                <!-- <div class="password-strength-meter" id="password-strength"></div> -->
              </div>
              <button type="submit" class="buttonn">Log In</button>
              <div class="login-link">
                <p>Don't have an account ? <a href="./Signup-page">Register</a> </p>
              </div>
            </form>
            <div class="login-link">
              <div id="g_id_onload"
                data-client_id="623528213862-ejhv97qf0i1sqk48flff2ilc9v6em63c.apps.googleusercontent.com"
                data-context="signin"
                data-ux_mode="redirect"
                data-login_uri="http://localhost/Sarovi%20Work/moto_dresser/google_callback.php"
                data-auto_prompt="false">
              </div>
              <div class="g_id_signin"
                data-type="standard"></div>
            </div>

          </div>
        </div>
      </section>
    </main>



    <!-- <section class="section">
      <div class="formbox">
        <div class="form-val">
          <form action="">
            <h2>Login</h2>
            <div class="inputbox">
              <ion-icon name="mail-outline"></ion-icon>
              <input type="text" required>
              <label for="">Email</label>
            </div>
            <div class="inputbox">
              <ion-icon name="lock-closed-outline"></ion-icon>
              <input type="password" required>
              <label for="">Password</label>
            </div>
            <div class="forgot">
              <label for=""><input type="checkbox">Remember me <a href="#">forgot password</a></label>
            </div>
            <button class="button"><a href="#">Login</a></button>
            <div class="register">
              <p>Don't Have an account <a href="./Signup-page">Register</a> </p>
            </div>

          </form>
        </div>
      </div>
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </section> -->

    <?php
    include 'includes/footer.php';
    ?>
  </div>
  <?php
  include 'includes/script-links.php';
  ?>

  <script>
    $(document).ready(function() {
      $('#loginForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Get the values from the form
        var email = $('#email').val();
        var password = $('#password').val();

        // Simple validation
        if (email === '' || password === '') {
          Swal.fire({
            title: 'Error!',
            text: 'Please fill in all fields.',
            icon: 'warning',
            confirmButtonText: 'OK'
          });
          return; // Exit the function if validation fails
        }

        // Show the processing alert
        Swal.fire({
          title: 'Processing...',
          text: 'Please wait while we log you in.',
          icon: 'info',
          allowOutsideClick: false, // Prevent closing by clicking outside
          showConfirmButton: false, // Hide the confirm button
          didOpen: () => {
            Swal.showLoading(); // Show the loading spinner
          }
        });

        // AJAX request to send login data
        $.ajax({
          url: 'Login-page', // The PHP script to handle the login
          type: 'POST',
          data: {
            email: email,
            password: password
          },
          success: function(response) {
            // Parse the response if it's JSON or handle plain text
            var res = JSON.parse(response);

            if (res.success) {
              Swal.fire({
                title: 'Login Successful!',
                text: 'You have logged in successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
              }).then(() => {
                window.location.href = 'index'; // Redirect to dashboard
              });
            } else {
              Swal.fire({
                title: 'Login Failed!',
                text: res.message,
                icon: 'error',
                confirmButtonText: 'Try Again'
              });
            }
          },
          error: function() {
            Swal.fire({
              title: 'Error!',
              text: 'An error occurred while processing your request.',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        });
      });
    });
  </script>


</body>
<!-- Mirrored from html.merku.love/promotors/team by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:10 GMT -->

</html>