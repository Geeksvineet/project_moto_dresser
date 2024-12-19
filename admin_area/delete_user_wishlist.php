<?php



if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login','_self')</script>";

}

else {

?>

<?php

if(isset($_GET['delete_user_wishlist'])){

$delete_id = $_GET['delete_user_wishlist'];

$delete_order = "delete from wishlist where wishlist_id='$delete_id'";

$run_delete = mysqli_query($con,$delete_order);

if($run_delete){

echo "<script>alert('user wishlist Has Been Deleted')</script>";

echo "<script>window.open('index?view_user_wishlist','_self')</script>";


}


}



?>



<?php }  ?>