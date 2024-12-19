<?php

if (!isset($_SESSION['admin_email'])) {

    echo "<script>window.open('login','_self')</script>";
} else {


?>

    <div class="row"><!-- 1 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <ol class="breadcrumb"><!-- breadcrumb Starts -->

                <li>

                    <i class="fa fa-dashboard"></i> Dashboard / Insert Product Sub-Categories

                </li>

            </ol><!-- breadcrumb Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 1 row Ends -->


    <div class="row"><!-- 2 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <div class="panel panel-default"><!-- panel panel-default Starts -->

                <div class="panel-heading"><!-- panel-heading Starts -->

                    <h3 class="panel-title"><!-- panel-title Starts -->

                        <i class="fa fa-money fa-fw"></i> Insert Product Sub-Categories

                    </h3><!-- panel-title Ends -->

                </div><!-- panel-heading Ends -->

                <div class="panel-body"><!-- panel-body Starts -->

                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

                        <div class="form-group"><!-- form-group Starts -->

                            <label class="col-md-3 control-label">Product Sub-Categories Title</label>

                            <div class="col-md-6">

                                <input type="text" name="cat_title" class="form-control">

                            </div>

                        </div><!-- form-group Ends -->



                        <div class="form-group"><!-- form-group Starts -->

                            <label class="col-md-3 control-label"> Product Category </label>

                            <div class="col-md-6">

                                <select name="product_cat" class="form-control">

                                    <option> Select a Product Category </option>


                                    <?php

                                    $get_p_cats = "select * from product_categories";

                                    $run_p_cats = mysqli_query($con, $get_p_cats);

                                    while ($row_p_cats = mysqli_fetch_array($run_p_cats)) {

                                        $p_cat_id = $row_p_cats['p_cat_id'];

                                        $p_cat_title = $row_p_cats['p_cat_title'];

                                        echo "<option value='$p_cat_id' >$p_cat_title</option>";
                                    }


                                    ?>


                                </select>

                            </div>

                        </div><!-- form-group Ends -->



                        <div class="form-group"><!-- form-group Starts -->

                            <label class="col-md-3 control-label">Show as Product Sub-Categories Top</label>

                            <div class="col-md-6">

                                <input type="radio" name="cat_top" value="yes">

                                <label>Yes</label>

                                <input type="radio" name="cat_top" value="no">

                                <label>No</label>

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group Starts -->

                            <label class="col-md-3 control-label"></label>

                            <div class="col-md-6">

                                <input type="submit" name="submit" value="Insert Product Sub-Categories" class="btn btn-primary form-control">

                            </div>

                        </div><!-- form-group Ends -->

                    </form><!-- form-horizontal Ends -->

                </div><!-- panel-body Ends -->

            </div><!-- panel panel-default Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->

    <?php

    if (isset($_POST['submit'])) {

        $cat_title = $_POST['cat_title'];

        $cat_top = $_POST['cat_top'];

        $p_cat_id = $_POST['product_cat'];

        // $cat_image = $_FILES['cat_image']['name'];

        // $temp_name = $_FILES['cat_image']['tmp_name'];

        // move_uploaded_file($temp_name,"other_images/$cat_image");

        $insert_cat = "insert into categories (cat_title, cat_top, p_cat_id) values ('$cat_title', '$cat_top', '$p_cat_id')";

        $run_cat = mysqli_query($con, $insert_cat);

        if ($run_cat) {

            echo "<script> alert('New Category Has Been Inserted')</script>";

            echo "<script> window.open('index?view_cats','_self') </script>";
        }
    }



    ?>

<?php } ?>