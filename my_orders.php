<?php
session_start();
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

// Database connection
include './includes/db.php'; // Make sure your DB connection file is correct

// Query to fetch the orders for the logged-in user
$query = "SELECT * FROM my_orders WHERE customer_id = '$user_id' ORDER BY order_date DESC";
$result = mysqli_query($con, $query);


// Fetch profile status from the database
$profile_status_query = "SELECT profile_status FROM customer_login WHERE id = ?";
$stmt = $con->prepare($profile_status_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($profile_status);
$stmt->fetch();
$stmt->close();


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

    <style>
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
        .orders-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #fff;
        }

        .table-responsive {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .status.unpaid {
            color: red;
            font-weight: bold;
        }

        .btn-confirm {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-confirm:hover {
            background-color: #218838;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .account-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .orders-content {
                padding: 10px;
            }

            table th,
            table td {
                padding: 8px;
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

    <?php
    include 'includes/top-bar.php';
    ?>

    <div class="page_wrapper">

        <?php
        include 'includes/header.php';
        ?>

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
                            <a href="add_profile" class="btn btn-primary btn-sm ml-2">Add Profile</a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section>
                <div class="account-container">
                    <aside class="sidebar">
                        <div class="profile-section">
                            <!-- <img src="profile_images/teacher.jpg" alt="Profile Picture" class="profile-img"> -->


                            <?php if ($profile_status == 1): ?>
                                <?php
                                // Correct the SQL query by including the IP address in the WHERE clause
                                $sql_cat = "SELECT * FROM customers WHERE customer_login_id = '$user_id'";
                                $cat_result = $con->query($sql_cat);
                                $user = $cat_result->fetch_assoc();
                                $profile_image = $user['customer_image'];
                                ?>
                                <img src="<?php echo $profile_image; ?>" alt="Profile Picture" class="profile-img">
                            <?php else: ?>
                                <img src="profile_images/teacher.jpg" alt="Profile Picture" class="profile-img">
                            <?php endif; ?>





                            <!-- <img src="<?php echo $profile_image; ?>" alt="Profile Picture" class="profile-img"> -->


                            <p>Name: <strong><?php echo $_SESSION['user_name']; ?></strong></p>
                        </div>
                        <nav class="nav-menu">
                            <a href="#" class="active">My Orders</a>

                            <?php if ($profile_status == 1): ?>
                                <a href="edit_profile">Edit Profile</a>
                            <?php else: ?>
                                <a href="add_profile">Add Profile</a>
                            <?php endif; ?>

                            <a href="view_wishlist">My Wishlist</a>
                            <a href="t_and_c">Terms and conditions</a>
                            <a href="customer/logout">Logout</a>
                        </nav>
                    </aside>

                    <main class="orders-content">
                        <h1>My Orders</h1>
                        <p>Your orders all in one place. If you have any questions, please contact us, our customer service is available 24/7.</p>

                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>S NO.</th>
                                        <th>Amount</th>
                                        <th>Invoice</th>
                                        <th>Qty</th>
                                        <th>Order Status</th>
                                        <th>Payment Status</th>
                                        <th>Payment Method</th>
                                        <th>Order Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        $counter = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $counter . "</td>";
                                            echo "<td>₹" . $row['total_amount'] . "</td>";
                                            echo "<td>" . $row['invoice_no'] . "</td>";
                                            echo "<td>" . $row['qty'] . "</td>";
                                            echo "<td>" . $row['order_status'] . "</td>";
                                            echo "<td>" . $row['payment_status'] . "</td>";
                                            echo "<td>" . $row['payment_method'] . "</td>";
                                            echo "<td>" . $row['order_date'] . "</td>";
                                            echo "</tr>";
                                            $counter++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='8'>No orders found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </main>
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

</body>
<!-- Mirrored from html.merku.love/promotors/home1_repair_service by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:16:03 GMT -->

</html>