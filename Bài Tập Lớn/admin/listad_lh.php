<?php include('includes/header.php'); ?>
<?php include('../connection.php'); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Danh sách góp ý</h3>
		<table class="table table-hover">
			<thead>	
				<tr>
					<th>ID</th>
					<th>Tài khoản</th>
					<th>Họ tên</th>
					<th>Điện thoại</th>
					<th>Email</th>
					<th>Địa chỉ</th>
					<th>Nội dung</th>
                    <th>Ngày đăng</th>
                    <th>Trạng thái</th>
					<th>Phản hồi</th>
					<th>Delete</th>
				</tr>
            </thead>
            <tbody>
                <?php
					//đặt số bản ghi cần hiện thị
					$limit=12;
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
						$query_pg="SELECT COUNT(id) FROM lienhe";
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
					$query="SELECT id,hoten,dienthoai,email,diachi,noidung,ngaydang,status,nameu
						FROM lienhe ORDER BY status DESC LIMIT {$start},{$limit}";
					$results=mysqli_query($conn,$query);
					while($lh=mysqli_fetch_array($results,MYSQLI_ASSOC))
					{
					?>
					<tr>
						<td><?php echo $lh['id']; ?></td>
						<td><?php echo $lh['nameu']; ?></td>
						<td><?php echo $lh['hoten']; ?></td>
						<td><?php echo $lh['dienthoai']; ?></td>
						<td><?php echo $lh['email']; ?></td>
						<td><?php echo $lh['diachi']; ?></td>
                        <td><?php echo $lh['noidung']; ?></td>
                        <td>
                            <?php
                            $ngaydang_v=explode('-',$lh['ngaydang']);
							echo $ngaydang_v[2].'-'.$ngaydang_v[1].'-'.$ngaydang_v[0]; 
                            ?>
                        </td>
						<td>
							<?php 
							if($lh['status']==1)
							{
								echo 'Đã phản hồi';
							}	
							else
							{
								echo 'Chưa phản hồi';
							}						
							?>
						</td>					
						<td align="center"><a href="phanhoi_lh.php?id=<?php echo $lh['id']; ?>"><img width="16" src="../image/icon_edit.png"></a></td>						
						<td align="center"><a href="delete_lh.php?id=<?php echo $lh['id'];?>" onclick="return confirm('Bạn có thực sự muốn xóa không');"><img width="16" src="../image/icon_delete.png"></a></td>
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
					echo "<li><a href='listad_lh.php?s=".($start - $limit)."&p={$per_page}'>Back</a></li>";
				}
				//hiện thị những phần còn lại của trang
				for ($i=1; $i <= $per_page ; $i++) 
				{ 
					if($i != $current_page)
					{
						echo "<li><a href='listad_lh.php?s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
					}
					else
					{
						echo "<li class='active'><a>{$i}</a></li>";
					}
				}
				//Nếu không phải trang cuối thì hiện thị nút next
				if($current_page != $per_page)
				{
					echo "<li><a href='listad_lh.php?s=".($start + $limit)."&p={$per_page}'>Next</a></li>";	
				}
			}
			echo "</ul>";
		?>		
    </div>
</div>
<?php include('includes/footer.php'); ?>