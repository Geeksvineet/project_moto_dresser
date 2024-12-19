<?php



if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login','_self')</script>";

}

else {

?>

<?php

if(isset($_GET['delete_user_cart'])){

$delete_id = $_GET['delete_user_cart'];

$delete_order = "delete from cart where id='$delete_id'";

$run_delete = mysqli_query($con,$delete_order);

if($run_delete){

echo "<script>alert('cart product Has Been Deleted')</script>";

echo "<script>window.open('index?view_user_cart','_self')</script>";


}


}



?>



<?php }  ?>