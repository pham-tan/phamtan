<?php include('includes/header.php'); ?>
<?php include('./connection.php'); ?>
<?php if(!isset($_SESSION['username'])){header('location:ĐPKS.php');} ?>
<script src="./js/formlogin.js"></script>
<style>
.required{color:red;}
#pham{
    background-image: url('./image/background.jpg');
    background-repeat: no-repeat;
    background-size: 99% 100%;
}
</style>
<?php 
    $id=$_SESSION['id'];
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
            $query_in="UPDATE user SET hoten='$hoten',sdt='$dienthoai',email='$email',diachi='$diachi' WHERE id='$id'";
            $results_in=mysqli_query($conn,$query_in);
            if(mysqli_affected_rows($conn)==1)
            {   
                if(isset($_SESSION['iddp'])){
                $query_in1="UPDATE datphong SET hoten='$hoten',dienthoai='$dienthoai',email='$email',diachi='$diachi' WHERE id={$_SESSION['iddp']}";
                    $results_in1=mysqli_query($conn,$query_in1);
                }
                $message="<p style='color:green;'>Sửa thành công</p>";
            }
            else
            {
                $message="<p class='required'>Bạn chưa sửa gì</p>";	
            }					
        }  
    }
    $query_id="SELECT username,hoten,sdt,email,diachi FROM user WHERE id='$id'";
    $results_id=mysqli_query($conn,$query_id);
    //Kiểm tra xem ID có tồn tại không
    if(mysqli_num_rows($results_id)==1)
    {
        list($taikhoan,$hoten,$dienthoai,$email,$diachi)=mysqli_fetch_array($results_id,MYSQLI_NUM);				
    }
    else 
    {
        
    }
?>
<div class="bootstrap-iso">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" id="pham">
            <form name="fredit_user" method="POST" action="#" style="margin:70px auto 120px auto;padding:0 20px 0 20px;width:400px;background-color:#EEF9FF;">
                <h3>Sửa user</h3>
                <?php if(isset($message)){echo $message;}?>
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
                <input type="submit" name="submit" class="btn btn-primary" value="Sửa user">
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>