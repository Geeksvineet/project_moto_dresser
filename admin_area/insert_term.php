<?php

if (!isset($_SESSION['admin_email'])) {

  echo "<script>window.open('login','_self')</script>";
} else {


?>

  <script src="https://cdn.tiny.cloud/1/ilxmnvavt27i9067549554do76ljitygk312q7ka1ipem14k/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#term_and_con_desc',
      height: 500, // Editor height set karo
      plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'save table directionality emoticons template paste'
      ], // Enable more plugins
      toolbar: 'undo redo | styleselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify |' +
        'bullist numlist outdent indent | link image media | code preview fullscreen | forecolor backcolor emoticons |' +
        'table insertdatetime charmap hr anchor', // Add more buttons to the toolbar
      menubar: 'file edit view insert format tools table', // You can enable a full menubar too
      image_advtab: true, // Image advanced tab enabled
      branding: false, // Remove TinyMCE branding
      content_css: '//www.tiny.cloud/css/codepen.min.css' // Custom content CSS
    });
  </script>

  <div class="row"><!-- 1 row Starts -->

    <div class="col-lg-12"><!-- col-lg-12 Starts -->

      <ol class="breadcrumb"><!-- breadcrumb Starts -->

        <li class="active">

          <i class="fa fa-dashboard"></i> Dashboard / Insert Terms

        </li>

      </ol><!-- breadcrumb Ends -->

    </div><!-- col-lg-12 Ends -->

  </div><!-- 1 row Ends -->



  <div class="row"><!-- 2 row Starts -->


    <div class="col-lg-12"><!-- col-lg-12 Starts -->


      <div class="panel panel-default"><!-- panel panel-default Starts -->

        <div class="panel-heading"><!-- panel-heading Starts -->

          <h3 class="panel-title"><!-- panel-title Starts -->

            <i class="fa fa-money fa-fw"></i> Insert Terms

          </h3><!-- panel-title Ends -->

        </div><!-- panel-heading Ends -->

        <div class="panel-body"><!-- panel-body Starts -->

          <form class="form-horizontal" action="" method="post"><!-- form-horizontal Starts -->

            <div class="form-group"><!-- form-group Starts -->

              <label class="col-md-3 control-label"> Term Title </label>

              <div class="col-md-6"><!-- col-md-6 Starts -->

                <input type="text" name="term_title" class="form-control">

              </div><!-- col-md-6 Ends -->

            </div><!-- form-group Ends -->

            <div class="form-group"><!-- form-group Starts -->

              <label class="col-md-3 control-label"> Term Description </label>

              <div class="col-md-6"><!-- col-md-6 Starts -->

                <textarea id="term_and_con_desc" name="term_desc" class="form-control" rows="6" cols="19"></textarea>

              </div><!-- col-md-6 Ends -->

            </div><!-- form-group Ends -->

            <div class="form-group"><!-- form-group Starts -->

              <label class="col-md-3 control-label"> </label>

              <div class="col-md-6"><!-- col-md-6 Starts -->

                <input type="submit" name="submit" value="Insert Term" class="btn btn-primary form-control">

              </div><!-- col-md-6 Ends -->

            </div><!-- form-group Ends -->

          </form><!-- form-horizontal Ends -->

        </div><!-- panel-body Ends -->

      </div><!-- panel panel-default Ends -->


    </div><!-- col-lg-12 Ends -->

  </div><!-- 2 row Ends -->


  <?php

  if (isset($_POST['submit'])) {

    $term_title = $_POST['term_title'];

    $term_desc = mysqli_real_escape_string($con, $_POST['term_desc']);

    // $term_link = $_POST['term_link'];

    $insert_term = "insert into terms (term_title,term_desc) values ('$term_title','$term_desc')";

    $run_term = mysqli_query($con, $insert_term);

    if ($run_term) {

      echo "<script>alert('New Term Has Been Inserted')</script>";

      echo "<script>window.open('index?view_terms','_self')</script>";
    }
  }


  ?>


<?php } ?>