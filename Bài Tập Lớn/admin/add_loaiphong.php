<?php ob_start(); ?>
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
    if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
        $idks1=$_GET['id']; }
	else{
		header('location:index.php');
		exit();
	}
    include('../inc/images_helper.php');
    if(isset($_POST['submit'])){
        $loaiphong=$_POST['loaiphong'];
        $giagoc=$_POST['giagoc'];
        $giakm=$_POST['giakm'];
        $songuoi=$_POST['songuoi'];
        $dientich=$_POST['dientich'];
		$status=$_POST['status'];
		$viewphong=$_POST['viewphong'];
		$giuongdon=$_POST['giuongdon'];
		$giuongdoi=$_POST['giuongdoi'];
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
            elseif ($_FILES['img']['size']>3000000) 
            {
                $message="<p class='required'>Kích thước phải nhỏ hơn 3MB</p>";						
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
                if($imageThumb->getWidth()>2000)
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
			$query_in="INSERT INTO loaiphong(title,giagoc,giakm,dientich,songuoi,status,anh,anh_thumb,ngaydang,giodang,viewphong,giuongdon,giuongdoi,tuychon,idks)
			VALUES('$loaiphong','$giagoc','$giakm','$dientich','$songuoi','$status','$link_img','$thumb','$ngaydang_in','$giodang_in','$viewphong','$giuongdon','$giuongdoi','$del_role','$idks1')";
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
			<h3>Thêm loại phòng</h3>
			<div class="form-group">
				<label>Tên loại phòng</label>
				<input type="text" name="loaiphong" value="<?php if(isset($_POST['loaiphong'])){ echo $_POST['loaiphong'];} ?>" class="form-control" required requiredmsg="Vui lòng tên loại phòng!" placeholder="Tên loại phòng">				
			</div>	
			<div class="form-group">
				<label>Giá gốc</label>
				<input type="text" name="giagoc" value="<?php if(isset($_POST['giagoc'])){ echo $_POST['giagoc'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập giá gốc!" placeholder="Giá gốc">	
			</div>	
			<div class="form-group">
				<label>Giá khuyến mãi</label>
				<input type="text" name="giakm" value="<?php if(isset($_POST['giakm'])){ echo $_POST['giakm'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập giá khuyến mãi!" placeholder="Giá khuyến mãi">
			</div>
			<div class="form-group">
				<label>Diện tích(m2)</label>
				<input type="text" name="dientich" value="<?php if(isset($_POST['dientich'])){ echo $_POST['dientich'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập diện tích!" placeholder="Diện tích">
			</div>	
			<div class="form-group">
				<label>Số người/Phòng</label>
				<input type="text" name="songuoi" value="<?php if(isset($_POST['songuoi'])){ echo $_POST['songuoi'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập số người!" placeholder="Số người">
			</div>
			<div class="form-group">
				<label>View phòng</label>
				<input type="text" name="viewphong" value="<?php if(isset($_POST['viewphong'])){ echo $_POST['viewphong'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập view phòng!" placeholder="View phòng">
            </div>
            <div class="form-group">
				<label>Số giường đôi</label>
				<input type="text" name="giuongdoi" value="<?php if(isset($_POST['giuongdoi'])){ echo $_POST['giuongdoi'];} ?>" class="form-control" placeholder="Số giường đôi">
            </div>
            <div class="form-group">
				<label>Số giường đơn</label>
				<input type="text" name="giuongdon" value="<?php if(isset($_POST['giuongdon'])){ echo $_POST['giuongdon'];} ?>" class="form-control" placeholder="Số giường đơn">
			</div>
			<div class="form-group">
				<label>Ảnh đại diện</label>
				<input type="file" name="img" value="">
			</div>
			<div class="form-group">
				<label>Chọn tùy chọn</label>
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<input type="checkbox" name="chkfull" onclick="checkall('chrole', this)">
						<label>Full tùy chọn</label>
					</div>
				</div>
				<div class="row">
					<?php 
						foreach ($mang1 as $mang_add) 
						{
						?>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							<div class="role_item">
								<input type="checkbox" name="chrole[]" class="chrole" value="<?php echo $mang_add['title'].'-'.$mang_add['icon']; ?>">
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
						<i class="glyphicon glyphicon-calendar"></i>
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
<?php ob_flush(); ?>