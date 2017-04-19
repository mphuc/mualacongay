<section id="container">  
    <ul class="path">
        <li class="first"> <a href="<?=base_url()?>"><i class="fa fa-home"></i> Trang chủ</a> </li>
    </ul>

    <article class="left_content">  
        <aside class="nav_member">
            <div class="head_nav_member">
                <img src="<?=data_url?>img/avatarDefault.jpg">
                <?=$this->session->userdata("username_member")?>
            </div>
            <ul>
                <li><a href="<?=base_url()?>member.html" class="<?=($menuActive=='info')?' menuActive ':'';?>"><i class="fa fa-user"></i><span>Thông tin tài khoản</span></a></li>
                <li><a href="<?=base_url()?>member/history.html" class="<?=($menuActive=='history')?' menuActive ':'';?>"><i class="fa fa-calendar"></i><span>Lịch sử mua hàng</span></a></li>
                <li><a href="<?=base_url()?>member/temp.html" class="<?=($menuActive=='temp')?' menuActive ':'';?>"><i class="fa fa-calendar-o"></i><span>Đơn hàng chưa hoàn tất</span></a></li>
                <li><a href="<?=base_url()?>member/change.html" class="<?=($menuActive=='change')?' menuActive ':'';?>"><i class="fa fa-lock"></i><span>Đổi mật khẩu</span></a></li>
                <li><a href="<?=base_url()?>member/logout.html" ><i class="fa fa-mail-forward"></i><span>Thoát</span></a></li>
            </ul>
        </aside>
    </article>