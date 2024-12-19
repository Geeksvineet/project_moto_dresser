<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login','_self')</script>";
} else {
?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Insert Testimonial
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-comments fa-fw"></i> Insert Testimonial
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="" method="post">
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Customer Name </label>
                        <div class="col-md-6">
                            <input type="text" name="t_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Testimonial Message </label>
                        <div class="col-md-6">
                            <textarea name="t_message" class="form-control" rows="5" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> </label>
                        <div class="col-md-6">
                            <input type="submit" name="submit" class="form-control btn btn-primary" value="Insert Testimonial">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['submit'])){
    $t_name = mysqli_real_escape_string($con, $_POST['t_name']);
    $t_message = mysqli_real_escape_string($con, $_POST['t_message']);

    // SQL to insert into testimonials table
    $insert_testimonial = "INSERT INTO testimonials (t_name, t_message, t_date_created) VALUES ('$t_name', '$t_message', NOW())";
    $run_testimonial = mysqli_query($con, $insert_testimonial);

    if($run_testimonial){
        echo "<script>alert('New Testimonial Has Been Inserted')</script>";
        echo "<script>window.open('index?view_testimonials','_self')</script>";
    } else {
        echo "<script>alert('Error inserting testimonial')</script>";
    }
}
?>
<?php } ?>
