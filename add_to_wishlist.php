<?php
session_start();
include 'includes/db.php';

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'];

$check_query = "SELECT * FROM wishlist WHERE customer_id = ? AND product_id = ?";
$stmt = $con->prepare($check_query);
$stmt->bind_param('ii', $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

$alertScript = '';

if ($result->num_rows > 0) {
    $alertScript = "
        Swal.fire({
            icon: 'info',
            title: 'Already in Wishlist',
            text: 'This product is already in your wishlist!',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'view_wishlist';
        });
    ";
} else {
    $insert_query = "INSERT INTO wishlist (customer_id, product_id) VALUES (?, ?)";
    $stmt = $con->prepare($insert_query);
    $stmt->bind_param('ii', $user_id, $product_id);

    if ($stmt->execute()) {
        $alertScript = "
            Swal.fire({
                icon: 'success',
                title: 'Added to Wishlist',
                text: 'Product has been added to your wishlist!',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'view_wishlist';
            });
        ";
    } else {
        $alertScript = "
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error adding to wishlist: " . $con->error . "',
                confirmButtonText: 'OK'
            });
        ";
    }
}

$stmt->close();
$con->close();
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

</head>

<body>

    <?php
    include 'includes/top-bar.php';
    ?>

    <div class="page_wrapper">

        <?php
        include 'includes/header.php';
        ?>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <main class="page_content" style="margin : 300px 0 300px ;">

            <script>
                <?php echo $alertScript; ?>
            </script>

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







<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Action</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        <?php echo $alertScript; ?>
    </script>
</body>
</html> -->