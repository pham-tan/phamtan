<?php 
include('../connection.php');
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)) && isset($_GET['idks']) && filter_var($_GET['idks'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
	$idks=$_GET['idks'];
    $sql="SELECT anh,anh_thumb FROM loaiphong WHERE id={$id}";
	$query_a=mysqli_query($conn,$sql);
	$anhInfo=mysqli_fetch_assoc($query_a);
	unlink('../'.$anhInfo['anh']);
	unlink('../'.$anhInfo['anh_thumb']);
	$query="DELETE FROM loaiphong WHERE id={$id}";
	$result=mysqli_query($conn,$query);
	$u='list_loaiphong.php?id=';
	header('location:'.$u.$idks);
}
else
{
	header('location:index.php');
}
?>