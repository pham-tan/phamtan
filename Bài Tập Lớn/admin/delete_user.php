<?php 
include('../connection.php');
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
	$query="DELETE FROM user WHERE id={$id}";
	$result=mysqli_query($conn,$query);
	header('Location: list_user.php');
}
else
{
	header('Location: list_user.php');
}
?>