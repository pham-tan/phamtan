<?php ob_start(); ?>
<?php include('includes/header.php'); ?>
<?php include('includes/slider.php'); ?>
<?php 
	if(isset($_GET['dm']) && filter_var($_GET['dm'],FILTER_VALIDATE_INT,array('min_range'=>1)))
	{
        $dm=$_GET['dm'];
        $sql="SELECT id,danhmuc FROM danhmuc WHERE id={$dm}";
        $query_a=mysqli_query($conn,$sql);
        $dm_info2=mysqli_fetch_assoc($query_a);
        ?>
        <div class="bootstrap-iso">
            <div class="container-fluid" style="margin-top:20px;">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="left">
                        <?php include('includes/box_left.php'); ?>
                    </div>	
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                        <div class="box_center">
                            <div class="box_center_top">
                                <div class="box_center_top_l"><a href="datphong.php?dm=<?php echo $dm_info2['id']; ?>" title="<?php echo $dm_info2['danhmuc']; ?>"><?php echo $dm_info2['danhmuc']; ?></a></div>
                                <div class="box_center_top_r"></div>
                                <div class="clr"></div>
                            </div>
                        </div>
                    <?php
                        //đặt số bản ghi cần hiện thị
                        $limit=5;
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
                        $query="SELECT * FROM khachsan ORDER BY id DESC LIMIT {$start},{$limit}";
                        $results=mysqli_query($conn,$query);
                        while($kss=mysqli_fetch_array($results,MYSQLI_ASSOC))
                        {					
                    ?>
                        <div class="" id="dp_center">
                            <div class="col-md-4"id="col1">
                                <a href="baivietks.php?id=<?php echo $kss['id']; ?>">
                                    <img class="img-responsive" src="<?php echo $kss['anh']; ?>" width="100%" alt="">
                                </a>
                            </div>
                            <div class="col-md-5" id="col2">
                                <h3><?php echo $kss['title'] ?></h3>
                                <h5><i class="fa fa-map-marker-alt"></i><i>&nbsp;<?php echo $kss['diachi']; ?>,&nbsp;<?php echo $kss['thanhpho']; ?></i></h5>
                                <p><?php echo $kss['tomtat'] ?></p>
                                <a class="btn btn-primary" href="baivietks.php?id=<?php echo $kss['id']; ?>">Xem chi tiết</span></a>
                            </div>
                            <div class="col-md-3" id="col3">
                                <h3><small>Giá từ:</small><?php echo number_format($kss['giagoc'],0,'.','.'); ?> <br/> VNĐ/Đêm</h3>
                                <a class="btn btn-primary btn1" href="#">Đặt ngay</span></a>
                            </div>
                        </div>
                        <?php } ?>
                        <?php 
                            echo "<ul class='pagination'>";
                            if($per_page > 1)
                            {
                                $current_page=($start/$limit) + 1;
                                //Nếu không phải là trang đầu thì hiện thị trang trước
                                if($current_page !=1)
                                {
                                    echo "<li><a href='datphong.php?s=".($start - $limit)."&p={$per_page}.&dm={$dm}'>Back</a></li>";
                                }
                                //hiện thị những phần còn lại của trang
                                for ($i=1; $i <= $per_page ; $i++) 
                                { 
                                    if($i != $current_page)
                                    {
                                        echo "<li><a href='datphong.php?s=".($limit *($i - 1))."&p={$per_page}.&dm={$dm}'>{$i}</a></li>";
                                    }
                                    else
                                    {
                                        echo "<li class='active'><a>{$i}</a></li>";
                                    }
                                }
                                //Nếu không phải trang cuối thì hiện thị nút next
                                if($current_page != $per_page)
                                {
                                    echo "<li><a href='datphong.php?s=".($start + $limit)."&p={$per_page}.&dm={$dm}'>Next</a></li>";	
                                }
                            }
                            echo "</ul>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
<?php	
}
else
{
	header('Location:ĐPKS.php');
	exit();
}
?>
<?php ob_flush(); ?>