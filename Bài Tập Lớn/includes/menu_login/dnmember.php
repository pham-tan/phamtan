
<div class="bootstrap-iso">
    <div class="pull-right">
        <ul class="nav pull-right">
            <li class="dropdown"><a href="#" class="fa fa-user" data-toggle="dropdown">&nbsp;Welcome,&nbsp;<?php if(isset($_SESSION['username'])) {echo $_SESSION['username'];} ?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="suatt.php"><i class="fa fa-fw fa-user"></i> Sửa thông tin</a></li>
                    <li><a href="doipassm.php"><i class="fa fa-fw fa-cog"></i> Đổi mật khẩu</a></li>
                    <li class="divider"></li>
                    <li><a href="thoat.php"><i class="fa fa-fw fa-power-off"></i> Đăng xuất</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
