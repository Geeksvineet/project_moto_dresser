<?php


if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login','_self')</script>";

}

else {


?>

<?php

if(isset($_GET['delete_testimonial'])){

$delete_id = $_GET['delete_testimonial'];

$delete_manufacturer = "delete from testimonials where id='$delete_id'";

$run_manufacturer = mysqli_query($con,$delete_manufacturer);

if($run_manufacturer){

echo "<script>alert('One testimonial Has Been Deleted')</script>";
echo "<script>window.open('index?view_testimonials','_self')</script>";

}

}


?>


<?php } ?>