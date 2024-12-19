<?php
session_start();
require_once './includes/db.php'; // Replace with your database connection file

// Get the blog ID from the URL parameter
$blog_id = isset($_GET['blog_id']) ? intval($_GET['blog_id']) : 0;

// Fetch the blog details from the database
$sql = "SELECT b.id, b.title, b.description, b.image, b.date_created, bc.category 
        FROM blog b 
        LEFT JOIN blog_category bc ON b.category = bc.id 
        WHERE b.id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $blog_id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();

if (!$blog) {
  echo "<h2>Blog not found.</h2>";
  exit;
}

$sql_comments = "SELECT c.name, c.message, c.date_created 
                 FROM comments_of_blog c 
                 WHERE c.blog_id = ? 
                 ORDER BY c.date_created DESC LIMIT 6";
$stmt_comments = $con->prepare($sql_comments);
$stmt_comments->bind_param('i', $blog_id);
$stmt_comments->execute();
$comments = $stmt_comments->get_result();

$sql_recent_posts = "SELECT id, title, image, date_created FROM blog ORDER BY date_created DESC LIMIT 5";
$recent_posts = $con->query($sql_recent_posts);

// Fetch categories
$sql_categories = "SELECT id, category FROM blog_category";
$categories = $con->query($sql_categories);

$sql_categories1 = "SELECT id, category FROM blog_category";
$categories1 = $con->query($sql_categories1);

// Fetch recent comments
$sql_recent_comments = "SELECT c.message, b.title, b.id
                        FROM comments_of_blog c 
                        JOIN blog b ON c.blog_id = b.id 
                        ORDER BY c.date_created DESC LIMIT 5";
$recent_comments = $con->query($sql_recent_comments);



