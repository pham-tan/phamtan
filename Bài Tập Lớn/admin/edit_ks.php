<?php ob_start(); ?>
<?php include('includes/header.php'); ?>
<?php include('../connection.php');?>
<?php include('../inc/function.php');?>
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
    if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
    {
        $id=$_GET['id'];
    }
    else
    {
        header('Location:list_ks.php');
        exit();
    }
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
        if ($_FILES['img']['size']=='') 
            {
                $link_img=$_POST['anh_hi'];
                $thumb=$_POST['anhthumb_hi'];
            }
        else
            {
            //upload hình ảnh
            if(($_FILES['img']['type']!="image/gif")
                &&($_FILES['img']['type']!="image/png")
                &&($_FILES['img']['type']!="image/jpeg")
                &&($_FILES['img']['type']!="image/jpg"))
            {
                $message="File không đúng định dạng";	
            }
            elseif ($_FILES['img']['size']>1000000) 
            {
                $message="Kích thước phải nhỏ hơn 1MB";						
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
            //xoa anh trong thu muc 
            $sql="SELECT anh,anh_thumb FROM khachsan WHERE id={$id}";
            $query_a=mysqli_query($conn,$sql);
            $anhInfo=mysqli_fetch_assoc($query_a);
            unlink('../'.$anhInfo['anh']);
            unlink('../'.$anhInfo['anh_thumb']);
            }
			$ngaydang_ht=explode("-",$_POST['ngaydang']);
			$ngaydang_in=$ngaydang_ht[2].'-'.$ngaydang_ht[1].'-'.$ngaydang_ht[0];
			$giodang_in=$_POST['giodang'];
			//Update dữ liệu
			$chrole=$_POST['chrole'];
			$countcheckrole=count($chrole);
			$del_role='';
			for ($i=0; $i < $countcheckrole; $i++) 
			{ 
				$del_role=$del_role.','.$chrole[$i];	
			}
			$query_in="UPDATE khachsan SET danhmuc=$parent_id,tiennghi='$del_role',title='$khachsan',tomtat='$tomtat',giagoc='$giagoc',giakhuyenmai='$giakm',slphong='$slphong',songuoi='$songuoi',status='$status',noidung='$noidung',anh='$link_img',anh_thumb='$thumb',ngaydang='$ngaydang_in',giodang='$giodang_in',diachi='$diachi',thanhpho='$thanhpho',thue='$thue' where id='$id'";
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
        $query_id="SELECT title,danhmuc,tiennghi,giagoc,giakhuyenmai,anh,anh_thumb,ngaydang,giodang,slphong,songuoi,tomtat,noidung,status,diachi,thanhpho,thue FROM khachsan WHERE id={$id}";
        $result_id=mysqli_query($conn,$query_id);
        //Kiểm tra xem ID có tồn tại không
        if(mysqli_num_rows($result_id)==1)
        {
            list($title,$danhmuc,$tiennghi,$giagoc,$giakhuyenmai,$anh,$anh_thumb,$ngaydang,$giodang,$slphong,$songuoi,$tomtat,$noidung,$status,$diachi,$thanhpho,$thue)=mysqli_fetch_array($result_id,MYSQLI_NUM);
        }
        else
        {
            header('Location:list_ks.php');
            exit();
        }
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    	<form name="frmedit_ks" method="POST" action="#" enctype="multipart/form-data">
			<?php if(isset($message)){echo $message;}?>
			<h3>Sửa khách sạn</h3>
			<div class="form-group">
				<label style="display:block;">Danh mục</label>
				<?php selectCtrl_e($danhmuc,'parent','forFormdim'); ?>
			</div>
			<div class="form-group">
				<label>Khách sạn</label>
				<input type="text" name="khachsan" value="<?php if(isset($title)){ echo $title;} ?>" class="form-control" required requiredmsg="Vui lòng nhập khách sạn!" placeholder="Tên khách sạn">				
			</div>	
			<div class="form-group">
				<label>Giá gốc</label>
				<input type="text" name="giagoc" value="<?php if(isset($giagoc)){ echo $giagoc;} ?>" class="form-control" required requiredmsg="Vui lòng nhập giá gốc!" placeholder="Giá gốc">	
			</div>	
			<div class="form-group">
				<label>Giá khuyến mãi</label>
				<input type="text" name="giakm" value="<?php if(isset($giakhuyenmai)){ echo $giakhuyenmai;} ?>" class="form-control" required requiredmsg="Vui lòng nhập giá khuyến mãi!" placeholder="Giá khuyến mãi">
				<?php if(isset($mess)){echo $mess;} ?>
			</div>
			<div class="form-group">
				<label>Số lượng phòng</label>
				<input type="text" name="slphong" value="<?php if(isset($slphong)){ echo $slphong;} ?>" class="form-control" required requiredmsg="Vui lòng nhập số lượng phòng!" placeholder="Số lượng phòng">
			</div>	
			<div class="form-group">
				<label>Số người/Phòng</label>
				<input type="text" name="songuoi" value="<?php if(isset($songuoi)){ echo $songuoi;} ?>" class="form-control" required requiredmsg="Vui lòng nhập số người!" placeholder="Số người">
			</div>
			<div class="form-group">
				<label>Thuế(%)</label>
				<input type="text" name="thue" value="<?php if(isset($thue)){ echo $thue;} ?>" class="form-control" required requiredmsg="Vui lòng nhập thuế!" placeholder="Thuế">
			</div>
			<div class="form-group">
				<label>Tóm tắt</label>
				<textarea name="tomtat" style="Width:100%;height:100px;" class="form-control" value=""><?php if(isset($tomtat)){ echo $tomtat;} ?></textarea>
			</div>
			<div class="form-group">
				<label>Nội dung</label>
				<textarea id="noidung" name="noidung" style="Width:100%;height:100px;" value=""><?php if(isset($noidung)){ echo $noidung;} ?></textarea>
			</div>
			<div class="form-group">
				<label>Địa chỉ(Xã, Phường, Thị trấn, Quận, Huyện)</label>
				<input name="diachi" class="form-control" value="<?php if(isset($diachi)){ echo $diachi;} ?>" placeholder="Địa chỉ">
			</div>
			<div class="form-group">
				<label>Thành phố(Tỉnh)</label>
				<input name="thanhpho" class="form-control" value="<?php if(isset($thanhpho)){ echo $thanhpho;} ?>"required requiredmsg="Vui lòng nhập thành phố!" placeholder="Thành phố">
			</div>
			<div class="form-group">
				<label>Ảnh đại diện</label>
				<input type="file" name="img" value="">
                <p><img width="100" src="../<?php echo $anh; ?>"></p>
				<input type="hidden" name="anh_hi" value="<?php echo $anh; ?>">
				<input type="hidden" name="anhthumb_hi" value="<?php echo $anh_thumb; ?>">	
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
							$edit_role=explode(',',$tiennghi);
							$ok=0;
							foreach ($edit_role as $itemrole) 
							{
								$edit_ht=$mang_add['title'].'/'.$mang_add['icon'];
								if($edit_ht == $itemrole)
								{
									$ok=1;
									break;
								}
							}
						?>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							<div class="role_item">
								<input type="checkbox" name="chrole[]" <?php if($ok==1){ ?>checked="checked"<?php } ?> class="chrole" value="<?php echo $mang_add['title'].'/'.$mang_add['icon']; ?>">
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
                <?php 
					if(isset($ngaydang))
					{
						$ngaydang_cu=explode('-',$ngaydang);
						$ngaydang_cu_m=$ngaydang_cu[2].'-'.$ngaydang_cu[1].'-'.$ngaydang_cu[0];
					}
				?>
					<input class="form-control" type="text" value="<?php echo $ngaydang_cu_m; ?>" id="ngaydang_edit" name="ngaydang"> 
			</div>
			<div class="form-group">
				<label>Giờ đăng</label>
				<?php 
					date_default_timezone_set('Asia/Ho_Chi_Minh');
					$today=date('g:i A');
				?>
				<input type="text" name="giodang" value="<?php if(isset($giodang)){ echo $giodang;} ?>" class="form-control">
			</div>
			<div class="form-group">
				<label style="display:block;">Trạng thái</label>
				<?php 
					if(isset($status)==1)
					{
					?>
					<label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Hiển thị</label>
					<label class="radio-inline"><input type="radio" name="status" value="0">Không hiển thị</label>
					<?php 
					}
					else
					{
					?>
					<label class="radio-inline">
						<input type="radio" name="status" value="1">Hiển thị
					</label>
					<label class="radio-inline">
						<input checked="checked" type="radio" name="status" value="0">Không hiển thị
					</label>
					<?php		
					}
				?>
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value="Sửa">
		</form>
	</div>
</div>
<?php include('includes/footer.php'); ?> 
<?php ob_flush(); ?>