<?php include('includes/header.php'); ?>
<?php include('../connection.php');?>
<?php include('../inc/function.php'); ?>
<script src="../js/formlogin.js"></script>
<style>
.required{color:red;}
</style>
<script language="javascript">
	function checkall(class_name,obj)
	{
		var items = document.getElementsByClassName(class_name);
		if(obj.checked == true)
		{
			for(i=0;i<items.length;i++)
				items[i].checked = true;
		}
		else
		{
			for(i=0;i<items.length;i++)
				items[i].checked = false;	
		}
	}
</script>
<?php
    include('../inc/images_helper.php');
    if(isset($_POST['submit'])){
		if($_POST['parent']==0)
		{
			$parent_id=0;
		}
		else
		{
			$parent_id=$_POST['parent'];	
		}
        $khachsan=$_POST['khachsan'];
        $giagoc=$_POST['giagoc'];
        $giakm=$_POST['giakm'];
        $slphong=$_POST['slphong'];
        $songuoi=$_POST['songuoi'];
        $noidung=$_POST['noidung'];
		$status=$_POST['status'];
		$tomtat=$_POST['tomtat'];
		$diachi=$_POST['diachi'];
		$thanhpho=$_POST['thanhpho'];
		$thue=$_POST['thue'];
        //upload hình ảnh
        if ($_FILES['img']['size']=='') {
			$message="<p class='required'>Bạn chưa nhập file ảnh<p>";
		}
		else
		{
            if(($_FILES['img']['type']!="image/gif")
            &&($_FILES['img']['type']!="image/png")
            &&($_FILES['img']['type']!="image/jpeg")
            &&($_FILES['img']['type']!="image/jpg"))
            { 
                $message="<p class='required'>File không đúng định dạng</p>";	
            }
            elseif ($_FILES['img']['size']>1000000) 
            {
                $message="<p class='required'>Kích thước phải nhỏ hơn 1MB</p>";						
            }
            else
            {
                $img=$_FILES['img']['name'];
                $link_img='upload/'.$img;
                move_uploaded_file($_FILES['img']['tmp_name'],"../upload/".$img);																														
                //Xử lý Resize, Crop hình anh
                $temp=explode('.',$img);
                if($temp[1]=='jpeg' or $temp[1]=='JPEG')
                {
                    $temp[1]='jpg';
                }
                $temp[1]=strtolower($temp[1]);
                $thumb='upload/resized/'.$temp[0].'_thumb'.'.'.$temp[1];
                $imageThumb=new Image('../'.$link_img);
                //Resize anh						
                if($imageThumb->getWidth()>700)
                {
                    $imageThumb->resize(700,'resize');
                }												
                $imageThumb->save($temp[0].'_thumb','../upload/resized');
			}
		
			$ngaydang_ht=explode("-",$_POST['ngaydang']);
			$ngaydang_in=$ngaydang_ht[2].'-'.$ngaydang_ht[1].'-'.$ngaydang_ht[0];
			$giodang_in=$_POST['giodang'];
			//insert dữ liệu
			$chrole=$_POST['chrole'];
			$countcheckrole=count($chrole);
			$del_role='';
			for ($i=0; $i < $countcheckrole; $i++) 
			{ 
				$del_role=$del_role.','.$chrole[$i];	
			}
			$query_in="INSERT INTO khachsan(title,danhmuc,giagoc,giakhuyenmai,slphong,songuoi,status,noidung,anh,anh_thumb,ngaydang,giodang,tomtat,tiennghi,diachi,thanhpho,thue)
			VALUES('$khachsan','$parent_id','$giagoc','$giakm','$slphong','$songuoi','$status','$noidung','$link_img','$thumb','$ngaydang_in','$giodang_in','$tomtat','$del_role','$diachi','$thanhpho','$thue')";
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
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    	<form name="frmadd_ks" method="POST" action="#" enctype="multipart/form-data">
			<?php if(isset($message)){echo $message;}?>
			<h3>Thêm khách sạn</h3>
			<div class="form-group">
				<label style="display:block;">Danh mục</label>
				<?php selectCtrl('parent','forFormdim'); ?>
			</div>
			<div class="form-group">
				<label>Khách sạn</label>
				<input type="text" name="khachsan" value="<?php if(isset($_POST['khachsan'])){ echo $_POST['khachsan'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập khách sạn!" placeholder="Tên khách sạn">				
			</div>	
			<div class="form-group">
				<label>Giá gốc</label>
				<input type="text" name="giagoc" value="<?php if(isset($_POST['giagoc'])){ echo $_POST['giagoc'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập giá gốc!" placeholder="Giá gốc">	
			</div>	
			<div class="form-group">
				<label>Giá khuyến mãi</label>
				<input type="text" name="giakm" value="<?php if(isset($_POST['giact'])){ echo $_POST['giact'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập giá khuyến mãi!" placeholder="Giá khuyến mãi">
				<?php if(isset($mess)){echo $mess;} ?>
			</div>
			<div class="form-group">
				<label>Số lượng phòng</label>
				<input type="text" name="slphong" value="<?php if(isset($_POST['slphong'])){ echo $_POST['slphong'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập số lượng phòng!" placeholder="Số lượng phòng">
			</div>	
			<div class="form-group">
				<label>Số người/Phòng</label>
				<input type="text" name="songuoi" value="<?php if(isset($_POST['songuoi'])){ echo $_POST['songuoi'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập số người!" placeholder="Số người">
			</div>
			<div class="form-group">
				<label>Thuế(%)</label>
				<input type="text" name="thue" value="<?php if(isset($_POST['thue'])){ echo $_POST['thue'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập thuế khách sạn!" placeholder="Thuế">
			</div>
			<div class="form-group">
				<label>Tóm tắt</label>
				<textarea name="tomtat" style="Width:100%;height:100px;" class="form-control" value=""><?php if(isset($_POST['tomtat'])){ echo $_POST['tomtat'];} ?></textarea>
			</div>
			<div class="form-group">
				<label>Nội dung</label>
				<textarea id="noidung" name="noidung" style="Width:100%;height:100px;" value=""><?php if(isset($_POST['noidung'])){ echo $_POST['noidung'];} ?></textarea>
			</div>
			<div class="form-group">
				<label>Địa chỉ(Xã, Phường, Thị trấn, Quận, Huyện)</label>
				<input name="diachi" class="form-control" value="<?php if(isset($_POST['diachi'])){ echo $_POST['diachi'];} ?>" placeholder="Địa chỉ">
			</div>
			<div class="form-group">
				<label>Thành phố(Tỉnh)</label>
				<input name="thanhpho" class="form-control" value="<?php if(isset($_POST['thanhpho'])){ echo $_POST['thanhpho'];} ?>"required requiredmsg="Vui lòng nhập thành phố!" placeholder="Thành phố">
			</div>
			<div class="form-group">
				<label>Ảnh đại diện</label>
				<input type="file" name="img" value="">
			</div>
			<div class="form-group">
				<label>Chọn tiện nghi</label>
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<input type="checkbox" name="chkfull" onclick="checkall('chrole', this)">
						<label>Full tiện nghi</label>
					</div>
				</div>
				<div class="row">
					<?php 
						foreach ($mang as $mang_add) 
						{
						?>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							<div class="role_item">
								<input type="checkbox" name="chrole[]" class="chrole" value="<?php echo $mang_add['title'].'/'.$mang_add['icon']; ?>">
								<label><?php echo $mang_add['title']; ?></label>
							</div>
						</div>
						<?php
						}
					?>
				</div>
			</div>
            <div class="form-group">
				<label>Ngày đăng</label>
				<div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy"> 
					<input class="form-control" readonly="true" type="text" name="ngaydang"> 
					<span class="input-group-addon">
						<i class="fa fa-calendar-alt"></i>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label>Giờ đăng</label>
				<?php 
					date_default_timezone_set('Asia/Ho_Chi_Minh');
					$today=date('g:i A');
				?>
				<input type="text" name="giodang" value="<?php echo $today; ?>" class="form-control">
			</div>
			<div class="form-group">
				<label style="display:block;">Trạng thái</label>
				<label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Hiển thị</label>
				<label class="radio-inline"><input type="radio" name="status" value="0">Không hiển thị</label>
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value="Thêm mới">
		</form>
	</div>
</div>
<?php include('includes/footer.php'); ?> 