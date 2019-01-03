<?php include('includes/header.php'); ?>
<?php 
    if(isset($_SESSION['ngaynhandat']) && isset($_SESSION['ngaytradat']) &&isset($_SESSION['soluongdat'])&&isset($_SESSION['iddatphong'])){
        $ngaynhan=$_SESSION['ngaynhandat'];
        $ngaytra=$_SESSION['ngaytradat'];
        $iddat=$_SESSION['iddatphong'];
        $soluong=$_SESSION['soluongdat'];
    }
    else{
        header('location:ĐPKS.php');
    }
    $ngaynhan_ht=explode("-",$ngaynhan);
    $ngaynhan_in=$ngaynhan_ht[2].'-'.$ngaynhan_ht[1].'-'.$ngaynhan_ht[0];
    $ngaytra_ht=explode("-",$ngaytra);
    $ngaytra_in=$ngaytra_ht[2].'-'.$ngaytra_ht[1].'-'.$ngaytra_ht[0];
    $first_date = strtotime($ngaytra_in);
    $second_date = strtotime($ngaynhan_in);
    $datediff = abs($first_date - $second_date);
    $sodem=floor($datediff / (60*60*24));
    $sql5="SELECT * FROM loaiphong WHERE id={$iddat}";
    $query_a5=mysqli_query($conn,$sql5);
    $dm_info5=mysqli_fetch_assoc($query_a5);
    $sql6="SELECT * FROM khachsan WHERE id={$dm_info5['idks']}";
    $query_a6=mysqli_query($conn,$sql6);
    $dm_info6=mysqli_fetch_assoc($query_a6);
    $sotien=$dm_info5['giakm']*$sodem;
    $sotienthue=round($soluong*(($dm_info5['giakm']*$sodem)*($dm_info6['thue']/100)));
    $tong=$sotien+$sotienthue;
    if(isset($_SESSION['id'])){
        $sql7="SELECT * FROM user WHERE id={$_SESSION['id']}";
        $query_a7=mysqli_query($conn,$sql7);
        $dm_info7=mysqli_fetch_assoc($query_a7);
    }
