<?php


if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login','_self')</script>";

}

else {


?>

<?php

if(isset($_GET['delete_blog_category'])){

$delete_id = $_GET['delete_blog_category'];

$delete_manufacturer = "delete from blog_category where id='$delete_id'";

$run_manufacturer = mysqli_query($con,$delete_manufacturer);

if($run_manufacturer){

echo "<script>alert('One blog category Has Been Deleted')</script>";
echo "<script>window.open('index?view_blog_category','_self')</script>";

}

}


?>


<?php } ?>