<?php
session_start();
include './includes/db.php';

// Fetch terms from the database
$query = "SELECT * FROM terms where term_title = 'Moto Dresser Terms & Conditions' ";
$result = mysqli_query($con, $query);
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
    <title>Terms and Conditions</title>

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

        <main class="page_content" style="margin: 140px 0 60px;">

            <div class="container">

                <?php if (mysqli_num_rows($result) > 0) : ?>
                    <div class="terms-list">
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <div class="term">
                                <h2 class="term-title"><?= htmlspecialchars($row['term_title']) ?></h2>
                                <p class="term-desc"><?= $row['term_desc'] ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else : ?>
                    <p>No terms available at the moment.</p>
                <?php endif; ?>

            </div>

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