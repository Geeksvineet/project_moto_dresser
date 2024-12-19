<?php



if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login','_self')</script>";

}

else {

?>

<?php

if(isset($_GET['delete_blog'])){

$delete_id = $_GET['delete_blog'];

$delete_pro2 = "select image from blog where id='$delete_id'";

$run_delete2 = mysqli_query($con,$delete_pro2);

$row_blogs2 = mysqli_fetch_array($run_delete2);

$image = $row_blogs2['image'];

unlink("blog_images/$image");

$delete_pro = "delete from blog where id='$delete_id'";

$run_delete = mysqli_query($con,$delete_pro);

if($run_delete){

echo "<script>alert('One blog Has been deleted')</script>";

echo "<script>window.open('index?view_blogs','_self')</script>";

}

}

?>

<?php } ?>