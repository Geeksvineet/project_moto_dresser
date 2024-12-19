<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login','_self')</script>";
} else {
?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Testimonials
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-comments fa-fw"></i> View Testimonials
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Message</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_testimonials = "SELECT * FROM testimonials ORDER BY t_date_created DESC";
                            $run_testimonials = mysqli_query($con, $get_testimonials);

                            while($row_testimonials = mysqli_fetch_array($run_testimonials)){
                                $testimonial_id = $row_testimonials['id'];
                                $t_name = $row_testimonials['t_name'];
                                $t_message = $row_testimonials['t_message'];
                                $t_date_created = date('F j, Y', strtotime($row_testimonials['t_date_created']));
                                $t_date_updated = date('F j, Y', strtotime($row_testimonials['t_date_updated']));
                                $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($t_name); ?></td>
                                <td><?php echo htmlspecialchars($t_message); ?></td>
                                <td><?php echo $t_date_created; ?></td>
                                <td><?php echo $t_date_updated; ?></td>
                                <td>
                                    <a href="index?edit_testimonial=<?php echo $testimonial_id; ?>">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                </td>
                                <td>
                                    <a href="index?delete_testimonial=<?php echo $testimonial_id; ?>" onclick="return confirm('Are you sure you want to delete this testimonial?');">
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
