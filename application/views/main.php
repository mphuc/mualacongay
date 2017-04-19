<div class="col-lg-9 col-sm-8 right_content" style="margin-top: 16px;">
    <div class="row">
        <div class="product-container">
            <?php if(empty($list_sanpham)){ 
                echo 'Không có sản phẩm để hiển thị!'; 
            } else {
                foreach ($list_sanpham as $item) {  ?>
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
            <?php } } ?>
        </div>
        <div id="pagination_sanpham" class="pagination"></div>
    </div>
</div>



<script type="text/javascript" src="<?=data_url?>js/twbsPagination/jquery.twbsPagination.js" ></script> 
<script type="text/javascript"> 
$(document).ready(function(){  
    // ------------pagination_sanpham------------------ 
    <?php
        if(isset($loaisp))
            $path = 'loai/'.$loaisp['LoaiSPID'].'/'.url_title(removesign($loaisp['TenLoaiSP'])).'/';       
        else if(isset($danhmuc))
            $path = 'danh-muc/'.$danhmuc['DanhMucID'].'/'.url_title(removesign($danhmuc['TenDanhMuc'])).'/';
        else
            $path = 'san-pham/';
    ?> 
    $base_url = '<?=base_url();?>'; 
    $cur_page = parseInt('<?=$cur_page;?>'); 
    $all_page = parseInt('<?=$all_page;?>');  
    $path = '<?=$path;?>';  


    if($all_page >= $cur_page){
        $('#pagination_sanpham').twbsPagination({
            totalPages: $all_page,
            visiblePages: 5,
            startPage: $cur_page,  
            onPageClick: function (event, page) {
                $('html,body').animate({'scrollTop':0},400);
                url = $base_url + $path + 'trang-'+ page + '.html';   
                load_ajax_in('.content_loading_sanpham');
                $.post(url,({"history":0})).done(
                    function(html){
                        $('.right_content').replaceWith(html); 
                        history.pushState(html , "Tiêu đề", url);
                        $(document).trigger('pageRefresh', [html]); 
                    }
                ); 
                return false;
            } 
        });
    }
    window.document.title = '<?=$title?>';
    // ------------pagination_sanpham------------------ 

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
});
</script> 

