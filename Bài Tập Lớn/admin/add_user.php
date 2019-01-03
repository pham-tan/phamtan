<?php include('includes/header.php'); ?>
<script src="../js/formlogin.js"></script>
<style>
.required{color:red;}
</style>
<?php 
	include('../connection.php');
	if(isset($_POST['submit'])){
		$errors=array();
		if(filter_var(($_POST['email']),FILTER_VALIDATE_EMAIL)==TRUE)
		{
			$email=mysqli_real_escape_string($conn,$_POST['email']);
		}
		else
		{
			$errors[]='email';
		}
		if(empty($errors)){
			$taikhoan=$_POST['taikhoan'];
			$matkhau=$_POST['matkhau'];
			$matkhaure=$_POST['matkhaure'];
			$hoten=$_POST['hoten'];
			$dienthoai=$_POST['dienthoai'];
			$email=$_POST['email'];
			$diachi=$_POST['diachi'];
			$quyen=$_POST['quyen'];
			if($_POST['matkhau']!=$_POST['matkhaure'])
			{$mess="<p class='required'>Xác nhận mật khẩu sai!</p>";}
			else{
				$query="SELECT username FROM user WHERE username='$taikhoan'";
				$results=mysqli_query($conn,$query);
				$query2="SELECT email FROM user WHERE email='$email'";
				$results2=mysqli_query($conn,$query2);
				if(mysqli_num_rows($results)>0)
				{
					$message="<p class='required'>Tài khoản đã tồn tại, yêu cầu bạn nhập tài khoản khác!</p>";
				}
				elseif(mysqli_num_rows($results2)>0)
				{
					$message="<p class='required'>Email đã tồn tại, yêu cầu bạn nhập email khác!</p>";	
				}
				else
				{					
					$query_in="INSERT INTO user(username,password,hoten,sdt,email,diachi,quyen)
					VALUES('$taikhoan','$matkhau','$hoten','$dienthoai','$email','$diachi','$quyen')";
					$results_in=mysqli_query($conn,$query_in);
					if(mysqli_affected_rows($conn)==1)
					{
						echo "<p style='color:green;'>Thêm mới thành công</p>";
					}
					else
					{
						echo "<p class='required'>Thêm mới không thành công</p>";	
					}
				}
			}
		}
	}
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    	<form name="frmadd_user" method="POST" action="#">
			<?php if(isset($message)){echo $message;}?>
			<h3>Thêm user</h3>
			<div class="form-group">
				<label>Tài khoản</label>
				<input type="text" name="taikhoan" value="<?php if(isset($_POST['taikhoan'])){ echo $_POST['taikhoan'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập tài khoản!" placeholder="Tài khoản">				
			</div>	
			<div class="form-group">
				<label>Mật khẩu</label>
				<input type="password" name="matkhau" value="" class="form-control" required requiredmsg="Vui lòng nhập mật khẩu!" placeholder="Mật khẩu">	
			</div>	
			<div class="form-group">
				<label>Xác nhận mật khẩu</label>
				<input type="password" name="matkhaure" value="" class="form-control" required requiredmsg="Vui lòng nhập xác nhận mật khẩu!" placeholder="Xác nhận mật khẩu">
				<?php if(isset($mess)){echo $mess;} ?>
			</div>	
			<div class="form-group">
				<label>Họ tên</label>
				<input type="text" name="hoten" value="<?php if(isset($_POST['hoten'])){ echo $_POST['hoten'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập họ tên!" placeholder="Họ tên">	
			</div>	
			<div class="form-group">
				<label>Điện thoại</label>
				<input type="text" name="dienthoai" value="<?php if(isset($_POST['dienthoai'])){ echo $_POST['dienthoai'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập điện thoại!" placeholder="Điện thoại">
			</div>	
			<div class="form-group">
				<label>Email</label>
				<input type="text" name="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập email!" placeholder="Email">
				<?php 
					if(isset($errors) && in_array('email',$errors))
					{
						echo "<p class='required'>Email không hợp lệ</p>";
					}
				?>
			</div>	
			<div class="form-group">
				<label>Địa chỉ</label>
				<input type="text" name="diachi" value="<?php if(isset($_POST['diachi'])){ echo $_POST['diachi'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập địa chỉ!" placeholder="Địa chỉ">
			</div>
								
			<div class="form-group">
				<label style="display:block;">Chọn quyền</label>
				<label class="radio-inline"><input type="radio" name="quyen" value="1">Quản trị</label>
				<label class="radio-inline"><input checked="checked" type="radio" name="quyen" value="0">Người dùng</label>
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value="Thêm mới">
		</form>
	</div>
</div>
<?php include('includes/footer.php'); ?> 