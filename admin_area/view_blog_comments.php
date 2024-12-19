<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login', '_self')</script>";
    exit();
} else {
    // Assuming database connection is already established
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Blog Comments
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-comments fa-fw"></i> View Blog Comments
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Blog Title</th>
                                <th>Customer</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Comment Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_comments = "SELECT comments_of_blog.*, blog.title 
                                             FROM comments_of_blog 
                                             JOIN blog ON comments_of_blog.blog_id = blog.id 
                                             ORDER BY comments_of_blog.date_created DESC";
                            $run_comments = mysqli_query($con, $get_comments);

                            while ($row_comment = mysqli_fetch_array($run_comments)) {
                                $comment_id = $row_comment['id'];
                                $blog_title = $row_comment['title'];
                                $customer_login_id = $row_comment['customer_login_id'];
                                $name = $row_comment['name'];
                                $phone = $row_comment['phone'];
                                $message = $row_comment['message'];
                                $date_created = $row_comment['date_created'];
                                $i++;

                                // Fetch customer information if available
                                $customer_name = "Guest";
                                if ($customer_login_id) {
                                    $get_customer = "SELECT name FROM customer_login WHERE id='$customer_login_id'";
                                    $run_customer = mysqli_query($con, $get_customer);
                                    $row_customer = mysqli_fetch_array($run_customer);
                                    $customer_name = $row_customer['name'];
                                }
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $blog_title; ?></td>
                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo $phone; ?></td>
                                <td><?php echo $message; ?></td>
                                <td><?php echo date('d-M-Y', strtotime($date_created)); ?></td>
                                <td>
                                    <a href="index?delete_blog_comment=<?php echo $comment_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?');">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>
