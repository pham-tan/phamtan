<?php ob_start(); ?>
<?php include('includes/header.php'); ?>
<?php include('../connection.php'); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
            $id=$_GET['id'];
            $query2="SELECT title FROM khachsan WHERE id='$id'";
            $results2=mysqli_query($conn,$query2);
			list($title1)=mysqli_fetch_array($results2,MYSQLI_NUM); }
			else{
				header('location:index.php'); }?>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <h3>Danh sách loại phòng&nbsp;<?php echo $title1; ?></h3>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="themmoi"><a href="add_loaiphong.php?id=<?php echo $id; ?>"><i class="fa fa-plus-circle"></i>&nbsp;Thêm mới</a></div>
        </div>
		<table class="table table-hover">
			<thead>	
				<tr>
					<th>ID</th>
					<th>Loại phòng</th>
					<th>Hình ảnh</th>
					<th>Giá gốc</th>
					<th>Giá khuyến mãi</th>
                    <th>Diện tích(m2)</th>
					<th>Số người/Phòng</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Giờ tạo</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
            </thead>
            <?php if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
                $idks=$_GET['id']; ?>
            <tbody>
				<?php	
					//đặt số bản ghi cần hiện thị
					$limit=10;
					//Xác định vị trí bắt đầu
					if(isset($_GET['s']) && filter_var($_GET['s'],FILTER_VALIDATE_INT,array('min_range'=>1)))
					{
						$start=$_GET['s'];
					} 	
					else
					{
						$start=0;
					}	
					if(isset($_GET['p']) && filter_var($_GET['p'],FILTER_VALIDATE_INT,array('min_range'=>1)))
					{
						$per_page=$_GET['p'];
					} 
					else
					{
						//Nếu p không có, thì sẽ truy vấn CSDL để tìm xem có bao nhiêu page
						$query_pg="SELECT COUNT(id) FROM loaiphong WHERE idks='$idks'";
						$results_pg=mysqli_query($conn,$query_pg);
						list($record)=mysqli_fetch_array($results_pg,MYSQLI_NUM);					
						//Tìm số trang bằng cách chia số dữ liệu cho số limit	
						if($record > $limit)
						{
							$per_page=ceil($record/$limit);
						}
						else
						{
							$per_page=1;
						}
					}				
					$query1="SELECT id,title,anh,giagoc,giakm,dientich,songuoi,status,ngaydang,giodang
						FROM loaiphong WHERE idks='$idks' ORDER BY id DESC LIMIT {$start},{$limit}";
					$results1=mysqli_query($conn,$query1);
					while($lp=mysqli_fetch_array($results1,MYSQLI_ASSOC))
					{
					?>
					<tr>
						<td><?php echo $lp['id']; ?></td>
						<td><?php echo $lp['title']; ?></td>
						<td><img width="70" src="../<?php echo $lp['anh']; ?>"/></td>
						<td><?php echo number_format($lp['giagoc'],0,'.','.').'&nbsp;'.'đ'; ?></td>
						<td><?php echo number_format($lp['giakm'],0,'.','.').'&nbsp;'.'đ'; ?></td>
                        <td><?php echo $lp['dientich']; ?></td>
                        <td><?php echo $lp['songuoi']; ?></td>
						<td>
							<?php 
							if($lp['status']==1)
							{
								echo 'Hiển thị';
							}	
							else
							{
								echo 'Không hiển thị';
							}						
							?>
						</td>
                        <td>
                            <?php
                            $ngaydang_v=explode('-',$lp['ngaydang']);
							echo $ngaydang_v[2].'-'.$ngaydang_v[1].'-'.$ngaydang_v[0]; 
                            ?>
                        </td>
                        <td><?php echo $lp['giodang']; ?></td>
						<td align="center"><a href="edit_loaiphong.php?id=<?php echo $lp['id']; ?>&idks=<?php echo $idks; ?>"><img width="16" src="../image/icon_edit.png"></a></td>						
						<td align="center"><a href="delete_loaiphong.php?id=<?php echo $lp['id'];?>&idks=<?php echo $idks; ?>" onclick="return confirm('Bạn có thực sự muốn xóa không');"><img width="16" src="../image/icon_delete.png"></a></td>
					</tr>
					<?php		
					}
				?>
            </tbody>
        </table>
		<?php 
			echo "<ul class='pagination'>";
			if($per_page > 1)
			{
				$current_page=($start/$limit) + 1;
				//Nếu không phải là trang đầu thì hiện thị trang trước
				if($current_page !=1)
				{
					echo "<li><a href='list_loaiphong.php?s=".($start - $limit)."&p={$per_page}&id={$idks}'>Back</a></li>";
				}
				//hiện thị những phần còn lại của trang
				for ($i=1; $i <= $per_page ; $i++) 
				{ 
					if($i != $current_page)
					{
						echo "<li><a href='list_loaiphongphp?s=".($limit *($i - 1))."&p={$per_page}&id={$idks}'>{$i}</a></li>";
					}
					else
					{
						echo "<li class='active'><a>{$i}</a></li>";
					}
				}
				//Nếu không phải trang cuối thì hiện thị nút next
				if($current_page != $per_page)
				{
					echo "<li><a href='list_loaiphong.php?s=".($start + $limit)."&p={$per_page}&id={$idks}'>Next</a></li>";	
				}
			}
			echo "</ul>";
        }?>		
    </div>
</div>
<?php include('includes/footer.php'); ?>
<?php ob_flush(); ?>