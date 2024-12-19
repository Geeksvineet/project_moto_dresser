<?php



if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login','_self')</script>";

}

else {

?>

<?php

if(isset($_GET['delete_product_reviews'])){

$delete_id = $_GET['delete_product_reviews'];

$delete_order = "delete from reviews where id='$delete_id'";

$run_delete = mysqli_query($con,$delete_order);

if($run_delete){

echo "<script>alert('Review Has Been Deleted')</script>";

echo "<script>window.open('index?view_product_reviews','_self')</script>";


}


}



?>



<?php }  ?>