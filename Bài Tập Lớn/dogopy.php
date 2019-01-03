<?php 
include('connection.php');
$nameu=$_POST['nameu'];
$ngaydang=$_POST['ngaydang'];
$hoten=$_POST['hoten'];
$dienthoai=$_POST['dienthoai'];
$diachi=$_POST['diachi'];
$email=$_POST['email'];
$noidung=$_POST['noidung'];
//insert vào trong database
$query="INSERT INTO lienhe(ngaydang,nameu,hoten,dienthoai,diachi,email,noidung,status)
		VALUES('$ngaydang','$nameu','$hoten','$dienthoai','$diachi','$email','$noidung',0)";
$results=mysqli_query($conn,$query);	
?>