<?php include('./connection.php'); ?>
<?php
    if(isset($_GET['dm']) && filter_var($_GET['dm'],FILTER_VALIDATE_INT,array('min_range'=>1)))
	{
        $dm=$_GET['dm'];
        $query1="SELECT * FROM danhmuc where id='$dm'  ORDER BY ordernum DESC";
        $result1=mysqli_query($conn,$query1);
        $dm1=mysqli_fetch_array($result1);
        if($dm1['chucnang']=='Khách sạn'){
            header('Location:datphong.php?dm='.$dm);
            exit();
        }
        else if($dm1['chucnang']=='Trang chủ'){
            header('Location:ĐPKS.php');
            exit();
        }
        else if($dm1['chucnang']=='Liên hệ'){
            header('Location:lienhe.php');
            exit();
        }
    }
    else
    {
        header('Location:ĐPKS.php');
        exit();
    }
?>