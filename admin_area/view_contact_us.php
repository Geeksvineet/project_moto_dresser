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
                <i class="fa fa-dashboard"></i> Dashboard / View Contact Us
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-envelope fa-fw"></i> View Contact Us
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact No.</th>
                                <th>Message</th>
                                <th>Contact Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_subscriptions = "SELECT * FROM contact";
                            $run_subscriptions = mysqli_query($con, $get_subscriptions);

                            while ($row_subscription = mysqli_fetch_array($run_subscriptions)) {
                                $subscription_id = $row_subscription['id'];
                                $customer_login_id = $row_subscription['customer_login_id'];
                                $name = $row_subscription['name'];
                                $email = $row_subscription['email'];
                                $phone = $row_subscription['phone'];
                                $msg = $row_subscription['message'];
                                $date_created = $row_subscription['date_created'];
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
                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $phone; ?></td>
                                <td><?php echo $msg; ?></td>
                                <td><?php echo date('d-M-Y', strtotime($date_created)); ?></td>
                                <td>
                                    <a href="index?delete_contact_us=<?php echo $subscription_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subscription?');">
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
