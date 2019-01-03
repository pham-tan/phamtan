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
			if(isset($_POST['submit']))
			{
                $noidung=$_POST['noidung'];
                $ordernum=$_POST['ordernum'];
                $status=$_POST['status'];
                $parent_id=$_POST['parent'];
                if ($_FILES['img']['size']=='') {
                    $messag="<p class='required'>Bạn chưa nhập file ảnh<p>";
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
                    }
                    $query="INSERT INTO topdiemden(diachi,anh,noidung,ordernum,status) 
                    VALUES('$parent_id','$link_img','$noidung','$ordernum','$status')";
                    $results=mysqli_query($conn,$query); 
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
		<form name="frmadd_tp" method="POST" enctype="multipart/form-data">
			<?php 
				if(isset($message))
				{
					echo $message;
                }
                if(isset($messag))
				{
					echo $messag;
				}
			?>
			<h3>Thêm mới top điểm đến</h3>
			<div class="form-group">
				<label style="display:block;">Top điểm đến</label>
				<div class="col-lg-4 col-md-4 col-xs-4 col-sm-4"><?php select1('parent','form-control');?></div>
                <div class="" style="clear:both"></div>
			</div>
			<div class="form-group">
				<label>Ảnh đại diện</label>
				<input type="file" name="img" value="">
			</div>
			<div class="form-group">
				<label>Nội dung</label>
				<textarea id="noidung" name="noidung" required requiredmsg="Vui lòng nhập nội dung!" style="Width:100%;height:100px;" value=""><?php if(isset($_POST['noidung'])){ echo $_POST['noidung'];} ?></textarea>
			</div>
            <div class="form-group">
				<label>Thứ tự</label>
				<input type="text" value="<?php if(isset($_POST['ordernum'])){ echo $_POST['ordernum'];} ?>" name="ordernum" class="form-control" placeholder="Thứ tự">
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
<?php include('includes/footer.php') ?>