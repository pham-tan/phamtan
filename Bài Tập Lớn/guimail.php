<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title></title>
		<meta name='' content=''>
	</head>
	<body>
		<?php 
			include('inc/function.php');
			if(isset($_POST['submit']))
			{
				$hoten=$_POST['hoten'];
				$diachi=$_POST['diachi'];
				$dienthoai=$_POST['dienthoai'];
				$email=$_POST['email'];
				$noidung=$_POST['noidung'];
				$noidung_lh='<p><h3><strong>Thông tin liên hệ</strong></h3></p>
							<p><strong>Họ tên:</strong> '.$hoten.'</p>
							<p><strong>Địa chỉ:</strong> '.$diachi.'</p>
							<p><strong>Điện thoai:</strong> '.$dienthoai.'</p>
							<p><strong>Email:</strong> '.$email.'</p>
							<p><strong>Nội dung:</strong> '.$noidung.'</p>';
				include('inc/class.phpmailer.php');
				include('inc/class.pop3.php');
				define('GUSER','anhtan98abc@gmail.com');
				define('GPWD','tantayen');
				global $message;
				smtpmailer("anhtan98abc@gmail.com",'anhtan98abc@gmail.com','Send mail','Thông tin liên hệ',$noidung_lh);
				echo "Gửi mail thành công";
			}
		?>
		<form name="frmguimail" method="POST">
			<table>
				<tr>
					<td>Họ tên</td>
				</tr>	
				<tr>
					<td><input type="text" name="hoten" value=""></td>
				</tr>
				<tr>
					<td>Địa chỉ</td>
				</tr>	
				<tr>
					<td><input type="text" name="diachi" value=""></td>
				</tr>
				<tr>
					<td>Điện thoại</td>
				</tr>	
				<tr>
					<td><input type="text" name="dienthoai" value=""></td>
				</tr>
				<tr>
					<td>Email</td>
				</tr>	
				<tr>
					<td><input type="text" name="email" value=""></td>
				</tr>
				<tr>
					<td>Nội dung</td>
				</tr>	
				<tr>
					<td><textarea name="noidung"></textarea></td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" value="Gửi mail"></td>
				</tr>
			</table>
		</form>
	</body>
</html>