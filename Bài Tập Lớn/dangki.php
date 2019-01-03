<?php
session_start();
if(isset($_SESSION['username'])){header('location:ĐPKS.php');} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng kí</title>
    <link href="./font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="./css/btl.css">
    <link rel="stylesheet" href="./css/dangki.css">
    <script src="./js/jquery-3.3.1.min.js"></script>
    <script src="./js/formlogin.js"></script>
</head>
<body>
<a href="ĐPKS.php"><i class="fa fa-home tranghome"></i></a>
    <div id="dangnhap">
        <div class="dang">
            <div><b class="text_dangnhap">Đăng kí</b></div>
        <?php
            require_once("connection.php");
            if (isset($_POST["dangki"])) {
                if($_POST['captcha']==$_SESSION['cap_code'])
				{					
                    $mes='Ok';
				}
				else
				{
                    $mes='';
				}
                //lấy thông tin từ các form bằng phương thức POST
                $password_1 = $_POST["password_1"];
                $password_2 = $_POST["password_2"];
                $username = $_POST["username"];
                //Kiểm tra điều kiện bắt buộc đối với các field không được bỏ trống
                if($password_1!=$password_2){
                    $mess='<p class="span3">Nhập lại mật khẩu sai!</p>';
                }
                else{
                    // Kiểm tra tài khoản đã tồn tại chưa
                    $sql="select * from user where username='$username'";
                    $kt=mysqli_query($conn, $sql);
                    if(mysqli_num_rows($kt)  > 0){
                        $mess='<p class="span3">Tài khoản đã tồn tại!</p>';
                    }else{
                        if($mes=='Ok'){
                            $password_1=md5($password_1);
                            //thực hiện việc lưu trữ dữ liệu vào db
                            $sql="INSERT INTO user(username,password) VAlUES ('$username','$password_1')";
                            // thực thi câu $sql với biến conn lấy từ file connection.php
                            mysqli_query($conn,$sql);
                            $mess='<p style="color:green" class="span3">Đăng kí thành công!&nbsp;<a href="dangnhap.php" style="color:#0005ED;text-decoration:none;">Đăng nhập</a></p>';
                        }
                        else{$messs='<p class="span3">Mã xác nhận sai!</p>';}
                    }
                }
            }
        ?>
        </div>
        <form action="dangki.php" class="form1" method="Post">
            <div class="a1">
                <label class="label_user">Tài khoản</label>
                <div class="form_user">
                    <div class="img_user"></div>
                    <input type="text" class="input_user" name="username" required requiredmsg="Vui lòng nhập tài khoản!" placeholder="Nhập tài khoản">
                    <div class="clr"></div>
                </div>
            </div>
            <div class="a2">
                <label class="label_pass">Mật khẩu</label>
                <div class="form_pass">
                    <div class="img_pass"></div>
                    <input type="password" class="input_pass" name="password_1" required requiredmsg="Vui lòng nhập mật khẩu!" placeholder="Nhập mật khẩu">
                    <div class="clr"></div>
                </div>
            </div>
            <div class="a2">
                <label class="label_pass">Nhập lại mật khẩu</label>
                <div class="form_pass">
                    <div class="img_pass"></div>
                    <input type="password" class="input_pass" name="password_2" required requiredmsg="Vui lòng nhập lại mật khẩu!" placeholder="Nhập lại mật khẩu">
                    <div class="clr"></div>
                    <?php if(isset($mess)){echo $mess;} ?>
                    <div class="clr"></div>
                </div>
            </div>
            <div id="captcha1">
				<table border="0" >
					<tr>
						<td><input type="text" name="captcha" id="capcha"required requiredmsg="Vui lòng nhập mã xác nhận!"></td>
						<td><img src="captcha_code.php"></td>
					</tr>
                </table>
                <?php if(isset($messs)){echo $messs;} ?>
			</div>
            <button type="submit" class="btn_dangnhap" name="dangki">Đăng kí</button>
            <div class="div1">
                <p class="lay">Quên mật khẩu?</p>
                <a href="#" class="bb">Lấy lại mật khẩu</a>
            </div>
        </form>
    </div>
</body>
</html>