// Insert a comment if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_SESSION['user_id'])) {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);
    $customer_login_id = $_SESSION['user_id'];

    if (!empty($name) && !empty($message)) {
      $sql_insert = "INSERT INTO comments_of_blog (name, phone, message, blog_id, customer_login_id) 
                           VALUES (?, ?, ?, ?, ?)";
      $stmt_insert = $con->prepare($sql_insert);
      $stmt_insert->bind_param('sssii', $name, $phone, $message, $blog_id, $customer_login_id);
      $stmt_insert->execute();

      // Redirect to the same page to prevent form resubmission
      header("Location: blog_details.php?blog_id=" . $blog_id);
      exit;
    }
  } else {
    // If the user is not logged in, redirect to login page
    header("Location: Login-page");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<!-- Mirrored from html.merku.love/promotors/blog_details by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:15 GMT -->

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width,initial-scale=1,shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>
    Blog Details V.1 – ProMotors – Car Service & Detailing Template
  </title>
  <?php
  include 'includes/head-links.php';
  ?>

  <style>
    .comments_list {
      margin-top: 30px;
    }

    .comments_list h3 {
      margin-bottom: 20px;
      font-size: 20px;
      font-weight: bold;
    }

    .comment_item {
      display: flex;
      flex-direction: column;
      gap: 10px;
      border-bottom: 1px solid #ddd;
      padding: 15px 0;
    }

    .comment_header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 5px;
    }

    .comment_author {
      font-size: 16px;
      font-weight: 600;
      color: #007bff;
    }

    .comment_date {
      font-size: 12px;
      color: #888;
    }

    .comment_body p {
      margin: 0;
      line-height: 1.5;
      color: #333;
    }

    .comment_item:last-child {
      border-bottom: none;
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
      <section
        class="page_banner"
        style="background-image: url('assets/images/shapes/tyre_print_3.svg')">
        <div class="container">
          <ul class="breadcrumb_nav unordered_list">
            <li><a href="index">Home</a></li>
            <li><a href="blog_details">Blog Details</a></li>
          </ul>
          <h1 class="page_title wow" data-splitting>Blog Details</h1>
        </div>
      </section>
      <section class="details_section section_space_lg">
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <div class="details_image">
                <img width="100%" src="./admin_area/blog_images/<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" />
              </div>
              <div class="details_content">
                <ul class="post_meta unordered_list">
                  <li><?php echo date('F d, Y', strtotime($blog['date_created'])); ?></li>
                  <li><a href="#comments_section"><?php echo $comments->num_rows; ?> Comments</a></li>
                </ul>
                <h2 class="details_item_title"><?php echo htmlspecialchars($blog['title']); ?></h2>
                <p><?php echo $blog['description']; ?></p>
                <!-- Add navigation for next and previous posts here -->
              </div>

              <!-- Comments Section -->
              <div class="comment_form section_space_md pb-0">
                <div class="row">
                  <div class="col-lg-10">
                    <div class="section_heading">
                      <h2 class="heading_text wow" data-splitting>
                        Leave a reply
                      </h2>
                    </div>
                  </div>
                </div>
                <form method="POST" action="">
                  <div class="form_wrap row">
                    <div class="col-md-6">
                      <div class="form-group mb-0">
                        <label for="input_name">Your Name</label>
                        <input type="text" name="name" class="form-control" id="input_name" placeholder="Enter Your Name" required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group mb-0">
                        <label for="input_phone">Your Phone</label>
                        <input type="tel" name="phone" class="form-control" id="input_phone" placeholder="Enter Your Phone" required />
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <label for="input_textarea">Your Message</label>
                        <textarea name="message" class="form-control" id="input_textarea" placeholder="Type your message" required></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">
                        <span class="btn_text">Send Now</span>
                      </button>
                    </div>
                  </div>
                </form>
              </div>

              <!-- Display comments -->
              <div id="comments_section" class="comments_list section_space_md">
                <h3><?php echo $comments->num_rows; ?> Comments</h3>
                <?php while ($comment = $comments->fetch_assoc()): ?>
                  <div class="comment_item">
                    <div class="comment_header">
                      <strong class="comment_author"><?php echo htmlspecialchars($comment['name']); ?></strong>
                      <small class="comment_date">
                        <?php echo date('F d, Y', strtotime($comment['date_created'])); ?>
                      </small>
                    </div>
                    <div class="comment_body">
                      <p><?php echo nl2br(htmlspecialchars($comment['message'])); ?></p>
                    </div>
                  </div>
                <?php endwhile; ?>
              </div>

            </div>

            <div class="col-lg-4">
              <aside class="sidebar style_2 ps-lg-4">
                <!-- Categories -->
                <div class="widget">
                  <h3 class="widget_title">Categories</h3>
                  <ul class="info_list unordered_list_block">
                    <?php while ($category = $categories->fetch_assoc()): ?>
                      <li>
                        <a href="blog_categorized?category=<?php echo $category['id']; ?>">
                          <span class="info_icon"><img src="assets/images/icons/icon_square.svg" alt="Category Icon" /></span>
                          <span class="info_text"><?php echo htmlspecialchars($category['category']); ?></span>
                        </a>
                      </li>
                    <?php endwhile; ?>
                  </ul>
                </div>

                <!-- Recent Posts -->
                <div class="widget recent_post">
                  <h3 class="widget_title">Recent Posts</h3>
                  <?php while ($recent_post = $recent_posts->fetch_assoc()): ?>
                    <div class="blog_item">
                      <a class="item_image" href="blog_details.php?blog_id=<?php echo $recent_post['id']; ?>">
                        <img src="./admin_area/blog_images/<?php echo htmlspecialchars($recent_post['image']); ?>" alt="<?php echo htmlspecialchars($recent_post['title']); ?>" />
                      </a>
                      <div class="item_content">
                        <h3 class="item_title">
                          <a href="blog_details.php?blog_id=<?php echo $recent_post['id']; ?>"><?php echo htmlspecialchars($recent_post['title']); ?></a>
                        </h3>
                        <ul class="post_meta unordered_list">
                          <li><?php echo date('F d, Y', strtotime($recent_post['date_created'])); ?></li>
                        </ul>
                      </div>
                    </div>
                  <?php endwhile; ?>
                </div>

                <!-- Recent Comments -->
                <div class="widget">
                  <h3 class="widget_title">Recent Comments</h3>
                  <ul class="info_list unordered_list_block">
                    <?php while ($recent_comment = $recent_comments->fetch_assoc()): ?>
                      <li>
                        <span class="info_icon"><img src="assets/images/icons/icon_square.svg" alt="Comment Icon" /></span>
                        <span class="info_text"><?php echo htmlspecialchars($recent_comment['message']); ?> on <a href="blog_details.php?blog_id=<?php echo $recent_comment['id']; ?>"><?php echo htmlspecialchars($recent_comment['title']); ?></a></span>
                      </li>
                    <?php endwhile; ?>
                  </ul>
                </div>

                <!-- Popular Tags -->
                <!-- <div class="widget">
                  <h3 class="widget_title">Popular Tags</h3>
                  <ul class="tags_list unordered_list">
                    <?php while ($category1 = $categories1->fetch_assoc()): ?>
                      <li><a href="category.php?id=<?php echo $category1['id']; ?>"><?php echo htmlspecialchars($category1['category']); ?></a></li>
                    <?php endwhile; ?>
                  </ul>
                </div> -->
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
<!-- Mirrored from html.merku.love/promotors/blog_details by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:16 GMT -->

</html>