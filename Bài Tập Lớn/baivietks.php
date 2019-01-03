<?php include('includes/header.php'); ?>
<?php include('includes/slider.php'); ?>
<?php 
	if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
	{
        $id=$_GET['id'];
        $sql="SELECT * FROM khachsan WHERE id={$id}";
        $query_a=mysqli_query($conn,$sql);
        $dm_info=mysqli_fetch_assoc($query_a);
        $sql2="SELECT * FROM danhmuc WHERE id={$dm_info['danhmuc']}";
        $query_a2=mysqli_query($conn,$sql2);
        $dm_info2=mysqli_fetch_assoc($query_a2);
        $view_add=$dm_info['view'] + 1;
        $query="UPDATE khachsan SET view={$view_add} WHERE id={$id}";
        $results=mysqli_query($conn,$query);
        $sql3="SELECT * FROM khachsan WHERE id={$id}";
        $query_a3=mysqli_query($conn,$sql3);
        $dm_info3=mysqli_fetch_assoc($query_a3);
        $sql4="SELECT * FROM loaiphong WHERE idks={$dm_info['id']}";
        $query_a4=mysqli_query($conn,$sql4);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today=date('d-m-Y');
        $today1=date('d-m-Y',strtotime("+1 day"));
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
                        <ul class="breadcrumb">
                            <li><a href="<?php echo BASE_URL; ?>" title="Trang chủ"><i class="fa fa-home"></i></a></li>
                            <li><a style="text-decoration:none" href="datphong.php?dm=<?php echo $dm_info2['id']; ?>" title="<?php echo $dm_info2['danhmuc']; ?>"><?php echo $dm_info2['danhmuc']; ?></a></li>
                            <li class="active"><?php echo $dm_info['title']; ?></li>
                        </ul>
                        <div class="baiviet_ct">
                            <h1><?php echo $dm_info['title']; ?></h1>
                            <div id="time" style="border-bottom:1px solid;margin-bottom:5px;padding-bottom:3px">
                                <?php 
                                    $ng_dang=explode('-',$dm_info['ngaydang']);
                                    $ngaydang_ct=$ng_dang[2].'-'.$ng_dang[1].'-'.$ng_dang[0];
                                ?>
                                Ngày đăng:&nbsp;<?php echo $ngaydang_ct; ?> | <?php echo $dm_info['giodang']; ?> | <?php echo $dm_info3['view']; ?> lượt xem
                            </div>
                            <div class="">
                                <img src="<?php echo $dm_info['anh']; ?>" width="80%" alt="anh" srcset="">
                            </div>
                            <div class="p"style="margin-top:30px">
                            <?php echo $dm_info['noidung']; ?>
                            </div>
                        </div>
                        <div class="box2" style="border: 1px solid #cbd3db;border-radius:5px;margin-top:20px;">
                            <div class="box-header">
                                <h3 class="box-title" style="margin-top: 0;margin-bottom: 0;padding:10px">Tiện nghi&nbsp;<?php echo $dm_info['title']; ?></h3>
                            </div>
                            <div class="box-body">
                                <div class="container-fluid" style="margin-bottom:10px">
                                    <?php 
                                        foreach ($mang as $mang_add) 
                                        {
                                            $edit_role=explode(',',$dm_info3['tiennghi']);
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
                                        if($ok==1){ ?>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding:5px"><i class="fa  fa-<?php echo $mang_add['icon']; ?>"></i>&nbsp;&nbsp;<?php echo $mang_add['title']; ?></div>
                                        <?php }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="box2" style="border: 1px solid #cbd3db;border-radius:5px;margin-top:30px;">
                            <div class="box-header">
                                <h3 class="box-title" style="margin-top: 0;margin-bottom: 0;padding:10px">Chọn phòng&nbsp;<?php echo $dm_info['title']; ?></h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">Loại phòng</i></th>
                                            <th style="text-align:center">Tối đa</th>
                                            <th style="text-align:center">Tùy chọn</th>
                                            <th style="text-align:center">Giá 1 đêm<br/><h6><i>Chưa bao gồm thuế phí</i></h6></th>
                                            <th style="text-align:center">Số lượng</th>
                                            <th style="text-align:center">Đặt phòng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($dm_info4=mysqli_fetch_array($query_a4,MYSQLI_ASSOC)){ ?>
                                        <tr>
                                            <td colspan="6">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><h4><b><?php echo $dm_info4['title']; ?></b></h4></div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="input-group date text2" data-date-format="dd-mm-yyyy"> 
                                                        <input class="form-control ngaynhan<?php echo $dm_info4['id']; ?>" type="text" value="<?php if(isset($_SESSION['ngaynhantim'])){ echo $_SESSION['ngaynhantim']; }else{ echo $today;} ?>" name="ngaydang"> 
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="input-group date text3" name="" data-date-format="dd-mm-yyyy"> 
                                                        <input class="form-control ngaytra<?php echo $dm_info4['id']; ?>" type="text" value="<?php if(isset($_SESSION['ngaytratim'])){ echo $_SESSION['ngaytratim']; }else{ echo $today1;} ?>" name="ngaydang"> 
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p><img width="200" src="<?php echo $dm_info4['anh']; ?>"/></p>
                                                <p title='Diện tích phòng'>
                                                    <span class="fa fa-expand"></span>&nbsp;<?php echo $dm_info4['dientich']; ?>&nbsp;m<sup>2</sup>
                                                </p>
                                                <p title='Hướng phòng'>
                                                    <span class="fa fa-eye"></span>&nbsp;<?php echo $dm_info4['viewphong']; ?>
                                                </p>
                                                <?php if($dm_info4['giuongdon']!=0){ ?>
                                                <p>
                                                    <span class="fa fa-bed"></span>&nbsp;<?php echo $dm_info4['giuongdon']; ?>&nbsp;Giường đơn
                                                </p>
                                                <?php }
                                                if($dm_info4['giuongdoi']!=0){ ?>
                                                <p>
                                                    <span class="fa fa-bed"></span>&nbsp;<?php echo $dm_info4['giuongdoi']; ?>&nbsp;Giường đôi
                                                </p>
                                                <?php } ?>
                                            </td>
                                            <td style="text-align:center;vertical-align: inherit;"><p class="fa fa-user">&nbsp;x&nbsp;<?php echo $dm_info4['songuoi']; ?>&nbsp;người</p></td>
                                            <td>
                                                <?php 
                                                    foreach ($mang1 as $mang_add1) 
                                                    {
                                                        $edit_role1=explode(',',$dm_info4['tuychon']);
                                                        $ok1=0;
                                                        foreach ($edit_role1 as $itemrole1) 
                                                        {
                                                            $edit_ht1=$mang_add1['title'].'-'.$mang_add1['icon'];
                                                            if($edit_ht1 == $itemrole1)
                                                            {
                                                                $ok1=1;
                                                                break;
                                                            }
                                                        }
                                                    if($ok1==1){ ?>
                                                        <div style="margin-bottom:10px;"><i class="fa fa-<?php echo $mang_add1['icon']; ?>">&nbsp;</i><?php echo $mang_add1['title']; ?></div>
                                                    <?php }
                                                    }
                                                ?>
                                            </td>
                                            <td style="text-align:center"><p style="text-decoration: line-through;"><?php echo number_format($dm_info4['giagoc'],0,'.','.'); ?>&nbsp;đ</p>
                                                <p><strong><h4 style="color:green;"><?php echo number_format($dm_info4['giakm'],0,'.','.'); ?>&nbsp;đ</h4></strong></p>
                                            </td>
                                            <?php
                                                if(isset($_SESSION['songuoi1'])){
                                                $so=ceil($_SESSION['songuoi1']/$dm_info4['songuoi']);
                                                }
                                            ?>
                                            <input type="hidden" class="idloai<?php echo $dm_info4['id'] ?>" id="<?php echo $dm_info4['id'] ?>" value="<?php echo $dm_info4['id'] ?>">
                                            <td align="center" style="vertical-align: inherit;"><input class="form-control soluong1<?php echo $dm_info4['id']; ?>" type="number" min="1" style="width:150px;" max="5" placeholder="Số lượng phòng" value="<?php if(isset($so)){ echo $so;} ?>"> </td>
                                            <td style="text-align:center;vertical-align: inherit;">
                                            <?php if(isset($_SESSION['id'])){ ?>
                                                <input style="background-color:green;" type="submit" id="datphong<?php echo $dm_info4['id']; ?>" name="submit" class="btn btn-primary" value="Đặt ngay">
                                                </td> 
                                            <?php }
                                            else{ ?>
                                                <small><a href="dangnhap.php?xem=datphong&id=<?php echo $id; ?>" class="dangnhanp">Đăng nhập<br>để đặt phòng</a></small>
                                            <?php } ?>
                                              
                                        </tr>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $("#datphong<?php echo $dm_info4['id']; ?>").click(function(){
                                                    var id=$(".idloai<?php echo $dm_info4['id']; ?>").attr('id');
                                                    var ngaynhan=$(".ngaynhan<?php echo $dm_info4['id']; ?>").val();
                                                    var ngaytra=$(".ngaytra<?php echo $dm_info4['id']; ?>").val();
                                                    var soluong=$(".soluong1<?php echo $dm_info4['id']; ?>").val();
                                                    if(ngaynhan=='')
                                                    {
                                                        alert("Bạn chưa điền ngày nhận");
                                                        $(".ngaynhan<?php echo $dm_info4['id']; ?>").focus();
                                                        return false;
                                                    }
                                                    else if(ngaytra==''){
                                                        alert("Bạn chưa điền ngày trả");
                                                        $(".ngaytra<?php echo $dm_info4['id']; ?>").focus();
                                                        return false;
                                                    }
                                                    else if(soluong==''){
                                                        alert("Bạn chưa điền số lượng");
                                                        $(".soluong1<?php echo $dm_info4['id']; ?>").focus();
                                                        return false;
                                                    }
                                                    else{
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "addthongtin.php",
                                                            data: {ngaynhan : ngaynhan,ngaytra : ngaytra,id : id,soluong : soluong},
                                                            cache:false,
                                                            success:function(){
                                                                window.location="datloaiphong.php";
                                                            }
                                                        });
                                                    }
                                                    return false;
                                                });
                                            });
						                </script>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tin_row">
							<p>Khách sạn khác ở&nbsp;<?php echo $dm_info['thanhpho']; ?></p>
							<ul>
								<?php 
									$query_lq="SELECT * FROM khachsan WHERE id!={$dm_info['id']} and thanhpho='{$dm_info['thanhpho']}' ORDER BY rand() LIMIT 0,4";
									$result_lq=mysqli_query($conn,$query_lq);
									while($kslq=mysqli_fetch_array($result_lq,MYSQLI_ASSOC))
									{
									?>
									<li><a href="baivietks.php?id=<?php echo $kslq['id']; ?>" title="<?php echo $kslq['title']; ?>"><?php echo $kslq['title']; ?></a></li>
									<?php		
									}
								?>								
							</ul>
                        </div>
                        <div class="tin_row">
							<p>Khách sạn xem nhiều ở&nbsp;<?php echo $dm_info['thanhpho']; ?></p>
							<ul>
								<?php 
									$query_xn="SELECT * FROM khachsan WHERE id!={$dm_info['id']} and thanhpho='{$dm_info['thanhpho']}' ORDER BY view LIMIT 0,4";
									$result_xn=mysqli_query($conn,$query_xn);
									while($ksxn=mysqli_fetch_array($result_xn,MYSQLI_ASSOC))
									{
									?>
									<li><a href="baivietks.php?id=<?php echo $kslq['id']; ?>" title="<?php echo $ksxn['title']; ?>"><?php echo $ksxn['title']; ?></a></li>
									<?php		
									}
								?>								
							</ul>
						</div>
                    </div>
                </div>
            </div>
        </div>
<?php			
    }
    else
    {
        header('Location:ĐPKS.php');
        exit();
    }
?>
<?php include('includes/footer.php'); ?>				