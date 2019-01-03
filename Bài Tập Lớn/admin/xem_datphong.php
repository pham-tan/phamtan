<?php ob_start(); ?>
<?php include('includes/header.php'); ?>
<?php include('../connection.php');?>
<?php include('../inc/function.php');?>
<script src="../js/formlogin.js"></script>
<style>
.required{color:red;}
</style>
<?php
    include('../inc/images_helper.php');
    if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
    {
        $id=$_GET['id'];
    }
    else
    {
        header('Location:list_datphong.php');
        exit();
    }
    if(isset($_POST['submit'])){
        $thanhtoan=$_POST['thanhtoan'];
        $status=$_POST['status'];
			$query_in="UPDATE datphong SET thanhtoan='$thanhtoan',status='$status' where id='$id'";
			$results_in=mysqli_query($conn,$query_in);
			if(mysqli_affected_rows($conn)==1)
			{
				echo "<p style='color:green;'>Sửa thành công</p>";
			}
			else
			{
				echo "<p class='required'>Bạn chưa sửa gì!</p>";	
            }
    }
        $query_id="SELECT idlp,idks,ngaynhan,ngaytra,madat,thanhtoan,status,hoten,dienthoai,email,diachi,slphong,sotienthue,tongtien,sodem FROM datphong WHERE id={$id}";
        $result_id=mysqli_query($conn,$query_id);
        //Kiểm tra xem ID có tồn tại không
        if(mysqli_num_rows($result_id)==1)
        {
            list($idlp,$idks,$ngaynhan,$ngaytra,$madat,$thanhtoan,$status,$hoten,$dienthoai,$email,$diachi,$slphong,$sotienthue,$tongtien,$sodem)=mysqli_fetch_array($result_id,MYSQLI_NUM);
            $sql1="SELECT * FROM loaiphong WHERE id={$idlp}";
            $query_a1=mysqli_query($conn,$sql1);
            $dm_info1=mysqli_fetch_assoc($query_a1);
            $sql2="SELECT * FROM khachsan WHERE id={$idks}";
            $query_a2=mysqli_query($conn,$sql2);
            $dm_info2=mysqli_fetch_assoc($query_a2);
        }
        else
        {
            header('Location:list_datphong.php');
            exit();
        }
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    	<form name="frmedit_ks" method="POST" action="#" enctype="multipart/form-data">
			<?php if(isset($message)){echo $message;}?>
			<h3>Xem thông tin đặt phòng</h3>
            <div class="form-group">
				<label>Mã đơn hàng</label>
				<input type="text" name="" disabled="true" value="<?php if(isset($madat)){ echo $madat;} ?>" class="form-control" required requiredmsg="Vui lòng nhập khách sạn!" placeholder="Tên khách sạn">				
			</div>	
			<div class="form-group">
				<label>Khách sạn</label>
				<input type="text" name="khachsan" disabled="true" value="<?php if(isset($dm_info1['title'])){ echo $dm_info1['title'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập khách sạn!" placeholder="Tên khách sạn">				
			</div>	
			<div class="form-group">
				<label>Tên phòng khách sạn</label>
				<input type="text" name="giagoc" disabled="true" value="<?php if(isset($dm_info2['title'])){ echo $dm_info2['title'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập giá gốc!" placeholder="Giá gốc">	
			</div>	
			<div class="form-group">
				<label>Tổng số tiền</label>
				<input type="text" name="giakm" disabled="true" value="<?php if(isset($tongtien)){ echo number_format($tongtien,0,'.','.').' đ';} ?>" class="form-control" required requiredmsg="Vui lòng nhập giá khuyến mãi!" placeholder="Giá khuyến mãi">
				<?php if(isset($mess)){echo $mess;} ?>
			</div>
			<div class="form-group">
				<label>Tỏng thuế</label>
				<input type="text" name="slphong" disabled="true" value="<?php if(isset($sotienthue)){ echo number_format($sotienthue,0,'.','.').' đ';} ?>" class="form-control" required requiredmsg="Vui lòng nhập số lượng phòng!" placeholder="Số lượng phòng">
			</div>	
			<div class="form-group">
				<label>Số đêm</label>
				<input type="text" name="songuoi" disabled="true" value="<?php if(isset($sodem)){ echo $sodem;} ?>" class="form-control" required requiredmsg="Vui lòng nhập số người!" placeholder="Số người">
			</div>
            <div class="form-group">
				<label>Số lượng phòng đặt</label>
				<input type="text" name="songuoi" disabled="true" value="<?php if(isset($slphong)){ echo $slphong;} ?>" class="form-control" required requiredmsg="Vui lòng nhập số người!" placeholder="Số người">
			</div>
			<div class="form-group">
				<label>Họ tên</label>
				<input type="text" name="thue" disabled="true" value="<?php if(isset($hoten)){ echo $hoten;} ?>" class="form-control" required requiredmsg="Vui lòng nhập thuế!" placeholder="Thuế">
			</div>
			<div class="form-group">
				<label>Điện thoại</label>
				<input name="tomtat" disabled="true"  class="form-control" value="<?php if(isset($dienthoai)){ echo $dienthoai;} ?>">
			</div>
			<div class="form-group">
				<label>Email</label>
				<input id="" disabled="true" name="" class="form-control"  value="<?php if(isset($email)){ echo $email;} ?>">
			</div>
			<div class="form-group">
				<label>Địa chỉ</label>
				<input name="diachi" disabled="true" class="form-control" value="<?php if(isset($diachi)){ echo $diachi;} ?>" placeholder="Địa chỉ">
			</div>
            <div class="form-group">
				<label>Ngày nhận</label>
                <?php 
					if(isset($ngaynhan))
					{
						$ngaydang_cu=explode('-',$ngaynhan);
						$ngaydang_cu_m=$ngaydang_cu[2].'-'.$ngaydang_cu[1].'-'.$ngaydang_cu[0];
					}
				?>
					<input class="form-control" disabled="true" type="text" value="<?php echo $ngaydang_cu_m; ?>" id="ngaydang_edit" name="ngaydang"> 
			</div>
            <div class="form-group">
				<label>Ngày trả</label>
                <?php 
					if(isset($ngaytra))
					{
						$ngaydang_cu=explode('-',$ngaytra);
						$ngaydang_cu_m=$ngaydang_cu[2].'-'.$ngaydang_cu[1].'-'.$ngaydang_cu[0];
					}
				?>
					<input class="form-control" disabled="true" type="text" value="<?php echo $ngaydang_cu_m; ?>" id="ngaydang_edit" name="ngaydang"> 
			</div>
            <div class="form-group">
				<label>Thanh toán</label>
				<input name="thanhtoan" class="form-control" value="<?php if(isset($thanhtoan)){ echo $thanhtoan;} ?>"required requiredmsg="Vui lòng nhập thanh toán!">
			</div>
			<div class="form-group">
				<label style="display:block;">Trạng thái</label>
                <?php
					if($status==1)
					{
					?>
					<label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Xác nhận đặt phòng</label>
					<label class="radio-inline"><input type="radio" name="status" value="0">Đang kiểm tra</label>
					<?php 
					}
					else
					{
					?>
					<label class="radio-inline"><input type="radio" name="status" value="1">Xác nhận đặt phòng</label>
					<label class="radio-inline"><input checked="checked" type="radio" name="status" value="0">Đang kiểm tra</label>
					<?php		
					}
				?>
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value="Sửa thanh toán">
		</form>
	</div>
</div>
<?php include('includes/footer.php'); ?> 
<?php ob_flush(); ?>