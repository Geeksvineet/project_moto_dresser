<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login','_self')</script>";
} else {
?>
    <?php
    if (isset($_GET['edit_testimonial'])) {
        $edit_testimonial = $_GET['edit_testimonial'];

        $get_testimonial = "SELECT * FROM testimonials WHERE id='$edit_testimonial'";
        $run_testimonial = mysqli_query($con, $get_testimonial);
        $row_testimonial = mysqli_fetch_array($run_testimonial);

        $t_id = $row_testimonial['id'];
        $t_name = $row_testimonial['t_name'];
        $t_message = $row_testimonial['t_message'];
    }
    ?>

    <div class="row"><!-- 1 row Starts -->
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / Edit Testimonial
                </li>
            </ol>
        </div>
    </div><!-- 1 row Ends -->

    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"> </i> Edit Testimonial
                    </h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-3 control-label"> Customer Name </label>
                            <div class="col-md-6">
                                <input type="text" name="t_name" class="form-control" value="<?php echo htmlspecialchars($t_name); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"> Testimonial Message </label>
                            <div class="col-md-6">
                                <textarea name="t_message" class="form-control" rows="5" required><?php echo htmlspecialchars($t_message); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"> </label>
                            <div class="col-md-6">
                                <input type="submit" name="update" class="form-control btn btn-primary" value=" Update Testimonial ">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- 2 row Ends -->

    <?php
    if (isset($_POST['update'])) {
        $t_name = $_POST['t_name'];
        $t_message = $_POST['t_message'];

        $update_testimonial = "UPDATE testimonials SET t_name='$t_name', t_message='$t_message', t_date_updated=NOW() WHERE id='$t_id'";
        $run_testimonial = mysqli_query($con, $update_testimonial);

        if ($run_testimonial) {
            echo "<script>alert('Testimonial Has Been Updated')</script>";
            echo "<script>window.open('index?view_testimonials','_self')</script>";
        }
    }
    ?>
<?php } ?>
