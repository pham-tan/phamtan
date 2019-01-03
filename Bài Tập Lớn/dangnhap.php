<?php 
    session_start();
    if(isset($_SESSION['username'])){ header('Location: ĐPKS.php');exit();}
    if(isset($_GET['xem']) && isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
        $_SESSION['xemdangphan']=$_GET['xem'];
        $_SESSION['iddangnhan']=$_GET['id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập</title>
    <link href="./font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="./css/btl.css">
    <link rel="stylesheet" href="./css/dangnhap.css">
    <script src="./js/jquery-3.3.1.min.js"></script>
    <script src="./js/formlogin.js"></script>
</head>
<body>
<a href="ĐPKS.php"><i class="fa fa-home tranghome"></i></a>
    <div id="dangnhap">
        <div class="dang">
            <div><b class="text_dangnhap">Đăng nhập</b></div>
        <?php
            //Gọi file connection.php 
            require_once("connection.php");
            $result='<script language="javascript">$(document).ready(function(){$(".span3").show();});</script>';
            $result_1='<script language="javascript">$(document).ready(function(){$(".span3").hide();});</script>';
            $result_2='Mật khẩu không đúng!';
            // Kiểm tra nếu người dùng đã ân nút đăng nhập thì mới xử lý
            if (isset($_POST["login"])) {
                // lấy thông tin người dùng
                $username = $_POST["username"];
                $password_1 = $_POST["password_1"];
                //làm sạch thông tin, xóa bỏ các tag html, ký tự đặc biệt 
                //mà người dùng cố tình thêm vào để tấn công theo phương thức sql injection
                $username = strip_tags($username);
                $username = addslashes($username);
                $password_1 = strip_tags($password_1);
                $password_1 = addslashes($password_1);
                $sql="select * from user where username='$username'";
                $kt=mysqli_query($conn, $sql);
                $num_row=mysqli_num_rows($kt);
                $password_1=md5($password_1);
                $sql = "select * from user where username = '$username' and password = '$password_1' ";
                $query = mysqli_query($conn,$sql);
                $num_rows = mysqli_num_rows($query);
                if ($num_row==0) {
                    echo $result;
                }
                elseif($num_rows==0){
                    echo '<script language="javascript">$(document).ready(function(){$(".span3").show().html("'.$result_2.'");});</script>';
                }
                else{
                    $row=mysqli_fetch_array($query);
                    //tiến hành lưu tên đăng nhập vào session để tiện xử lý sau này
                    $_SESSION['username'] = $username;
                    $_SESSION['quyen'] = $row[quyen];
                    $_SESSION['id'] = $row[id];
                    // Thực thi hành động sau khi lưu thông tin vào session
                    // ở đây mình tiến hành chuyển hướng trang web tới một trang gọi là index.php
                    if(isset($_SESSION['xemdangphan'])){
                        if($_SESSION['xemdangphan']=='datphong'){
                        header('Location: baivietks.php?id='.$_SESSION['iddangnhan']);
                        exit();
                        }else{
                            header('Location: ĐPKS.php');
                        }
                    }
                    else{
                        header('Location: ĐPKS.php');
                    }
                }
            }
	    ?>	
        </div>
        <form action="dangnhap.php" class="form1" method="Post">
            <div class="a1">
                <label class="label_user">Tài khoản</label>
                <div class="form_user">
                    <div class="img_user"></div>
                    <input type="text" class="input_user" name="username" required requiredmsg="Vui lòng nhập tài khoản!" placeholder="Nhập tài khoản">
                </div>
            </div>
            <div class="a2">
                <label class="label_pass">Mật khẩu</label>
                <div class="form_pass">
                    <div class="img_pass"></div>
                    <input type="password" class="input_pass" name="password_1" required requiredmsg="Vui Lòng nhập mật khẩu!" placeholder="Nhập mật khẩu">
                    <div class="clr"></div>
                    <div class="span3">Tài khoản chưa đăng ký!&nbsp;<a href="./dangki.php" style="color:#0005ED;">Click để đăng ký</a></div>
                </div>
            </div>
            <button type="submit" class="btn_dangnhap" name="login">Đăng nhập</button>
            <div>
                <p class="lay">Quên mật khẩu?</p>
                <a href="#" class="bb">Lấy lại mật khẩu</a>
            </div>
            <div class="clr"></div>
            <div class="div1">
                <p class="lay">Chưa có tài khoản?</p>
                <a href="dangki.php" class="bb">Tạo tài khoản</a>
            </div>
        </form>
    </div>
</body>
</html>