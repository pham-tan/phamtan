<div class="clr"></div>
        <div id="menu">
            <div id="menu_tab">
                <ul>
                    <?php
                        $query11="SELECT * FROM danhmuc ORDER BY ordernum DESC";
                        $result11=mysqli_query($conn,$query11);
                        while($dm12=mysqli_fetch_array($result11)){ ?>
                            <a href="chuyentrang.php?dm=<?php echo $dm12['id']; ?>" title="<?php echo $dm12['danhmuc']; ?>"><li><?php echo $dm12['danhmuc']; ?></li></a>
                    <?php 
                        }?>
                </ul>
            </div>
            <div class="clr"></div>
            <div id="menu_content">
                <div class="menu_text1">CHÀO MỪNG BẠN ĐẾN VỚI ROYAL HOTEL</div>
                <div class="menu_text2">Chúc quý khách có khoảng thời gian vui vẻ và hạnh phúc</div>
                <form action="searchphong.php" method="post">
                    <div class="menu_text">
                    <?php
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $today=date('d-m-Y');
                        $today1=date('d-m-Y',strtotime("+1 day"));
                    ?>
                        <input type="text" name="diachi" placeholder="Bạn muốn đến đâu?" class="text1">
                        <input type="text" name="ngaynhan11" placeholder="Ngày nhận"  id="text2" class="text2" value="<?php if(isset($_SESSION['ngaynhantim'])){ echo $_SESSION['ngaynhantim']; }else{ echo $today;} ?>" data-date-format="dd-mm-yyyy">
                        <input type="text" name="ngaytra11" placeholder="Ngày trả" id="text3" class="text3" value="<?php if(isset($_SESSION['ngaytratim'])){ echo $_SESSION['ngaytratim']; }else{ echo $today1;} ?>" data-date-format="dd-mm-yyyy">
                        <input type="number" name="nguoilon" placeholder="Người lớn" class="text4" min="1">
                        <input type="number" name="treem" placeholder="Trẻ em" class="text5" min="1">
                    </div>
                    <div class="clr"></div>
                    <div class="menu_btn">
                        <input type="submit" name="submit" value="Tìm kiếm" class="btn">
                    </div>
                </form>
            </div>
        </div>
        <div class="clr"></div>