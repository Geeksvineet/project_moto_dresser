<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login', '_self')</script>";
    exit();
} else {
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View User Carts
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-shopping-cart fa-fw"></i> View User Carts
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_carts = "SELECT * FROM cart";
                            $run_carts = mysqli_query($con, $get_carts);

                            while ($row_carts = mysqli_fetch_array($run_carts)) {
                                $cart_id = $row_carts['id'];
                                $product_id = $row_carts['p_id'];
                                $customer_id = $row_carts['customer_login_id'];
                                $qty = $row_carts['qty'];
                                $price = $row_carts['p_price'];
                                $total_price = $qty * $price;
                                $i++;

                                // Fetch customer information
                                $get_customer = "SELECT name, email FROM customer_login WHERE id='$customer_id'";
                                $run_customer = mysqli_query($con, $get_customer);
                                $row_customer = mysqli_fetch_array($run_customer);
                                $customer_name = $row_customer['name'];
                                $customer_email = $row_customer['email'];

                                // Fetch product information
                                $get_product = "SELECT product_title FROM products WHERE product_id='$product_id'";
                                $run_product = mysqli_query($con, $get_product);
                                $row_product = mysqli_fetch_array($run_product);
                                $product_title = $row_product['product_title'];
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $customer_name; ?> (<?php echo $customer_email; ?>)</td>
                                <td><?php echo $product_title; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td>$<?php echo number_format($price, 2); ?></td>
                                <td>$<?php echo number_format($total_price, 2); ?></td>
                                <td>
                                    <a href="index?delete_user_cart=<?php echo $cart_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item from the cart?');">
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
