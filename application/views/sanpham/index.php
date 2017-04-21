<div class="col-lg-9 col-sm-8 right_content" style="margin-top: 16px;">
    <div class="row">
        <div class="product-container">
        <div class="row">
            <div class="col-md-6">
                <div class="fotorama"  
                 data-width="100%"
                 data-ratio="2/2"
                 data-max-width="100%"
                 data-nav="thumbs"
                 data-stop-autoplay-on-touch="true" style="height: 280px;"> 
                    <img src="<?=$chitiet_sanpham['images'] ?>" class="images_main"  onerror="imgError(this)" alt="<?=$chitiet_sanpham['TenSP']?>" >
                    <?php  foreach ($chitiet_hinhanh_sanpham as $item) { ?>
                        <img src="<?=PATH_IMAGE.$item['Image'].TYPE_IMAGE?>" onerror="imgError(this)" alt="<?=$chitiet_sanpham['TenSP']?>" >
                    <?php } ?> 
                </div> 
                <div class="text-center">
                <?php if ($chitiet_sanpham['images1'] != "") { ?>
                    <img style="width: 95px; height: 95px; cursor: pointer;" class="click_img" src="<?=$chitiet_sanpham['images1'] ?>" >
                <?php } ?>
                <?php if ($chitiet_sanpham['images2'] != "") { ?>
                    <img style="width: 95px; height: 95px; cursor: pointer;" class="click_img" src="<?=$chitiet_sanpham['images2'] ?>" >
                <?php } ?>
                <?php if ($chitiet_sanpham['images3'] != "") { ?>
                    <img style="width: 95px; height: 95px; cursor: pointer;" class="click_img" src="<?=$chitiet_sanpham['images3'] ?>" >
                <?php } ?>
                <?php if ($chitiet_sanpham['images4'] != "") { ?>
                    <img style="width: 95px; height: 95px; cursor: pointer;" class="click_img" src="<?=$chitiet_sanpham['images4'] ?>" >
                 <?php } ?>
                </div> 
                <div class="clearfix"></div>
                <script type="text/javascript">
                    $('.click_img').click(function(){
                    
                        $('.fotorama__img').attr('src',$(this).attr('src'));
                    })
                </script>
            </div>
            <div class="col-md-6">
                <h1 class="title_chitiet_sp"><?=$chitiet_sanpham['TenSP']?></h1>
                <div class="gia_chitiet_sp"> 
                    <?php  
                        if( $giamoi  == 0 && $giacu == 0 ){ 
                            echo '<span class="giamoi_chitiet_sp">Giá: Liên hệ</span>';
                        }else if( $giamoi  == null || $giamoi == 0){ 
                            echo '<span class="giamoi_chitiet_sp">'.$giacu.' VND</span>';
                        }else{
                            if($giamoi != $giacu){
                                $giacu = ($giacu == 0) ? '' : $giacu; 
                                echo '<span class="giamoi_chitiet_sp">'.$giamoi.' VND</span>';
                                echo '<span class="giacu_chitiet_sp">'.$giacu.' VND</span>';
                            }else{
                                
                                
                                echo '<span class="giamoi_chitiet_sp">'.$giamoi.' VND</span>';
                            } 
                        }  

                        if( !$connect_server ) { 
                            echo '<div class=""><b>Cập nhật lúc:</b><span class="attr_value"> '.date("H:i:s d/m/Y", strtotime($chitiet_sanpham['NgayUpdateGia'])).'</span></div>';
                        }
                    ?>
                </div>
                <div class="item_row"><b> Mã sản phẩm: </b> <span class="attr_value"><?=$chitiet_sanpham['MaSP']?></span></div>
                <div class="item_row"><b>Mô tả: </b><span class="attr_value">
                    <?=$chitiet_sanpham['MoTa']?></span>
                </div>
                <div class="call_sanpham">
                    <b>MUA HÀNG GỌI:</b>
                    <span class="attr_value"><?=$thongtin['SDT']?></span>
                    để được tư vấn trực tiếp.
                </div>
                <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                <div class="call_sanpham" style="margin: 15px 0">
                    <div class="fb-like" data-href="<?php echo $actual_link ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                </div>
                <div class="order_chitiet_sanpham">
                    
                    <div class="block_quantity">
                        <input type="button" class="sub_quantity" value="-">
                        <input type="text" class="value_quantity" value="1">
                        <input type="button" class="add_quantity" value="+">
                    </div>
                    <button style="height: 38px; margin-left: 20px;" type="button" class="order_sanpham btn add_cart2 add_chitiet_sanpham btn btn-default" SanPhamID="<?=$chitiet_sanpham['SanPhamID'];?>"> Thêm vào giỏ hàng </button>
                </div>
               
                    </div>

                </div>
		
    </div>  

    <div class="clearfix"></div>
    <div class="description" style="width: 100%; float: left;margin-top: 85px;">
        <h3 class="text-center" style="margin-bottom: 30px;">Mô tả sản phẩm</h3>
        <?=$chitiet_sanpham['NoiDung']?>
    </div>
    <div class="clearfix"></div>
    <div class="commnet_fb">



        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.9&appId=113193265882320";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
        <div class="fb-comments" data-href="<?php echo $actual_link; ?>" data-width="100%" data-numposts="20"></div>
    </div>
    <div class="clearfix"></div>
    <div class="thongtin_sanpham">
        <h3 class="text-center" style="margin-bottom: 30px;">Sản phẩm cùng loại</h3>
        
        <ul class="ProductList">
            <?php if(count($sanpham_cungloai)){ 
                    foreach ($sanpham_cungloai as $item) { ?>
                        <div class="product col-lg-4 col-sm-6 new custom">
                <div class="product-thumb">
                    <a href="<?=base_url()?>san-pham/<?=url_title(removesign($item['TenSP']))?>_<?=$item['SanPhamID']?>" class="thumb-link">
                        
                        <img class="front-img img-responsive" style="height: 220px;" src="<?php echo $item['images'] ?>" alt="<?=$item['TenSP']?>">
                    </a>
                   
                    <div class="product-btn">
                        <a class="to-cart add_cart" SanPhamID="<?=$item['SanPhamID'];?>" title="Thêm vào giỏ hàng" data-loading-text="Loading..." href="#"><i class="fa fa-shopping-cart"></i><span class="tooltip">Thêm giỏ hàng</span></a>
                        
                        <a class="to-view"  href="<?=base_url()?>san-pham/<?=url_title(removesign($item['TenSP']))?>_<?=$item['SanPhamID']?>"><i class="fa fa-eye"></i><span class="tooltip">Xem chi tiết</span></a>
                    </div>
                </div>
                <div class="product-info">
                    <h5 class="product-name"><a href="#"><?=$item['TenSP']?></a></h5>
                    
                    <p class="price"><?php echo number_format($item['GiaMoi']); ?> VNĐ</p>
                </div>
            </div>
                <?php }
                } else {
                    echo 'Không có sản phẩm để hiển thị!'; 
                } ?> 
            <?php if(count($sanpham_cungloai)) { ?>
            <div class="xemthem_sanpham_cungloai">
                <a href="<?=base_url();?>loai/<?=$loaisp['LoaiSPID'];?>/<?=url_title(removesign($loaisp['TenLoaiSP']));?>">
                <div class="clearfix"></div>
                    Xem thêm về loại sản phẩm <?=$loaisp['TenLoaiSP'];?>
                </a>
            </div>
            <?php } ?>
        </ul> 
    </div> 
    </div>
