<?php
session_start();
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

// Database connection
include './includes/db.php'; // Include your DB connection

// Fetch current user details
$query = "SELECT * FROM customers WHERE customer_login_id = '$user_id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

// Fetch profile status from the database
$profile_status_query = "SELECT profile_status FROM customer_login WHERE id = ?";
$stmt = $con->prepare($profile_status_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($profile_status);
$stmt->fetch();
$stmt->close();

// Function to get user IP address
function getCustomerIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $pincode = mysqli_real_escape_string($con, $_POST['pincode']);
    $ip_address = getCustomerIP(); // Get IP Address

    $user_pass = $user['password']; // Retain existing password

    // Handle image upload
    $image_path = ''; // Initialize image path
    if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != '') {
        $image_name = $_FILES['profile_image']['name'];
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $upload_dir = 'profile_images/';
        $image_path = $upload_dir . basename($image_name);
        
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            // File uploaded successfully
        } else {
            echo "Error uploading image.";
        }
    } else {
        // If no new image is uploaded, keep the existing image
        $image_path = $user['customer_image'];
    }

    // Update query
    $update_query = "UPDATE customers SET 
                        customer_name='$name', 
                        customer_email='$email', 
                        customer_contact='$phone', 
                        customer_country='$country', 
                        customer_city='$city', 
                        customer_address='$address', 
                        customer_pass='$user_pass', 
                        customer_image='$image_path', 
                        customer_ip='$ip_address', 
                        customer_pincode='$pincode' 
                     WHERE customer_login_id = '$user_id'";

    if (mysqli_query($con, $update_query)) {
        // Update profile status
        $update_query2 = "UPDATE customer_login SET profile_status = 1 WHERE id = '$user_id'";
        mysqli_query($con, $update_query2);

        echo '<script type="text/javascript">  
                window.location.href = "my_orders";
              </script>';
    } else {
        echo "Error updating profile: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Edit Profile</title>
    <?php include 'includes/head-links.php'; ?>
    <style>
        /* Add your styles here */
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1 {
            font-size: 2rem;
            color: #333;
        }
        p {
            color: #666;
        }
        a {
            text-decoration: none;
            color: #333;
        }
        a:hover {
            color: #007bff;
        }
        .account-container {
            display: flex;
            flex-wrap: wrap;
        }
        /* Sidebar Styles */
        .sidebar {
            background-color: #fff;
            padding: 20px;
            width: 250px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }
        .profile-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
        }
        .nav-menu a {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f8f8f8;
            color: #333;
        }
        .nav-menu a.active {
            background-color: #007bff;
            color: #fff;
        }
        .nav-menu a:hover {
            background-color: #007bff;
            color: #fff;
        }
        /* Main Content */
        .profile-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #fff;
        }
        .profile-form {
            max-width: 600px;
            margin: auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .profile-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn-update {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-update:hover {
            background-color: #0056b3;
        }
        /* Responsive Styles */
        @media (max-width: 768px) {
            .account-container {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
            }
            .profile-content {
                padding: 10px;
            }
            .profile-form {
                padding: 15px;
            }
        }
        .alert_banner {
            margin-top: 20px;
        }
        .alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <?php include 'includes/top-bar.php'; ?>

    <div class="page_wrapper">

        <?php include 'includes/header.php'; ?>

        <main class="page_content" style="margin-top: 140px;">

            <section class="alert_banner">
                <div class="container">
                    <?php if ($profile_status == 1): ?>
                        <div class="alert alert-success" role="alert">
                            <strong>Your profile is complete!</strong> Thank you for keeping your information up to date.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning" role="alert">
                            <strong>Your profile is incomplete.</strong> Please update your profile to get the best experience.
                            <a href="add_profile" class="btn btn-primary btn-sm ml-2">Update Profile</a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section>
                <div class="account-container">
                    <aside class="sidebar">
                        <div class="profile-section">
                            <img src="<?php echo $user['customer_image'] ?: 'teacher.jpg'; ?>" alt="Profile Picture" class="profile-img">
                            <p>Name: <strong><?php echo $_SESSION['user_name']; ?></strong></p>
                        </div>
                        <nav class="nav-menu">
                            <a href="my_orders">My Orders</a>

                            <?php if ($profile_status == 1): ?>
                                <a href="#!" class="active">Edit Profile</a>
                            <?php else: ?>
                                <a href="add_profile">Add Profile</a>
                            <?php endif; ?>

                            <a href="view_wishlist">My Wishlist</a>
                            <a href="t_and_c">Terms and conditions</a>
                            <a href="customer/logout">Logout</a>
                        </nav>
                    </aside>

                    <main class="profile-content">
                        <h1>Update Profile</h1>
                        <p>Update your personal details below:</p>

                        <form action="" method="POST" enctype="multipart/form-data" class="profile-form">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['customer_name']); ?>" required>

                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['customer_email']); ?>" required>

                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['customer_contact']); ?>" required>

                            <label for="country">State</label>
                            <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($user['customer_country']); ?>" required>

                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['customer_city']); ?>" required>

                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['customer_address']); ?>" required>

                            <label for="pincode">Pincode</label>
                            <input type="text" id="pincode" name="pincode" value="<?php echo htmlspecialchars($user['customer_pincode']); ?>" required>

                            <label for="profile_image">Profile Image</label>
                            <input type="file" id="profile_image" name="profile_image" accept="image/*">

                            <button type="submit" class="btn-update">Update Profile</button>
                        </form>
                    </main>
                </div>
            </section>

        </main>
        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/script-links.php'; ?>
</body>
</html>
