<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login','_self')</script>";
    exit();
} else {
?>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / View Product Reviews
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-comments fa-fw"></i> View Product Reviews
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Product</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Review Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $get_reviews = "SELECT * FROM reviews";
                                $run_reviews = mysqli_query($con, $get_reviews);

                                while ($row_reviews = mysqli_fetch_array($run_reviews)) {
                                    $review_id = $row_reviews['id'];
                                    $product_id = $row_reviews['product_id'];
                                    $name = $row_reviews['name'];
                                    $email = $row_reviews['email'];
                                    $rating = $row_reviews['rating'];
                                    $comment = $row_reviews['comment'];
                                    $created_at = $row_reviews['created_at'];
                                    $i++;

                                    // Fetch product details
                                    $get_product = "SELECT product_title FROM products WHERE product_id='$product_id'";
                                    $run_product = mysqli_query($con, $get_product);
                                    $row_product = mysqli_fetch_array($run_product);
                                    $product_title = $row_product['product_title'];
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo htmlspecialchars($name); ?></td>
                                        <td><?php echo htmlspecialchars($email); ?></td>
                                        <td><?php echo htmlspecialchars($product_title); ?></td>
                                        <td><?php echo htmlspecialchars($rating); ?> / 5</td>
                                        <td><?php echo htmlspecialchars($comment); ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($created_at)); ?></td>
                                        <td>
                                            <a href="index.php?delete_product_reviews=<?php echo $review_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?');">
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
