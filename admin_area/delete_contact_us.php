<?php



if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login','_self')</script>";

}

else {

?>

<?php

if(isset($_GET['delete_contact_us'])){

$delete_id = $_GET['delete_contact_us'];

$delete_order = "delete from contact where id='$delete_id'";

$run_delete = mysqli_query($con,$delete_order);

if($run_delete){

echo "<script>alert('contact Has Been Deleted')</script>";

echo "<script>window.open('index?view_contact_us','_self')</script>";


}


}



?>



<?php }  ?>