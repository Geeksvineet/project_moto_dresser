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
                    <i class="fa fa-dashboard"></i> Dashboard / View Orders
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i> View Orders
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Invoice</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Total Amount</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                    <th>Payment Method</th>
                                    <th>Payment Id</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $get_orders = "SELECT * FROM my_orders";
                                $run_orders = mysqli_query($con, $get_orders);

                                while ($row_orders = mysqli_fetch_array($run_orders)) {
                                    $order_id = $row_orders['order_id'];
                                    $c_id = $row_orders['customer_id'];
                                    $invoice_no = $row_orders['invoice_no'];
                                    $products_ordered = json_decode($row_orders['products_ordered'], true);
                                    $qty = $row_orders['qty'];
                                    $total_amount = $row_orders['total_amount'];
                                    $order_status = $row_orders['order_status'];
                                    $payment_status = $row_orders['payment_status'];
                                    $payment_method = $row_orders['payment_method'];
                                    $payment_id = $row_orders['payment_id'] ? $row_orders['payment_id'] : "not available";
                                    $order_date = $row_orders['order_date'];
                                    $i++;

                                    // Fetch customer email
                                    $get_customer = "SELECT email FROM customer_login WHERE id='$c_id'";
                                    $run_customer = mysqli_query($con, $get_customer);
                                    $row_customer = mysqli_fetch_array($run_customer);
                                    $customer_email = $row_customer['email'];
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $customer_email; ?></td>
                                        <td bgcolor="orange"><?php echo $invoice_no; ?></td>
                                        <td>
                                            <?php
                                            if (is_array($products_ordered)) {
                                                foreach ($products_ordered as $product) {
                                                    $product_id = $product['productId'];
                                                    $get_customer2 = "SELECT product_title FROM products WHERE product_id='$product_id'";
                                                    $run_customer2 = mysqli_query($con, $get_customer2);
                                                    $row_customer2 = mysqli_fetch_array($run_customer2);
                                                    $customer_email2 = $row_customer2['product_title'];
                                                    // echo "Product Name:<span style='font-weight: 700;'>" . $customer_email2 . "<br>Color:<span style='font-weight: 700;'>" . $product['color'] . "<br>Size:<span style='font-weight: 700;'>" . $product['size'] . "</span><br> (Qty: <span style='color: blue;'>" . $product['quantity'] . "</span>)<br>";
                                                    echo "Product Name:<span style='font-weight: 700;'>" . $customer_email2 . "</span><br>Color:<span style='font-weight: 700;'>" . $product['color'] . "</span><br>Size:<span style='font-weight: 700;'>" . $product['size'] . "</span><br> (Qty: <span style='color: blue;'>" . $product['quantity'] . "</span>)<br>";
                                                }
                                            } else {
                                                echo "No products found";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $qty; ?></td>
                                        <td>$<?php echo $total_amount; ?></td>

                                        <!-- Order Status Dropdown -->
                                        <td>
                                            <form action="update_order_status" method="POST">
                                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                                <select name="order_status" onchange="this.form.submit()">
                                                    <option value="processing" <?php if ($order_status == 'processing') echo 'selected'; ?>>Processing</option>
                                                    <option value="shipped" <?php if ($order_status == 'shipped') echo 'selected'; ?>>Shipped</option>
                                                    <option value="delivered" <?php if ($order_status == 'delivered') echo 'selected'; ?>>Delivered</option>
                                                    <option value="cancelled" <?php if ($order_status == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>

                                        <!-- Payment Status Dropdown -->
                                        <td>
                                            <form action="update_order_status" method="POST">
                                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                                <select name="payment_status" onchange="this.form.submit()">
                                                    <option value="pending" <?php if ($payment_status == 'pending') echo 'selected'; ?>>Pending</option>
                                                    <option value="completed" <?php if ($payment_status == 'completed') echo 'selected'; ?>>Completed</option>
                                                    <option value="failed" <?php if ($payment_status == 'failed') echo 'selected'; ?>>Failed</option>
                                                </select>
                                            </form>
                                        </td>

                                        <td><?php echo ucfirst($payment_method); ?></td>
                                        <td><?php echo $payment_id; ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($order_date)); ?></td>
                                        <td>
                                            <a href="index?order_delete=<?php echo $order_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?');">
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