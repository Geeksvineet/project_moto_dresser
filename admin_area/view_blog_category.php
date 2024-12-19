<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login','_self')</script>";
} else {
?>

<div class="row"><!-- 1 row Starts -->
    <div class="col-lg-12"><!-- col-lg-12 Starts -->
        <ol class="breadcrumb"><!-- breadcrumb Starts -->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Blog Categories
            </li>
        </ol><!-- breadcrumb Ends -->
    </div><!-- col-lg-12 Ends -->
</div><!-- 1 row Ends -->

<div class="row"><!-- 2 row Starts -->
    <div class="col-lg-12"><!-- col-lg-12 Starts -->
        <div class="panel panel-default"><!-- panel panel-default Starts -->
            <div class="panel-heading"><!-- panel-heading Starts -->
                <h3 class="panel-title">
                    <i class="fa fa-folder fa-fw"></i> View Blog Categories
                </h3>
            </div><!-- panel-heading Ends -->
            <div class="panel-body"><!-- panel-body Starts -->
                <div class="table-responsive"><!-- table-responsive Starts -->
                    <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->
                        <thead><!-- thead Starts -->
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead><!-- thead Ends -->
                        <tbody><!-- tbody Starts -->

                        <?php
                        $i = 0;
                        $get_categories = "SELECT * FROM blog_category";
                        $run_categories = mysqli_query($con, $get_categories);

                        while($row_categories = mysqli_fetch_array($run_categories)){
                            $category_id = $row_categories['id'];
                            $category_name = $row_categories['category'];
                            $category_description = $row_categories['description'];
                            $i++;
                        ?>

                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $category_name; ?></td>
                            <td><?php echo $category_description; ?></td>
                            <td>
                                <a href="index?delete_blog_category=<?php echo $category_id; ?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </td>
                            <td>
                                <a href="index?edit_blog_category=<?php echo $category_id; ?>">
                                    <i class="fa fa-pencil"></i> Edit
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
