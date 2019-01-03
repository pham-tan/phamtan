<?php include('includes/header.php'); ?>
<?php include('../connection.php'); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Danh sách khách sạn</h3>
		<table class="table table-hover">
			<thead>	
				<tr class="datp">
					<th>ID</th>
					<th>Mã đơn</th>
					<th>Họ tên</th>
					<th>Điện thoại</th>
					<th>Email</th>
					<th>Đã thanh toán</th>
					<th>Ngày nhận và trả</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
					<th>Xem</th>
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
						$query_pg="SELECT COUNT(id) FROM datphong";
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
					$query="SELECT id,madat,hoten,dienthoai,email,thanhtoan,status,ngaynhan,ngaytra,ngaydat,giodat
						FROM datphong ORDER BY id DESC LIMIT {$start},{$limit}";
					$results=mysqli_query($conn,$query);
					while($phongks=mysqli_fetch_array($results,MYSQLI_ASSOC))
					{
					?>
					<tr>
						<td><?php echo $phongks['id']; ?></td>
						<td><?php echo $phongks['madat']; ?></td>
						<td><?php echo $phongks['hoten']; ?></td>
						<td><?php echo $phongks['dienthoai']; ?></td>
						<td><?php echo $phongks['email']; ?></td>
						<td><?php echo number_format($phongks['thanhtoan'],0,'.','.').'&nbsp;'.'đ'; ?></td>
                        <td>
                        <?php
                            $ngaynhan1=explode('-',$phongks['ngaynhan']);
                            $ngaytra1=explode('-',$phongks['ngaytra']);
							echo $ngaynhan1[2].'/'.$ngaynhan1[1].'/'.$ngaynhan1[0].'-'.$ngaytra1[2].'/'.$ngaytra1[1].'/'.$ngaytra1[0]; 
                        ?>
                        </td>
						<td>
							<?php 
							if($phongks['status']==1)
							{
								echo '<small>Xác nhận đặt phòng</small>';
							}	
							else
							{
								echo '<small>Đang kiểm tra</small>';
							}						
							?>
						</td>
                        <td>
                            <?php
                            $ngaydat1=explode('-',$phongks['ngaydat']);
							echo $ngaydat1[2].'-'.$ngaydat1[1].'-'.$ngaydat1[0]; ?><br><?php echo $phongks['giodat']; ?>
                        </td>
						<td><a href="xem_datphong.php?id=<?php echo $phongks['id']; ?>"><i style="color:black" class="fa fa-eye"></i></a></td>						
						<td align="center"><a href="delete_datphong.php?id=<?php echo $phongks['id'];?>" onclick="return confirm('Bạn có thực sự muốn xóa không');"><img width="16" src="../image/icon_delete.png"></a></td>
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
					echo "<li><a href='list_datphong.php?s=".($start - $limit)."&p={$per_page}'>Back</a></li>";
				}
				//hiện thị những phần còn lại của trang
				for ($i=1; $i <= $per_page ; $i++) 
				{ 
					if($i != $current_page)
					{
						echo "<li><a href='list_datphong.php?s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
					}
					else
					{
						echo "<li class='active'><a>{$i}</a></li>";
					}
				}
				//Nếu không phải trang cuối thì hiện thị nút next
				if($current_page != $per_page)
				{
					echo "<li><a href='list_datphong.php?s=".($start + $limit)."&p={$per_page}'>Next</a></li>";	
				}
			}
			echo "</ul>";
		?>		
    </div>
</div>
<?php include('includes/footer.php'); ?>