?>
<div class="bootstrap-iso">
    <div class="container-fluid" style="margin-top:20px;">
        <div class="container">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                <div class="box1 box-blue">
                    <div class="box_padding">
                        <div class=row>
                            <div class="box_main1">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h3 class="main2"><?php echo $dm_info6['title']; ?></h3>
                                    <p><i class="fa fa-map-marker-alt"></i>
                                        <span><?php echo $dm_info6['diachi'];?>,&nbsp;<?php echo $dm_info6['thanhpho']; ?></span>
                                    </p>
                                    <div class="pha">
                                        <dt>
                                            Nhận phòng:
                                        </dt>
                                        <dd>
                                            14:00, <?php echo $ngaynhan; ?>
                                        </dd>
                                    </div>
                                    <div class="pha">
                                        <dt>
                                            Trả phòng:
                                        </dt>
                                        <dd>
                                            12:00, <?php echo $ngaytra; ?>
                                        </dd>
                                    </div>
                                    <div class="pha">
                                        <dt>
                                            Số đêm:
                                        </dt>
                                        <dd>
                                            <?php echo $sodem; ?> đêm
                                        </dd>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info alert-none-radius text-center mg-bt-10" style="margin-bottom:10px;margin-top:5px;padding:10px;">Giá tốt hất dành cho bạn</div>
                        <div class="alert alert-warning alert-none-radius text-center mg-bt-10" style="margin-bottom:10px;padding:10px;">Giữ phòng cho kì nghỉ sắp tới</div>
                        <div class=row style="margin-top:10px;">
                            <div class="box_main1">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h3 class="main2">Thông tin liên hệ <small><a href="suatt.php" class="dangnhanp"> Sửa thông tin</a></small></h3>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label style="margin-bottom:0;">Email</label>
                                                <div style="margin-bottom:5px;"><i class="fa fa-info-circle"></i>
                                                    <small>Xác nhận đơn phòng sẽ được gửi qua email này</small>
                                                </div>
                                                <input type="text" name="songuoi" disabled="true" value="<?php if(isset($dm_info7['email'])){ echo $dm_info7['email']; } ?>" class="form-control suattemail" placeholder="Số người">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label style="margin-bottom:0;">Số điện thoại</label>
                                                <div style="margin-bottom:5px;"><i class="fa fa-info-circle"></i>
                                                    <small>Xác nhận đơn phòng sẽ được gửi qua SMS</small>
                                                </div>
                                                <input type="text" name="songuoi" disabled="true" value="<?php if(isset($dm_info7['sdt'])){ echo $dm_info7['sdt']; } ?>" class="form-control suattsdt" placeholder="Số người">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label style="margin-bottom:0;">Họ và tên</label>
                                                <div style="margin-bottom:5px;">
                                                </div>
                                                <input type="text" name="songuoi" disabled="true" value="<?php if(isset($dm_info7['hoten'])){ echo $dm_info7['hoten']; } ?>" class="form-control suatthoten" placeholder="Số người">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                                <label style="margin-bottom:0;">Địa chỉ</label>
                                                <div style="margin-bottom:5px;">
                                                </div>
                                                <input type="text" name="songuoi" disabled="true" value="<?php if(isset($dm_info7['diachi'])){ echo $dm_info7['diachi']; } ?>" class="form-control suattdiachi" placeholder="Số người">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="box_main1">
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                        </div>
                                        <?php
                                            $sql8="SELECT * FROM datphong where id={$_SESSION['iddp']}";
                                            $query_a8=mysqli_query($conn,$sql8);
                                            $dm_info8=mysqli_fetch_assoc($query_a8);
                                        ?>
                                        <form action="https://www.nganluong.vn/advance_payment.php" method="post">
                                            <input type="hidden" name="receiver" value="phamtan365@gmail.com">
                                            <input type="hidden" name="product" value="<?php echo $dm_info8['madat']; ?>">
                                            <input type="hidden" name="price" value="<?php echo $dm_info8['tongtien']; ?>">
                                            <input type="hidden" name="return_ulr" value="datphong.php">
                                            <input type="hidden" name="comments" value="Bạn hãy thanh toán để đặt phòng!">
                                            <input type="submit" name="submit" style="background-color:green;margin-top:20px;" class="btn btn-primary btnthanhtoan" value="Thanh Toán">
                                        </form>
                                        <script>
                                            $(document).ready(function(){
                                                $(".btnthanhtoan").click(function(){
                                                    var email=$(".suattemail").val();
                                                    var dienthoai=$(".suattsdt").val();
                                                    var hoten=$(".suatthoten").val();
                                                    var diachi=$(".suattdiachi").val();
                                                    if(email=='')
                                                    {
                                                        alert("Bạn chưa nhập họ tên");
                                                        $("#hoten").focus();
                                                        return false;
                                                    }
                                                    else if(dienthoai=='')
                                                    {
                                                        alert("Bạn chưa nhập điện thoại");
                                                        $("#dienthoai").focus();
                                                        return false;	
                                                    }
                                                    else if(hoten=='')
                                                    {
                                                        alert("Bạn chưa nhập địa chỉ");
                                                        $("#diachi").focus();
                                                        return false;
                                                    }
                                                    else if(diachi=='')
                                                    {
                                                        alert("Bạn chưa nhập email");
                                                        $("#email").focus();
                                                        return false;	
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                <div class="box2" style="border: 1px solid #cbd3db;border-radius:5px;margin-top:15px">
                    <div class="box-header">
                        <h3 class="box-title" style="margin-top: 0;margin-bottom: 0;padding:10px">Thông Tin Thanh Toán</h3>
                    </div>
                    <div class="container-fluid" style="margin-top: 15px;" >
                        <strong><?php echo $dm_info5['title']; ?></strong> <br>
                        <p style="margin-bottom:5px;margin-top:5px;"><?php echo $soluong; ?>&nbsp;phòng</p>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <ul>
                            <?php 
                                foreach ($mang1 as $mang_add1) 
                                {
                                    $edit_role1=explode(',',$dm_info5['tuychon']);
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
                                    <li><?php echo $mang_add1['title']; ?></li>
                                <?php }
                                }
                            ?>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <b style="margin:0;padding:0;color:green"><?php echo number_format($sotien,0,'.','.'); ?></b> <br><small style="margin-left:20px;">đ/<?php echo $sodem; ?> đêm</small>
                        </div>
                    </div>
                    <div class="container-fluid" style="margin-top: 15px;padding-left:0;" >
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">   
                            <p><?php echo $dm_info6['thue'] ?>% thuế & phí dịch vụ&nbsp;<i class="fa fa-info-circle"></i></p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <i style="color:green"><?php echo number_format($sotienthue,0,'.','.'); ?></i>&nbsp;<small>đ</small>
                        </div>
                    </div>
                    <div class="container-fluid" style="margin-top: 15px;padding-left:0;line-height: 40px;background-color:#E7F6FC;border-top:1px solid #cbd3db">
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">   
                            <b>Tổng tiền</b>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <b style="color:green"><?php echo number_format($tong,0,'.','.'); ?></b>&nbsp;<small>đ</small>
                        </div>
                    </div>
                    <div class="container-fluid" style="padding-left:0;background-color:#E7F6FC;border-top:1px solid #cbd3db">
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">   
                            <b>THANH TOÁN</b><br>
                            <small>(<?php echo $sodem; ?> đêm)<br>
                            Gồm <?php echo $dm_info6['thue'] ?>% thuế & phí dịch vụ
                            </small>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"style="line-height:60px;">
                            <b style="color:green"><?php echo number_format($tong,0,'.','.'); ?></b>&nbsp;<small>đ</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>