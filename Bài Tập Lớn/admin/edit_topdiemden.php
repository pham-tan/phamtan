<?php ob_start(); ?>
<?php include('includes/header.php') ?>
<?php include('../connection.php') ?>
<?php include('../inc/function.php'); ?>
<script src="../js/formlogin.js"></script>
<style>
.required{color:red;}
</style>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <?php 
            if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
			{
				$id=$_GET['id'];
			}
			else
			{
				header('Location: list_topdiemden.php');
				exit();
			}
			if(isset($_POST['submit']))
			{
                $noidung=$_POST['noidung'];
                $ordernum=$_POST['ordernum'];
                $status=$_POST['status'];
                $parent_id=$_POST['parent'];
                if ($_FILES['img']['size']=='') {
                    $link_img=$_POST['anh_hi'];
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
                    elseif ($_FILES['img']['size']>4000000) 
                    {
                        $message="<p class='required'>Kích thước phải nhỏ hơn 4MB</p>";						
                    }
                    else
                    {
                        $img=$_FILES['img']['name'];
                        $link_img='upload/'.$img;
                        move_uploaded_file($_FILES['img']['tmp_name'],"../upload/".$img);
                        $sql="SELECT anh FROM topdiemden WHERE id={$id}";
                        $query_a=mysqli_query($conn,$sql);
                        $anhInfo=mysqli_fetch_assoc($query_a);
                        unlink('../'.$anhInfo['anh']);
                    }
                }
                $query_in="UPDATE topdiemden SET diachi='$parent_id',anh='$link_img',ordernum='$ordernum',status='$status',noidung='$noidung' WHERE id='$id'";
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
            $query_id="SELECT diachi,anh,ordernum,status,noidung FROM topdiemden WHERE id='$id'";
            $results_id=mysqli_query($conn,$query_id);
            //Kiểm tra xem ID có tồn tại không
            if(mysqli_num_rows($results_id)==1)
            {
                list($diachi,$anh,$ordernum,$status,$noidung)=mysqli_fetch_array($results_id,MYSQLI_NUM);				
            }
            else
            {
                header('Location:list_topdiemden.php');
                exit();
            }
		?>
		<form name="frmadd_dm" method="POST" enctype="multipart/form-data">
			<?php 
				if(isset($message))
				{
					echo $message;
				}
			?>
			<h3>Sửa top điểm đến</h3>
			<div class="form-group">
				<label style="display:block;">Top điểm đến</label>
                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4"><?php select2('parent','form-control',$diachi);?></div>
                <div class="" style="clear:both"></div>
            </div>
            <div class="form-group">
				<label>Ảnh đại diện</label>
				<input type="file" name="img" value="">
                <p><img width="100" src="../<?php echo $anh; ?>"></p>
				<input type="hidden" name="anh_hi" value="<?php echo $anh; ?>">	
            </div>
            <div class="form-group">
				<label>Nội dung</label>
				<textarea id="noidung" name="noidung" required requiredmsg="Vui lòng nhập nội dung!" style="Width:100%;height:100px;" value=""><?php if(isset($noidung)){ echo $noidung;} ?></textarea>
			</div>
			<div class="form-group">
				<label>Thứ tự</label>
				<input type="text" value="<?php if(isset($ordernum)){ echo $ordernum;} ?>" name="ordernum" class="form-control" placeholder="Thứ tự">
			</div>
			<div class="form-group">
				<label style="display:block;">Trạng thái</label>
                <?php if($status==1){ ?>
				<label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Hiển thị</label>
				<label class="radio-inline"><input type="radio" name="status" value="0">Không hiển thị</label>
                <?php }
                else{ ?>
                    <label class="radio-inline"><input type="radio" name="status" value="1">Hiển thị</label>
				    <label class="radio-inline"><input checked="checked" type="radio" name="status" value="0">Không hiển thị</label>
                <?php } ?>
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value="Sửa">
		</form>
	</div>
</div>
<?php include('includes/footer.php') ?>
<?php ob_flush(); ?>