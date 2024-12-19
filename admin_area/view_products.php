<?php



if (!isset($_SESSION['admin_email'])) {

    echo "<script>window.open('login','_self')</script>";
} else {

?>


    <div class="row"><!--  1 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <ol class="breadcrumb"><!-- breadcrumb Starts -->

                <li class="active">

                    <i class="fa fa-dashboard"></i> Dashboard / View Products

                </li>

            </ol><!-- breadcrumb Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!--  1 row Ends -->

    <div class="row"><!-- 2 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <div class="panel panel-default"><!-- panel panel-default Starts -->

                <div class="panel-heading"><!-- panel-heading Starts -->

                    <h3 class="panel-title"><!-- panel-title Starts -->

                        <i class="fa fa-money fa-fw"></i> View Products

                    </h3><!-- panel-title Ends -->


                </div><!-- panel-heading Ends -->

                <div class="panel-body"><!-- panel-body Starts -->

                    <div class="table-responsive"><!-- table-responsive Starts -->

                        <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->

                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Keywords</th>
                                    <th>Date</th>
                                    <th>Detail</th>
                                    <th>Delete</th>
                                    <th>Edit</th>



                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $i = 0;

                                $get_pro = "select * from products";

                                $run_pro = mysqli_query($con, $get_pro);

                                while ($row_pro = mysqli_fetch_array($run_pro)) {

                                    $pro_id = $row_pro['product_id'];

                                    $pro_title = $row_pro['product_title'];

                                    $pro_price = $row_pro['product_price'];

                                    $pro_keywords = $row_pro['product_keywords'];

                                    $pro_date = $row_pro['date'];

                                    $query10 = "SELECT * FROM product_images where product_id = $pro_id";
                                    $result10 = mysqli_query($con, $query10);
                                    $post10 = mysqli_fetch_assoc($result10);

                                    $pro_image = $post10['image'];

                                    $i++;

                                ?>

                                    <tr>

                                        <td><?php echo $i; ?></td>

                                        <td><?php echo $pro_title; ?></td>

                                        <td><img src="product_images/<?php echo $pro_image; ?>" width="60" height="60"></td>

                                        <td>$ <?php echo $pro_price; ?></td>

                                        <td> <?php echo $pro_keywords; ?> </td>

                                        <td><?php echo $pro_date; ?></td>

                                        <td>

                                            <a href="../shop_details?id=<?php echo $pro_id; ?>" target="_blank">

                                                <i class="fa fa-eye"> </i> View

                                            </a>

                                        </td>

                                        <td>

                                            <a href="index?delete_product=<?php echo $pro_id; ?>">

                                                <i class="fa fa-trash-o"> </i> Delete

                                            </a>

                                        </td>

                                        <td>

                                            <a href="index?edit_product=<?php echo $pro_id; ?>">

                                                <i class="fa fa-pencil"> </i> Edit

                                            </a>

                                        </td>

                                    </tr>

                                <?php } ?>


                            </tbody>


                        </table><!-- table table-bordered table-hover table-striped Ends -->

                    </div><!-- table-responsive Ends -->

                </div><!-- panel-body Ends -->

            </div><!-- panel panel-default Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->




<?php } ?>