<?php

if (!isset($_SESSION['admin_email'])) {

    echo "<script>window.open('login','_self')</script>";
} else {


?>

    <div class="row"><!-- 1 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <ol class="breadcrumb"><!-- breadcrumb Starts -->

                <li class="active">

                    <i class="fa fa-dashboard"></i> Dashboard / View Customers

                </li>

            </ol><!-- breadcrumb Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 1 row Ends -->

    <div class="row"><!-- 2 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <div class="panel panel-default"><!-- panel panel-default Starts -->

                <div class="panel-heading"><!-- panel-heading Starts -->

                    <h3 class="panel-title"><!-- panel-title Starts -->

                        <i class="fa fa-money fa-fw"></i> View Customers

                    </h3><!-- panel-title Ends -->

                </div><!-- panel-heading Ends -->


                <div class="panel-body"><!-- panel-body Starts -->

                    <div class="table-responsive"><!-- table-responsive Starts -->

                        <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->

                            <thead><!-- thead Starts -->

                                <tr>

                                    <th>#</th>
                                    <th>Profile Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Customer Address</th>
                                    <th>Customer City</th>
                                    <th>Customer State</th>
                                    <th>Customer Zip code</th>
                                    <!-- <th>City</th> -->
                                    <th>Delete</th>


                                </tr>

                            </thead><!-- thead Ends -->


                            <tbody><!-- tbody Starts -->

                                <?php

                                $i = 0;

                                $get_c = "select * from customer_login";

                                $run_c = mysqli_query($con, $get_c);

                                while ($row_c = mysqli_fetch_array($run_c)) {

                                    $c_id = $row_c['id'];

                                    $profile_status = $row_c['profile_status'];

                                    $c_name = $row_c['name'];

                                    $c_email = $row_c['email'];

                                    $c_contact = $row_c['phone'];

                                    if ($profile_status == 1) {

                                        $get_c1 = "select * from customers where customer_login_id = $c_id";

                                        $run_c1 = mysqli_query($con, $get_c1);

                                        $row_c1 = mysqli_fetch_array($run_c1);

                                        $c_profile_img = $row_c1['customer_image'] ? $row_c1['customer_image'] : "NA";

                                        $c_address = $row_c1['customer_address'] ? $row_c1['customer_address'] : "NA";

                                        $c_city = $row_c1['customer_city'] ? $row_c1['customer_city'] : "NA";

                                        $c_state = $row_c1['customer_country'] ? $row_c1['customer_country'] : "NA";

                                        $c_pincode = $row_c1['customer_pincode'] ? $row_c1['customer_pincode'] : "NA";
                                    } else {
                                        $c_profile_img = "NA";

                                        $c_address = "NA";

                                        $c_city = "NA";

                                        $c_state = "NA";

                                        $c_pincode = "NA";
                                    }


                                    $i++;




                                ?>

                                    <tr>

                                        <td><?php echo $i; ?></td>

                                        <?php if ($c_profile_img == "NA"): ?>
                                             
                                            <td><?php echo "NA"; ?></td>

                                        <?php else: ?>

                                            <td><img src="../<?php echo $c_profile_img; ?>" width="60" height="60"></td>
                                            
                                        <?php endif; ?>


                                        <td><?php echo $c_name; ?></td>

                                        <td><?php echo $c_email; ?></td>

                                        <td><?php echo $c_contact; ?></td>

                                        <td><?php echo $c_address; ?></td>

                                        <td><?php echo $c_city; ?></td>

                                        <td><?php echo $c_state; ?></td>

                                        <td><?php echo $c_pincode; ?></td>

                                        <td>

                                            <a href="index?customer_delete=<?php echo $c_id; ?>">

                                                <i class="fa fa-trash-o"></i> Delete

                                            </a>


                                        </td>


                                    </tr>

                                <?php } ?>


                            </tbody><!-- tbody Ends -->



                        </table><!-- table table-bordered table-hover table-striped Ends -->

                    </div><!-- table-responsive Ends -->

                </div><!-- panel-body Ends -->


            </div><!-- panel panel-default Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->

<?php } ?>