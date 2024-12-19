<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login','_self')</script>";
} else {
?>
    <div class="row"><!--  1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / View Blogs
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!--  1 row Ends -->

    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title"><!-- panel-title Starts -->
                        <i class="fa fa-book fa-fw"></i> View Blogs
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
                                    <th>Category</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 0;
                                $get_blogs = "SELECT * FROM blog";
                                $run_blogs = mysqli_query($con, $get_blogs);

                                while ($row_blogs = mysqli_fetch_array($run_blogs)) {
                                    $blog_id = $row_blogs['id'];
                                    $blog_title = $row_blogs['title'];
                                    $blog_image = $row_blogs['image'];
                                    $blog_category_id = $row_blogs['category'];

                                    $get_blogs1 = "SELECT * FROM blog_category where id='$blog_category_id'";
                                    $run_blogs1 = mysqli_query($con, $get_blogs1);
                                    $row_blogs1 = mysqli_fetch_array($run_blogs1);

                                    $blog_category = $row_blogs1['category'];

                                    $date_created = $row_blogs['date_created'];
                                    $date_updated = $row_blogs['date_updated'];

                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $blog_title; ?></td>
                                        <td><img src="blog_images/<?php echo $blog_image; ?>" width="60" height="60"></td>
                                        <td><?php echo $blog_category; ?></td>
                                        <td><?php echo $date_created; ?></td>
                                        <td><?php echo $date_updated; ?></td>
                                        <td>
                                            <a href="index?delete_blog=<?php echo $blog_id; ?>">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </td>
                                        <td>
                                            <a href="index?edit_blog=<?php echo $blog_id; ?>">
                                                <i class="fa fa-pencil"></i> Edit
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