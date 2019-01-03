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
				header('Location: list_dm.php');
				exit();
			}
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
                $query_in="UPDATE danhmuc SET danhmuc='$danhmuc',parent_id='$parent_id',chucnang='$chucnang',ordernum='$ordernum',status='$status' WHERE id='$id'";
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
            $query_id="SELECT danhmuc,chucnang,ordernum,status,parent_id FROM danhmuc WHERE id='$id'";
            $results_id=mysqli_query($conn,$query_id);
            //Kiểm tra xem ID có tồn tại không
            if(mysqli_num_rows($results_id)==1)
            {
                list($danhmuc,$chucnang,$ordernum,$status,$parent_id)=mysqli_fetch_array($results_id,MYSQLI_NUM);				
            }
            else
            {
                header('Location:list_dm.php');
                exit();
            }
		?>
		<form name="frmadd_dm" method="POST">
			<?php 
				if(isset($message))
				{
					echo $message;
				}
			?>
			<h3>Sửa danh mục</h3>
			<div class="form-group">
				<label>Danh mục</label>
				<input type="text" name="danhmuc" value="<?php if(isset($danhmuc)){ echo $danhmuc;} ?>" class="form-control" required requiredmsg="Vui lòng nhập danh mục!" placeholder="Danh mục">
			</div>
			<div class="form-group">
				<label style="display:block;">Danh mục cha</label>
				<?php selectCtrl_e($parent_id,'parent','forFormdim');?>
			</div>
			<div class="form-group">
                <label style="display:block;">Chức năng</label>
                <?php if($chucnang=="Bài viết"){ ?>
                    <label class="radio-inline"><input checked="checked" type="radio" name="chucnang" value="Bài viết">Bài viết</label>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Liên hệ">Liên hệ</label>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Trang chủ">Trang chủ</label>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Khách sạn">Khách sạn</label>
                <?php }
                else if($chucnang=="Liên hệ"){ ?>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Bài viết">Bài viết</label>
                    <label class="radio-inline"><input checked="checked" type="radio" name="chucnang" value="Liên hệ">Liên hệ</label>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Trang chủ">Trang chủ</label>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Khách sạn">Khách sạn</label>
                <?php }
                else if($chucnang=="Khách sạn"){ ?>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Bài viết">Bài viết</label>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Liên hệ">Liên hệ</label>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Trang chủ">Trang chủ</label>
                    <label class="radio-inline"><input checked="checked" type="radio" name="chucnang" value="Khách sạn">Khách sạn</label>
                <?php }
                else { ?>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Bài viết">Bài viết</label>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Liên hệ">Liên hệ</label>
                    <label class="radio-inline"><input checked="checked" type="radio" name="chucnang" value="Trang chủ">Trang chủ</label>
                    <label class="radio-inline"><input type="radio" name="chucnang" value="Khách sạn">Khách sạn</label>
                <?php } ?>
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