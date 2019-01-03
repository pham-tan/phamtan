<?php include('includes/header.php'); ?>
<?php include('../connection.php'); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Danh sách khách sạn</h3>
		<table class="table table-hover">
			<thead>	
				<tr>
					<th>ID</th>
					<th>Khách Sạn</th>
					<th>Hình ảnh</th>
					<th>Giá gốc</th>
					<th>Giá khuyến mãi</th>
					<th>Số lượng phòng</th>
					<th>Số người/Phòng</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Giờ tạo</th>
					<th>Loại phòng</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
            </thead>
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
						$query_pg="SELECT COUNT(id) FROM khachsan";
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
					$query="SELECT id,title,giagoc,giakhuyenmai,slphong,songuoi,status,noidung,anh,ngaydang,giodang
						FROM khachsan ORDER BY id DESC LIMIT {$start},{$limit}";
					$results=mysqli_query($conn,$query);
					while($phongks=mysqli_fetch_array($results,MYSQLI_ASSOC))
					{
					?>
					<tr>
						<td><?php echo $phongks['id']; ?></td>
						<td><?php echo $phongks['title']; ?></td>
						<td><img width="70" src="../<?php echo $phongks['anh']; ?>"/></td>
						<td><?php echo number_format($phongks['giagoc'],0,'.','.').'&nbsp;'.'đ'; ?></td>
						<td><?php echo number_format($phongks['giakhuyenmai'],0,'.','.').'&nbsp;'.'đ'; ?></td>
						<td><?php echo $phongks['slphong']; ?></td>
                        <td><?php echo $phongks['songuoi']; ?></td>
                        
						<td>
							<?php 
							if($phongks['status']==1)
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
                            $ngaydang_v=explode('-',$phongks['ngaydang']);
							echo $ngaydang_v[2].'-'.$ngaydang_v[1].'-'.$ngaydang_v[0]; 
                            ?>
                        </td>
                        <td><?php echo $phongks['giodang']; ?></td>
						<td><a href="list_loaiphong.php?id=<?php echo $phongks['id']; ?>"><i class="fa fa-eye"></i></a></td>
						<td align="center"><a href="edit_ks.php?id=<?php echo $phongks['id']; ?>"><img width="16" src="../image/icon_edit.png"></a></td>						
						<td align="center"><a href="delete_ks.php?id=<?php echo $phongks['id'];?>" onclick="return confirm('Bạn có thực sự muốn xóa không');"><img width="16" src="../image/icon_delete.png"></a></td>
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
					echo "<li><a href='list_ks.php?s=".($start - $limit)."&p={$per_page}'>Back</a></li>";
				}
				//hiện thị những phần còn lại của trang
				for ($i=1; $i <= $per_page ; $i++) 
				{ 
					if($i != $current_page)
					{
						echo "<li><a href='list_ks.php?s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
					}
					else
					{
						echo "<li class='active'><a>{$i}</a></li>";
					}
				}
				//Nếu không phải trang cuối thì hiện thị nút next
				if($current_page != $per_page)
				{
					echo "<li><a href='list_ks.php?s=".($start + $limit)."&p={$per_page}'>Next</a></li>";	
				}
			}
			echo "</ul>";
		?>		
    </div>
</div>
<?php include('includes/footer.php'); ?>