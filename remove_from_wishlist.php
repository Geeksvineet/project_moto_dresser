<?php
session_start();
include 'includes/db.php';

$user_id = $_SESSION['user_id'];
$wishlist_id = $_GET['wishlist_id'];

// Prepare the deletion query
$delete_query = "DELETE FROM wishlist WHERE wishlist_id = ? AND customer_id = ?";
$stmt = $con->prepare($delete_query);
$stmt->bind_param('ii', $wishlist_id, $user_id);

// Flag to determine if the deletion was successful
$deletion_success = false;

if ($stmt->execute()) {
    $deletion_success = true;
    $message = "Item removed from wishlist.";
} else {
    $message = "Error removing item: " . $con->error;
}

$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Wishlist Item</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if ($deletion_success): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?php echo $message; ?>',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = 'view_wishlist'; // Redirect back to wishlist page after successful removal
                });
            <?php else: ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo $message; ?>',
                    showConfirmButton: true
                }).then(() => {
                    window.location.href = 'view_wishlist'; // Redirect back to wishlist page after showing the error
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
