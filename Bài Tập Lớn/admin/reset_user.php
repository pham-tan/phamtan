<?php ob_start(); ?>
<?php include('includes/header.php'); ?>
<?php include('../connection.php'); ?>
<script src="../js/formlogin.js"></script>
<style type="text/css">
.required
{
	 color:red;
}
</style>
<div class="row">
	<?php 
		if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
		{
			$id=$_GET['id'];
		}
		else
		{
			header('Location: list_user.php');
			exit();
		}
		if(isset($_POST['submit']))
		{			
			$matkhaumoi=md5($_POST['matkhaumoi']);
			if($_POST['matkhaumoi']!=$_POST['matkhaumoire'])
			{
				$messag="<p class='required'>Xác nhận mật khẩu sai</p>";
			}
			else
			{
				$query_up="UPDATE user SET password='$matkhaumoi' WHERE id='$id'";
				$results_up=mysqli_query($conn,$query_up);
				if(mysqli_affected_rows($conn)==1)
				{
					$message="<p style='color:green;'>Reset mật khẩu thành công</p>";
				}
				else
				{
					$message="<p class='required'>Reset mật khẩu không thành công</p>";	
				}
			}			
		}
		$query_id="SELECT username FROM user WHERE id='$id'";
		$results_id=mysqli_query($conn,$query_id);
		//Kiểm tra xem ID có tồn tại không
		if(mysqli_num_rows($results_id)==1)
		{
			list($taikhoan)=mysqli_fetch_array($results_id,MYSQLI_NUM);				
		}
		else
		{
			$message="<p class='required'>ID user không tồn tại</p>";
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
			<h3>Reset mật khẩu</h3>
			<div class="form-group">
				<label>Tài khoản</label>
				<input type="text" name="taikhoan" value="<?php if(isset($taikhoan)){ echo $taikhoan;} ?>" class="form-control" disabled="true">
			</div>			
			<div class="form-group">
				<label>Mật khẩu mới</label>
				<input type="password" name="matkhaumoi" required requiredmsg="Vui lòng nhập mật khẩu mới!" value="" class="form-control">
			</div>
			<div class="form-group">
				<label>Xác nhận mật khẩu mới</label>
				<input type="password" name="matkhaumoire" required requiredmsg="Vui lòng nhập xác nhận mật khẩu!" value="" class="form-control">
                <?php if(isset($messag)){echo $messag;} ?>
			</div>
			<input type="submit" name="submit" value="Reset mật khẩu" class="btn btn-primary">
		</form>
	</div>
</div>
<?php include('includes/footer.php') ?>
<?php ob_flush(); ?>