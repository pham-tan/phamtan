<?php 
include('../connection.php');
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
    $id=$_GET['id'];
    $sql="SELECT anh,anh_thumb FROM khachsan WHERE id={$id}";
	$query_a=mysqli_query($conn,$sql);
	$anhInfo=mysqli_fetch_assoc($query_a);
	unlink('../'.$anhInfo['anh']);
	unlink('../'.$anhInfo['anh_thumb']);
	$query="DELETE FROM khachsan WHERE id={$id}";
	$result=mysqli_query($conn,$query);
	header('Location: list_ks.php');
}
else
{
	header('Location: list_ks.php');
}
?>