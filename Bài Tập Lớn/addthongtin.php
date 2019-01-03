<?php 
include('connection.php');
session_start();
$id=$_POST['id'];
$ngaynhan=$_POST['ngaynhan'];
$ngaytra=$_POST['ngaytra'];
$soluong=$_POST['soluong'];
$_SESSION['iddatphong']=$id;
$_SESSION['ngaynhandat']=$ngaynhan;
$_SESSION['ngaytradat']=$ngaytra;
$_SESSION['soluongdat']=$soluong;
$ngaynhan_ht=explode("-",$ngaynhan);
$ngaynhan_in=$ngaynhan_ht[2].'-'.$ngaynhan_ht[1].'-'.$ngaynhan_ht[0];
$ngaytra_ht=explode("-",$ngaytra);
$ngaytra_in=$ngaytra_ht[2].'-'.$ngaytra_ht[1].'-'.$ngaytra_ht[0];
$first_date = strtotime($ngaytra_in);
$second_date = strtotime($ngaynhan_in);
$datediff = abs($first_date - $second_date);
$sodem=floor($datediff / (60*60*24));
$sql1="SELECT * FROM loaiphong WHERE id={$id}";
$query_a1=mysqli_query($conn,$sql1);
$dm_info1=mysqli_fetch_assoc($query_a1);
$sql2="SELECT * FROM khachsan WHERE id={$dm_info1['idks']}";
$query_a2=mysqli_query($conn,$sql2);
$dm_info2=mysqli_fetch_assoc($query_a2);
$sql4="SELECT max(id) as dem FROM datphong";
$query_a4=mysqli_query($conn,$sql4);
$dm_info4=mysqli_fetch_assoc($query_a4);
if(isset($dm_info4['dem'])){
    $dem=$dm_info4['dem'];
    $dem++;
}
else{
    $dem=1;
}
$sotien=$dm_info1['giakm']*$sodem;
$sotienthue=round($soluong*(($dm_info1['giakm']*$sodem)*($dm_info2['thue']/100)));
$tong=$sotien+$sotienthue;
date_default_timezone_set('Asia/Ho_Chi_Minh');
$todaytime=date('g:i A');
$today=date('Y-m-d');
$madat=$id.$dm_info1['idks'].$dem;
if(isset($_SESSION['id'])){
    $sql3="SELECT * FROM user WHERE id={$_SESSION['id']}";
    $query_a3=mysqli_query($conn,$sql3);
    $dm_info3=mysqli_fetch_assoc($query_a3);
}
$query_in="INSERT INTO datphong(idlp,idks,hoten,diachi,dienthoai,email,madat,ngaynhan,ngaytra,giodat,ngaydat,slphong,sotienthue,tongtien,sodem)
			VALUES('$id',{$dm_info1['idks']},'{$dm_info3['hoten']}','{$dm_info3['diachi']}','{$dm_info3['sdt']}','{$dm_info3['email']}','$madat','$ngaynhan_in','$ngaytra_in','$todaytime','$today','$soluong','$sotienthue','$tong','$sodem')";
			$results_in=mysqli_query($conn,$query_in);
if(mysqli_affected_rows($conn)==1)
{   
    $sql5="SELECT max(id) as id1 FROM datphong";
    $query_a5=mysqli_query($conn,$sql5);
    $dm_info5=mysqli_fetch_assoc($query_a5);
    $_SESSION['iddp']=$dm_info5['id1'];
    echo "<p class='required'>Thêm mới thành công</p>";
}
else
{
    echo "<p class='required'>Thêm mới không thành công</p>";	
}
?>