<?php ob_start(); ?>
<?php include('includes/header.php'); ?>
<?php include('../connection.php'); ?>
<script src="../js/formlogin.js"></script>
<style>
.required{color:red;}
</style>
<?php 
    if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
    {
        $id=$_GET['id'];
    }
    else
    {
        header('Location:list_user.php');
        exit();
    }
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
        if(empty($errors))
        {	$hoten=$_POST['hoten'];
			$dienthoai=$_POST['dienthoai'];
			$email=$_POST['email'];
			$diachi=$_POST['diachi'];
			$quyen=$_POST['quyen'];							
            $query_in="UPDATE user SET hoten='$hoten',sdt='$dienthoai',email='$email',diachi='$diachi',quyen='$quyen' WHERE id='$id'";
            $results_in=mysqli_query($conn,$query_in);
            if(mysqli_affected_rows($conn)==1)
            {
                echo "<p style='color:green;'>Sửa thành công</p>";
            }
            else
            {
                echo "<p class='required'>Bạn chưa sửa gì</p>";	
            }					
        }  
    }
    $query_id="SELECT username,hoten,sdt,email,diachi,quyen FROM user WHERE id='$id'";
    $results_id=mysqli_query($conn,$query_id);
    //Kiểm tra xem ID có tồn tại không
    if(mysqli_num_rows($results_id)==1)
    {
        list($taikhoan,$hoten,$dienthoai,$email,$diachi,$quyen)=mysqli_fetch_array($results_id,MYSQLI_NUM);				
    }
    else
    {
        header('Location:list_user.php');
        exit();
    }
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    	<form name="fredit_user" method="POST" action="#">
			<?php if(isset($message)){echo $message;}?>
			<h3>Sửa user</h3>
			<div class="form-group">
				<label>Tài khoản</label>
				<input type="text" name="taikhoan" value="<?php if(isset($taikhoan)){ echo $taikhoan;} ?>" class="form-control" required requiredmsg="Vui lòng nhập tài khoản!" placeholder="Tài khoản" disabled="true">				
			</div>
			<div class="form-group">
				<label>Họ tên</label>
				<input type="text" name="hoten" value="<?php if(isset($hoten)){ echo $hoten;} ?>" class="form-control" required requiredmsg="Vui lòng nhập họ tên!" placeholder="Họ tên">	
			</div>	
			<div class="form-group">
				<label>Điện thoại</label>
				<input type="text" name="dienthoai" value="<?php if(isset($dienthoai)){ echo $dienthoai;} ?>" class="form-control" required requiredmsg="Vui lòng nhập điện thoại!" placeholder="Điện thoại">
			</div>	
			<div class="form-group">
				<label>Email</label>
                <input type="text" name="email" value="<?php if(isset($email)){ echo $email;} ?>" class="form-control" required requiredmsg="Vui lòng nhập email!" placeholder="Email">
                <?php 
					if(isset($errors) && in_array('email',$errors))
					{
						echo "<p class='required'>Email không hợp lệ</p>";
					}
				?>
			</div>	
			<div class="form-group">
				<label>Địa chỉ</label>
				<input type="text" name="diachi" value="<?php if(isset($diachi)){ echo $diachi;} ?>" class="form-control" required requiredmsg="Vui lòng nhập địa chỉ!" placeholder="Địa chỉ">
			</div>
								
			<div class="form-group">
				<label style="display:block;">Chọn quyền</label>
                <?php if($quyen==1){ ?>
				<label class="radio-inline"><input checked="checked" type="radio" name="quyen" value="1">Quản trị</label>
				<label class="radio-inline"><input type="radio" name="quyen" value="0">Người dùng</label>
                <?php }else{ ?>
                <label class="radio-inline"><input type="radio" name="quyen" value="1">Quản trị</label>
				<label class="radio-inline"><input checked="checked" type="radio" name="quyen" value="0">Người dùng</label>
                <?php } ?>
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value="Sửa user">
		</form>
	</div>
</div>
<?php include('includes/footer.php'); ?>
<?php ob_flush(); ?>