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
                $danhmuc=$_POST['danhmuc'];
                $chucnang=$_POST['chucnang'];
                $ordernum=$_POST['ordernum'];
                $status=$_POST['status'];
                if($_POST['parent']==0)
                {
                    $parent_id=0;
                }
                else
                {
                    $parent_id=$_POST['parent'];
                }
                $query="INSERT INTO danhmuc(danhmuc,parent_id,chucnang,ordernum,status) 
                    VALUES('$danhmuc','$parent_id','$chucnang','$ordernum','$status')";
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
		?>
		<form name="frmadd_dm" method="POST">
			<?php 
				if(isset($message))
				{
					echo $message;
				}
			?>
			<h3>Thêm mới danh mục</h3>
			<div class="form-group">
				<label>Danh mục</label>
				<input type="text" name="danhmuc" value="<?php if(isset($_POST['danhmuc'])){ echo $_POST['danhmuc'];} ?>" class="form-control" required requiredmsg="Vui lòng nhập danh mục!" placeholder="Danh mục">
			</div>
			<div class="form-group">
				<label style="display:block;">Danh mục cha</label>
				<?php selectCtrl('parent','forFormdim');?>
			</div>
			<div class="form-group">
				<label style="display:block;">Chức năng</label>
				<label class="radio-inline"><input checked="checked" type="radio" name="chucnang" value="Bài viết">Bài viết</label>
				<label class="radio-inline"><input type="radio" name="chucnang" value="Liên hệ">Liên hệ</label>
				<label class="radio-inline"><input type="radio" name="chucnang" value="Trang chủ">Trang chủ</label>
				<label class="radio-inline"><input type="radio" name="chucnang" value="Khách sạn">Khách sạn</label>
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