</div>

<?php
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $date= date("H:i - Y/m/d"); 
?>
<script type="text/javascript" src="<?=data_url?>js/twbsPagination/jquery.twbsPagination.js" ></script> 
<script type="text/javascript">
$(document).ready(function(){
     function animate_image(){
        var $size = $('.ProductList .ProductImage').length;
        var i=0;
        $timer = setInterval(function(){
            $('.ProductList .ProductImage').eq(i).animate({opacity:'1'},40);
            // $('.list_hinhanh_album .item_hinhanh').addClass('animate_hinhanh_album');
            i++;
            if(i==$size){
                clearInterval($timer);
            }
        } ,50);
    }
    animate_image();
    // =========bình luận sản phẩm===============
    $('.noidung').val('');
    $('body').on('focus','.noidung',function(){
        $(this).parents('.form_binhluan').find('.bottom_binhluan').slideDown();
    }) 
    
    // --------------binhluan----------------------
    $("#form_binhluan_main").validate({
        submitHandler: function(form) { 
            binhluan();
        }
    });      
    function binhluan(){    
        var $btn = $('#submit_binhluan').button('loading');
        $Ten = $("#form_binhluan_main .ten").val();
        $Email = $("#form_binhluan_main .email").val();
        $NoiDung = $("#form_binhluan_main .noidung").val(); 
        $Ngay = '<?=$date?>';

        $.post(base_url+'binhluan/insert_binhluan',$("#form_binhluan_main").serialize()).done(
        function(data){ 
            $btn.button('reset');
            if(data != 0){ 
                // -------------add binh luan-----------------
                $t='<li class="item_binhluan fadeInUp animated">'+
                        '<img class="left_item" src="'+data_url+'/img/user.png">'+
                        '<div class="right_item">'+
                            '<p class="ten_binhluan">'+ $Ten +' <span class="email_binhluan">' + $Email + '</span></p>'+
                            '<p class="noidung_binhluan">'+$NoiDung+'</p>'+
                            '<div class="bottom_item"> '+
                                '<span class="traloi_binhluan" BinhLuanID="' + data +'">Trả lời</span>'+
                                '<span class="ngay_binhluan">'+ $Ngay +'</span>'+
                            '</div>'+
                            '<div class="all_binhluan_sub">'+
                                '<ul>'+
                                '</ul>'+
                            '</div>'+
                            '<div class="content_form_sub"></div>'+
                        '</div>'+
                    '</li>';
                $('.list_all_binhluan').prepend($t);

                // ------------remove------------
                $('#form_binhluan_main .noidung').val(''); 
                $('.bottom_binhluan').slideUp();  
            }else {
                notice('red','<i class="fa fa-warning"></i> Đăng nhập thất bại!');
            }
        });  
    } 

    // -------------------binhluan_sub----------------------
    $('body').on('click','.traloi_binhluan',function(){
        $form = $(this).parents('.item_binhluan').find('.content_form_sub');
        $form.html($('#form_binhluan_sub'));
        $BinhLuanID = $(this).attr('BinhLuanID');
        $form.find('.BinhLuanID').val($BinhLuanID);
        $('#form_binhluan_sub .noidung').focus(); 
    })

    $("#form_binhluan_sub").validate({
        submitHandler: function(form) { 
            binhluan_sub();
        }
    });      
    function binhluan_sub(){    
        var $btn = $('#submit_binhluan_sub').button('loading');
        $Ten = $("#form_binhluan_sub .ten").val();
        $Email = $("#form_binhluan_sub .email").val();
        $NoiDung = $("#form_binhluan_sub .noidung").val(); 
        $Ngay = '<?=$date?>';

        $.post(base_url+'binhluan/insert_binhluan_sub',$("#form_binhluan_sub").serialize()).done(
        function(data){ 
            $btn.button('reset');
            if(data != 0){ 
                // -------------add binh luan-----------------
                $t='<li class="item_binhluan fadeInUp animated">'+
                        '<img class="left_item" src="'+data_url+'/img/user.png">'+
                        '<div class="right_item">'+
                            '<p class="ten_binhluan">'+ $Ten +' <span class="email_binhluan">' + $Email + '</span></p>'+
                            '<p class="noidung_binhluan">'+$NoiDung+'</p>'+
                            '<div class="bottom_item"> '+
                                '<span class="ngay_binhluan">'+ $Ngay +'</span>'+
                            '</div>'+
                        '</div>'+
                    '</li>';
                $("#form_binhluan_sub").parents('.item_binhluan').find('.all_binhluan_sub').append($t);

                // ------------remove------------
                $('#form_binhluan_sub .noidung').val(''); 
                $('.hidden_form_binhluan').html($("#form_binhluan_sub"));
            }else {
                notice('red','<i class="fa fa-warning"></i> Đăng nhập thất bại!');
            }
        }); 
    }

    // ====================phan trang bình luận========================
    $base_url = '<?=base_url();?>'; 
    $cur_page = parseInt('<?=$cur_page;?>'); 
    $all_page = parseInt('<?=$all_page;?>');   
    $SanPhamID = '<?=$chitiet_sanpham["SanPhamID"]?>';

    if($all_page >= $cur_page){
        $('#pagination_binhluan').twbsPagination({
            totalPages: $all_page,
            visiblePages: 5,
            startPage: $cur_page,  
            onPageClick: function (event, page) {
                $('.hidden_form_binhluan').html($("#form_binhluan_sub"));
                load_ajax_in('.list_all_binhluan');
                $('html,body').animate({'scrollTop':$('.binhluan_sanpham').offset().top},500,function(){
                    url = $base_url + 'sanpham/phantrang_binhluan';   
                    $.post(url,({"page":page,"SanPhamID":$SanPhamID})).done(
                        function(html){
                            $('.list_all_binhluan').html(html);    
                            load_ajax_out('.list_all_binhluan');
                            $("#form_binhluan_sub").validate({
                                submitHandler: function(form) { 
                                    binhluan_sub();
                                }
                            });   
                        }
                    ); 
                    return false;
                });
            } 
        });
    }

    })
</script>

