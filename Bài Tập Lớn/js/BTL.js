$(document).ready(function(){
    var today = new Date();
    $('.text2').datepicker({
        dateFormat: 'dd-mm-yyy',
        autoclose: true,
        todayBtn: true,
        startDate : today
    }).on('changeDate', function(ev){
        $('.text3').datepicker('setStartDate', ev.date);
    });

    $('.text3').datepicker({
        dateFormat: 'dd-mm-yyy',
        autoclose: true,
        todayBtn: true,
        startDate : today
    }).on('changeDate', function(ev){
        $('.text2').datepicker('setEndDate', ev.date);
    });
});
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