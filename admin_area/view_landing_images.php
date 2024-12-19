<?php

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login','_self')</script>";
} else {

?>

<div class="row"><!--  1 row Starts -->
    <div class="col-lg-12"><!-- col-lg-12 Starts -->
        <ol class="breadcrumb"><!-- breadcrumb Starts -->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Landing Images
            </li>
        </ol><!-- breadcrumb Ends -->
    </div><!-- col-lg-12 Ends -->
</div><!--  1 row Ends -->

<div class="row"><!-- 2 row Starts -->
    <div class="col-lg-12"><!-- col-lg-12 Starts -->
        <div class="panel panel-default"><!-- panel panel-default Starts -->
            <div class="panel-heading"><!-- panel-heading Starts -->
                <h3 class="panel-title"><!-- panel-title Starts -->
                    <i class="fa fa-money fa-fw"></i> View Landing Images
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
                                <th>Show</th>
                                <th>Date Created</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $i = 0;
                        $get_images = "SELECT * FROM landing_images";
                        $run_images = mysqli_query($con, $get_images);

                        while ($row_images = mysqli_fetch_array($run_images)) {
                            $image_id = $row_images['id'];
                            $image_title = $row_images['title'];
                            $image_file = $row_images['image'];
                            $image_show = $row_images['show'];
                            $image_date = $row_images['date_created'];
                            $i++;
                        ?>

                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $image_title; ?></td>
                                <td><img src="landing_images/<?php echo $image_file; ?>" width="60" height="60"></td>
                                <td><?php echo ucfirst($image_show); ?></td>
                                <td><?php echo $image_date; ?></td>
                                <td>
                                    <a href="index?edit_landing_image=<?php echo $image_id; ?>">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                </td>
                                <td>
                                    <a href="index?delete_landing_image=<?php echo $image_id; ?>">
                                        <i class="fa fa-trash-o"></i> Delete
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
