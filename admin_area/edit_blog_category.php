<?php


if (!isset($_SESSION['admin_email'])) {

    echo "<script>window.open('login','_self')</script>";
} else {


?>

    <?php

    if (isset($_GET['edit_blog_category'])) {

        $edit_manufacturer = $_GET['edit_blog_category'];

        $get_manufacturer = "select * from blog_category where id='$edit_manufacturer'";

        $run_manufacturer = mysqli_query($con, $get_manufacturer);

        $row_manufacturer = mysqli_fetch_array($run_manufacturer);

        $m_id = $row_manufacturer['id'];

        $m_title = $row_manufacturer['category'];

        $m_top = $row_manufacturer['description'];
    }


    ?>

    <div class="row"><!-- 1 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <ol class="breadcrumb"><!-- breadcrumb Starts -->

                <li class="active">

                    <i class="fa fa-dashboard"></i> Dashboard / Edit blog category

                </li>

            </ol><!-- breadcrumb Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 1 row Ends -->


    <div class="row"><!-- 2 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <div class="panel panel-default"><!-- panel panel-default Starts -->

                <div class="panel-heading"><!-- panel-heading Starts -->

                    <h3 class="panel-title"><!-- panel-title Starts -->

                        <i class="fa fa-money fa-fw"> </i> Edit blog category

                    </h3><!-- panel-title Ends -->

                </div><!-- panel-heading Ends -->

                <div class="panel-body"><!-- panel-body Starts -->

                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

                        <div class="form-group"><!-- form-group Starts -->

                            <label class="col-md-3 control-label"> blog category </label>

                            <div class="col-md-6">

                                <input type="text" name="blog_category" class="form-control" value="<?php echo $m_title; ?>">

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->

                            <label class="col-md-3 control-label"> blog category description </label>

                            <div class="col-md-6">

                                <input type="text" name="blog_category_description" class="form-control" value="<?php echo $m_top; ?>">

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> </label>
                            <div class="col-md-6">
                                <input type="submit" name="update" class="form-control btn btn-primary" value=" Update Category ">
                            </div>
                        </div><!-- form-group Ends -->

                    </form><!-- form-horizontal Ends -->

                </div><!-- panel-body Ends -->

            </div><!-- panel panel-default Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->

    <?php

    if (isset($_POST['update'])) {

        $manufacturer_name = $_POST['blog_category'];

        $manufacturer_top = $_POST['blog_category_description'];

        $update_manufacturer = "update blog_category set category='$manufacturer_name', description='$manufacturer_top' where id='$m_id'";

        $run_manufacturer = mysqli_query($con, $update_manufacturer);

        if ($run_manufacturer) {

            echo "<script>alert('blog category Has Been Updated')</script>";

            echo "<script>window.open('index?view_blog_category','_self')</script>";
        }
    }

    ?>

<?php } ?>