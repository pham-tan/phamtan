<?php include('includes/header.php'); ?>
<?php include('../connection.php'); ?>
<script src="../js/formlogin.js"></script>
<style>
.required{color:red;}
</style>
<div class="row">
	<?php
		if(isset($_POST['submit']))
		{
			$matkhaucu=md5(($_POST['matkhaucu']));
			$matkhaumoi=md5($_POST['matkhaumoi']);
			$query="SELECT id,password FROM user WHERE password='$matkhaucu' AND id='{$_SESSION['id']}'";
			$results=mysqli_query($conn,$query);
			if(mysqli_num_rows($results)==1)
			{
				if($_POST['matkhaumoi'] != $_POST['matkhaumoire'])
				{
					$messag="<p class='required'>Mật khẩu mới không giống nhau</p>";
				}
				else
				{
					$query_up="UPDATE user SET password='$matkhaumoi' WHERE id='{$_SESSION['id']}'";
					$results_up=mysqli_query($conn,$query_up);
					if(mysqli_affected_rows($conn)==1)
					{
						$message="<p style='color:green;'>Đổi mật khẩu thành công</p>";
					}
					else
					{
						$message="<p class='required'>Đổi mật khẩu không thành công</p>";	
					}
				}
			}
			else
			{
				$messages="<p class='required'>Mật khẩu cũ không đúng</p>";
			}
		}
	?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<?php 
			if(isset($message))
			{
				echo $message;
			}
		?>
		<form name="frmdoimatkhau" method="POST">
			<h3>Đổi mật khẩu</h3>
			<div class="form-group">
				<label>Tài khoản</label>
				<input type="text" name="taikhoan" value="<?php echo $_SESSION['username']; ?>" class="form-control" disabled="true">
			</div>
			<div class="form-group">
				<label>Mật khẩu cũ</label>
				<input type="password" name="matkhaucu" required requiredmsg="Vui lòng nhập mật khẩu cũ!" value="" class="form-control">
                <?php if(isset($messages)){echo $messages;} ?>
			</div>
			<div class="form-group">
				<label>Mật khẩu mới</label>
				<input type="password" name="matkhaumoi" required requiredmsg="Vui lòng nhập mật khẩu mới!" value="" class="form-control">
			</div>
			<div class="form-group">
				<label>Xác nhận mật khẩu mới</label>
				<input type="password" name="matkhaumoire" required requiredmsg="Vui lòng nhập lại mật khẩu mới!" value="" class="form-control">
                <?php if(isset($messag)){echo $messag;} ?>
			</div>
			<input type="submit" name="submit" value="Đổi mật khẩu" class="btn btn-primary">
		</form>
	</div>
</div>
<?php include('includes/footer.php'); ?>