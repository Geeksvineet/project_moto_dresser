<?php
session_start();
include 'includes/db.php';

$user_id = $_SESSION['user_id']; // Assuming user is logged in

// Fetch wishlist items with only one image per product
$query = "SELECT w.wishlist_id, p.product_title, p.product_psp_price, MIN(pi.image) as image
          FROM wishlist w 
          JOIN products p ON w.product_id = p.product_id
          JOIN product_images pi ON w.product_id = pi.product_id 
          WHERE w.customer_id = ?
          GROUP BY w.wishlist_id, p.product_title, p.product_psp_price";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch profile status
$profile_status_query = "SELECT profile_status FROM customer_login WHERE id = ?";
$stmt_profile = $con->prepare($profile_status_query);
$stmt_profile->bind_param('i', $user_id);
$stmt_profile->execute();
$stmt_profile->bind_result($profile_status);
$stmt_profile->fetch();
$stmt_profile->close();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>My Wishlist</title>

    <?php include 'includes/head-links.php'; ?>

    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .page_content {
            display: flex;
        }

        .account-container {
            width: 100%;
            display: flex;
            /* flex-wrap: wrap; */
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

        /* Wishlist Content */
        .wishlist-section {
            /* padding: 30px 0 30px; */
            width: 100%;
            flex-grow: 1;
            padding: 20px;
            background-color: #fff;
        }

        .wishlist-container {
            padding: 30px 0 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .wishlist-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            width: 250px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .btn-remove {
            display: inline-block;
            padding: 10px;
            background-color: #ff4c4c;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }

        .btn-remove:hover {
            background-color: #ff0000;
        }

        @media (max-width: 768px) {
            .page_content {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .wishlist-section {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <?php include 'includes/top-bar.php'; ?>

    <div class="page_wrapper">
        <?php include 'includes/header.php'; ?>

        <main class="page_content" style="margin-top: 140px;">
            <section class="account-container">
                <aside class="sidebar">
                    <div class="profile-section">
                        <?php
                        $sql_cat = "SELECT * FROM customers WHERE customer_login_id = '$user_id'";
                        $cat_result = $con->query($sql_cat);
                        $user = $cat_result->fetch_assoc();
                        $profile_image = $user['customer_image'] ?? 'profile_images/teacher.jpg';
                        ?>
                        <img src="<?php echo $profile_image; ?>" alt="Profile Picture" class="profile-img">
                        <p>Name: <strong><?php echo $_SESSION['user_name']; ?></strong></p>
                    </div>
                    <nav class="nav-menu">
                        <a href="my_orders">My Orders</a>

                        <?php if ($profile_status == 1): ?>
                            <a href="edit_profile">Edit Profile</a>
                        <?php else: ?>
                            <a href="add_profile">Add Profile</a>
                        <?php endif; ?>

                        <a href="#!" class="active">My Wishlist</a>
                        <a href="t_and_c">Terms and conditions</a>
                        <a href="customer/logout">Logout</a>
                    </nav>
                </aside>

                <section class="wishlist-section">
                    <h1 style="text-align: center;">My Wishlist</h1>
                    <div class="wishlist-container">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="wishlist-item">
                                    <img src="./admin_area/product_images/<?php echo $row['image']; ?>" alt="<?php echo $row['product_title']; ?>" class="product-img">
                                    <h2><?php echo $row['product_title']; ?></h2>
                                    <p>Price: $<?php echo $row['product_psp_price']; ?></p>
                                    <a href="remove_from_wishlist.php?wishlist_id=<?php echo $row['wishlist_id']; ?>" class="btn-remove">Remove</a>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Your wishlist is empty.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </section>
        </main>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/script-links.php'; ?>
</body>

</html>

<?php
$stmt->close();
$con->close();
?>