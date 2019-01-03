

        <?php include('includes/header.php'); ?>
        <?php include('includes/slider.php'); ?>
        <div class="clr"></div>
        <div id="content_top">
            <div class="top_text">TOP ĐIỂM ĐẾN</div>
            <div class="top_color"></div>
            <div class="to">
                <?php
                    $query="SELECT id,diachi,anh,ordernum,status
                    FROM topdiemden ORDER BY ordernum DESC LIMIT 8";
                    $results=mysqli_query($conn,$query);
                    $dem=1;
                    while($top=mysqli_fetch_array($results,MYSQLI_ASSOC))
                {?>
                <div class="diemden<?php echo $dem; ?>">
                    <a href="topdiadiem.php?id=<?php echo $top['id']; ?>"><img src="<?php echo $top['anh'] ?>" alt="anh" class="diemden_image">
                    <div class="diemden_text"><a href="topdiadiem.php?id=<?php echo $top['id']; ?>"><?php echo $top['diachi']; ?></a></div>
                </div>
                <?php $dem++; } ?>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>