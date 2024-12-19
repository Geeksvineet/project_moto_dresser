<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Define the URL for redirection (login page)
$redirect_url = "../index";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Logged Out',
                text: 'You have successfully logged out!',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = '<?php echo $redirect_url; ?>';
            });
        });
    </script>
</body>
</html>
