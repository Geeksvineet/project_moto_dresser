<?php
session_start();
include './includes/db.php'; // Adjust the path to your DB connection file

$id = isset($_GET['category']) ? intval($_GET['category']) : 0;

// $query = "SELECT * FROM products where cat_id = $id OR p_cat_id = $id OR manufacture_id = $id LIMIT 16";
// $result = mysqli_query($con, $query);

// Set pagination variables
$limit = 6; // Number of blogs per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch blogs with limit and offset for pagination
$query = "SELECT b.id, b.category, b.title, b.description, b.image, b.date_created, 
                 (SELECT COUNT(*) FROM comments_of_blog WHERE blog_id = b.id) AS comments_count
          FROM blog b where b.category =  $id
          ORDER BY b.date_created DESC 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);

// Fetch total number of blogs for pagination calculation
$totalQuery = "SELECT COUNT(*) as total FROM blog where category = $id";
$totalResult = mysqli_query($con, $totalQuery);
$totalBlogs = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalBlogs / $limit);

?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<!-- Mirrored from html.merku.love/promotors/blog by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:10 GMT -->

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width,initial-scale=1,shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Blog Grid – ProMotors – Car Service & Detailing Template</title>
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
        <main class="page_content" style="margin-top: 140px;">
            <section
                class="page_banner"
                style="background-image: url('assets/images/shapes/tyre_print_3.svg')">
                <div class="container">
                    <ul class="breadcrumb_nav unordered_list">
                        <li><a href="index">Home</a></li>
                        <li><a href="blog">Blog Grid</a></li>
                    </ul>
                    <h1 class="page_title wow" data-splitting>Blog Grid</h1>
                </div>
            </section>
            <section class="blog_grid_section section_space_lg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php while ($blog = mysqli_fetch_assoc($result)): ?>
                                        <?php
                                        $blog_id = $blog['id'];
                                        $catQuery1 = "SELECT * FROM blog_category WHERE id = $blog_id ";
                                        $catResult1 = mysqli_query($con, $catQuery1);
                                        $cat1 = mysqli_fetch_assoc($catResult1);
                                        ?>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="blog_item mb-5">
                                                <a class="item_image" href="blog_details.php?id=<?= $blog['id'] ?>">
                                                    <img src="<?= './admin_area/blog_images/' . $blog['image'] ?>" alt="<?= htmlspecialchars($blog['title']) ?>" />
                                                </a>
                                                <div class="item_content">
                                                    <ul class="item_type_list unordered_list">
                                                        <li><a href="category.php?category=<?= urlencode($blog['category']) ?>"><?= htmlspecialchars($cat1['category']) ?></a></li>
                                                    </ul>
                                                    <h3 class="item_title">
                                                        <a href="blog_details.php?id=<?= $blog['id'] ?>">
                                                            <?= htmlspecialchars($blog['title']) ?>
                                                        </a>
                                                    </h3>
                                                    <ul class="post_meta unordered_list">
                                                        <li><?= date('F j, Y', strtotime($blog['date_created'])) ?></li>
                                                        <li><a href="blog_details.php?id=<?= $blog['id'] ?>"><?= $blog['comments_count'] ?> Comments</a></li>
                                                    </ul>
                                                    <a class="btn-link" href="blog_details.php?blog_id=<?= $blog['id'] ?>">
                                                        <span class="btn_icon"><i class="fa fa-angle-right"></i></span>
                                                        <span class="btn_text">
                                                            <small>Read More</small>
                                                            <small>Read More</small>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <p>No blogs found.</p>
                                <?php endif; ?>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination_wrap">
                                <ul class="pagination_nav unordered_list">
                                    <?php if ($page > 1): ?>
                                        <li><a href="?page=<?= $page - 1 ?>"><i class="fa fa-angle-left"></i></a></li>
                                    <?php endif; ?>
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="<?= $page == $i ? 'active' : '' ?>"><a href="?page=<?= $i ?>"><?= $i ?></a></li>
                                    <?php endfor; ?>
                                    <?php if ($page < $totalPages): ?>
                                        <li><a href="?page=<?= $page + 1 ?>"><i class="fa fa-angle-right"></i></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <aside class="sidebar style_2 ps-lg-4">
                                <!-- Categories Section -->
                                <div class="widget">
                                    <h3 class="widget_title">Categories</h3>
                                    <ul class="info_list unordered_list_block">
                                        <?php
                                        $catQuery = "SELECT * FROM blog_category ORDER BY category ASC";
                                        $catResult = mysqli_query($con, $catQuery);
                                        while ($cat = mysqli_fetch_assoc($catResult)):
                                        ?>
                                            <li>
                                                <a href="blog_categorized?category=<?= urlencode($cat['id']) ?>">
                                                    <span class="info_icon">
                                                        <img src="assets/images/icons/icon_square.svg" alt="Category Icon" />
                                                    </span>
                                                    <span class="info_text"><?= htmlspecialchars($cat['category']) ?></span>
                                                </a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>

                                <!-- Recent Posts Section -->
                                <div class="widget recent_post">
                                    <h3 class="widget_title">Recent Posts</h3>
                                    <?php
                                    $recentQuery = "SELECT id, title, image, date_created FROM blog ORDER BY date_created DESC LIMIT 3";
                                    $recentResult = mysqli_query($con, $recentQuery);
                                    while ($recent = mysqli_fetch_assoc($recentResult)):
                                    ?>
                                        <?php
                                        $blog_id = $recent['id'];
                                        $totalQuery1 = "SELECT COUNT(*) as total FROM comments_of_blog where blog_id = $blog_id ";
                                        $totalResult1 = mysqli_query($con, $totalQuery1);
                                        $totalBlogs1 = mysqli_fetch_assoc($totalResult1)['total'];
                                        ?>
                                        <div class="blog_item">
                                            <a class="item_image" href="blog_details.php?blog_id=<?= $recent['id'] ?>">
                                                <img src="<?= './admin_area/blog_images/' . $recent['image'] ?>" alt="<?= htmlspecialchars($recent['title']) ?>" />
                                            </a>
                                            <div class="item_content">
                                                <h3 class="item_title">
                                                    <a href="blog_details.php?blog_id=<?= $recent['id'] ?>">
                                                        <?= htmlspecialchars($recent['title']) ?>
                                                    </a>
                                                </h3>
                                                <ul class="post_meta unordered_list">
                                                    <li><?= date('F j, Y', strtotime($recent['date_created'])) ?></li>
                                                    <li><a href="blog_details.php?blog_id=<?= $recent['id'] ?>"><?= htmlspecialchars($totalBlogs1) ?> Comments</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </aside>
                        </div>
                    </div>
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
<!-- Mirrored from html.merku.love/promotors/blog by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:12 GMT -->

</html>