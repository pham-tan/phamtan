<?php 
include('../connection.php');
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
    $sql="SELECT anh FROM topdiemden WHERE id={$id}";
	$query_a=mysqli_query($conn,$sql);
	$anhInfo=mysqli_fetch_assoc($query_a);
	unlink('../'.$anhInfo['anh']);
	$query="DELETE FROM topdiemden WHERE id={$id}";
	$result=mysqli_query($conn,$query);
	header('location:list_topdiemden.php');
}
else
{
	header('location:list_topdiemden.php');
}
?>