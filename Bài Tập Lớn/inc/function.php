<?php
define('BASE_URL','http://localhost:81/Bài%20Tập%20Lớn/ĐPKS.php');
function show_categories($parent_id="0",$insert_text="--")
{	global $conn;
	$query_dq="SELECT * FROM danhmuc WHERE parent_id=".$parent_id." ORDER BY parent_id DESC";
	$categories=mysqli_query($conn,$query_dq);
	while($category=mysqli_fetch_array($categories,MYSQLI_ASSOC))
	{
		echo("<option value='".$category["id"]."'>".$insert_text.$category['danhmuc']."</option>");
		show_categories($category["id"],$insert_text."--");
	}
	return true;
}
function show()
{	global $conn;
	$query_dq2="SELECT DISTINCT(thanhpho) FROM khachsan ORDER BY id DESC";
	$categories2=mysqli_query($conn,$query_dq2);
	while($category2=mysqli_fetch_array($categories2,MYSQLI_ASSOC))
	{
			echo("<option value='".$category2["thanhpho"]."'>".$category2['thanhpho']."</option>");
	}
	return true;
}
function select1($name,$class)
{
	global $conn;
	echo "<select name='".$name."' class='".$class."'>";
	echo "<option value='0'>--Top Điểm Đến--</option>";
	show();
	echo "</select>";
}
function show2($diachi)
{	global $conn;
	$query_dq3="SELECT DISTINCT(thanhpho) FROM khachsan ORDER BY id DESC";
	$categories3=mysqli_query($conn,$query_dq3);
	while($category3=mysqli_fetch_array($categories3,MYSQLI_ASSOC))
	{
		if($diachi==$category3["thanhpho"])
		{			
			echo("<option selected='selected' value='".$category3["thanhpho"]."'>".$category3['thanhpho']."</option>");
		}else
		{
			echo("<option value='".$category3["thanhpho"]."'>".$category3['thanhpho']."</option>");
		}
	}
	return true;
}
function select2($name,$class,$diachi)
{
	global $conn;
	echo "<select name='".$name."' class='".$class."'>";
	echo "<option value='0'>--Top Điểm Đến--</option>";
	show2($diachi);
	echo "</select>";
}
function selectCtrl($name,$class)
{
	global $conn;
	echo "<select name='".$name."' class='".$class."'>";
	echo "<option value='0'>Danh mục cha</option>";
	show_categories();
	echo "</select>";
}
function show_categories_e($uid,$parent_id1="0",$insert_text1="--")
{
	global $conn;
	$query_dq1="SELECT DISTINCT * FROM danhmuc where parent_id=".$parent_id1."";	
	$categories1=mysqli_query($conn,$query_dq1);
	while($category1=mysqli_fetch_array($categories1,MYSQLI_ASSOC))
	{				
		if($uid==$category1["id"])
		{			
			echo("<option selected='selected' value='".$category1["id"]."'>".$insert_text1.$category1['danhmuc']."</option>");
		}
		else
		{
			echo("<option value='".$category1["id"]."'>".$insert_text1.$category1['danhmuc']."</option>");
		}
		show_categories_e($uid,$category1["id"],$insert_text1."--");
	}
	return true;
}
function selectCtrl_e($uid,$name1,$class1)
{
	global $conn;
	echo "<select name='".$name1."' class='".$class1."'>";
	echo "<option value='0'>Danh mục cha</option>";
	show_categories_e($uid);
	echo "</select>";
}
function selectCtrl_e1($uid,$name1,$class1)
{
	global $conn;
	echo "<select disabled='true' name='".$name1."' class='".$class1."'>";
	echo "<option value='0'>Danh mục cha</option>";
	show_categories_e($uid);
	echo "</select>";
}
function smtpmailer($to, $from, $from_name, $subject, $body)
 {
    $mail = new PHPMailer();                  // tạo một đối tượng mới từ class PHPMailer
    $mail->IsSMTP();                         // bật chức năng SMTP
    $mail->SMTPDebug = 0;                      // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
    $mail->SMTPAuth = true;                  // bật chức năng đăng nhập vào SMTP này
    $mail->SMTPSecure = 'ssl';                 // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
    $mail->Host = 'smtp.gmail.com';         // smtp của gmail
    $mail->Port = 465;                         // port của smpt gmail
    $mail->Username = GUSER;  
    $mail->Password = GPWD;    
    $mail->CharSet = "UTF-8";        
    $mail->SetFrom($from, $from_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    if(!$mail->Send())
    {
        $message = 'Gởi mail bị lỗi: '.$mail->ErrorInfo; 
        return false;
    } 
    else 
    {
        $message = 'Thư của bạn đã được gởi đi ';
        return true;
    }
 }
?>