<div class="col-lg-9 col-sm-8 right_content" style="margin-top: 16px;">
    <div class="row">
        <div class="product-container">
    <div class="defaultTitle ">
        <span> Tin tức thời trang trẻ em</span>
        <div class="info_page_sanpham text-right">
            Hiện <b><?=$from;?></b>  » <b><?=$to?></b> của <b><?=$all?></b> bài viết
        </div>
    </div>   

    <div class="defaultContent BlockContent">
        <ul class="list_tintuc">
            <?php 
            if(!is_array($list_tintuc)){ 
                echo 'Không có sản phẩm để hiển thị!'; 
            } else {
                foreach ($list_tintuc as $item) { 
                    $date = new DateTime($item['Ngay']);
                    $Ngay = $date->format(" d/m/Y - H:i"); ?> 
                    <li> 
                        <a href="<?=base_url()?>tin-tuc/<?=url_title(removesign($item['TieuDe']))?>_<?=$item['TinTucID']?>" alt="<?=$item['TieuDe']?>" class="image" style="background-image: url(<?=$item['Image']?>), url(<?=base_url()?>application/data/img/notFound.png) "></a>
                        <div class="right_tintuc">
                            <p class="tieude"><a href="<?=base_url()?>tin-tuc/<?=url_title(removesign($item['TieuDe']))?>_<?=$item['TinTucID']?>" alt="<?=$item['TieuDe']?>"><?=$item['TieuDe']?></a></p>
                            <p class="ngay"><?=$Ngay?></p>
                            <div class="mota"><?=$item['MoTa']?></div>
                        </div>
                    </li>

            <?php }
            } ?>

        </ul>  
        <div id="pagination_sanpham" class="pagination"></div>

    </div>
</div>
</div>
</div>


<script type="text/javascript" src="<?=data_url?>js/twbsPagination/jquery.twbsPagination.js" ></script> 
<script type="text/javascript" src="<?=data_url?>js/dotdotdot/jquery.dotdotdot.js"></script> 
<script type="text/javascript"> 
    $(window).resize(function(){
        $('.list_tintuc .mota').dotdotdot();
    })
    $('.list_tintuc .mota').dotdotdot();

    // ------------pagination_sanpham------------------  
    $base_url = '<?=base_url();?>'; 
    $cur_page = parseInt('<?=$cur_page;?>'); 
    $all_page = parseInt('<?=$all_page;?>');  

    if($all_page >= $cur_page){
        $('#pagination_sanpham').twbsPagination({
            totalPages: $all_page,
            visiblePages: 5,
            startPage: $cur_page,  
            onPageClick: function (event, page) {
                $('html,body').animate({'scrollTop':0},500,function(){
                    url = $base_url + 'tin-tuc/trang-'+ page + '.html';   
                    $.post(url,({"history":0})).done(
                        function(html){
                            $('.right_content').replaceWith(html);    
                            history.pushState(html , "Tiêu đề", url);
                            $(document).trigger('pageRefresh', [html]); 
                        }
                    ); 
                    return false;
                });
            } 
        });
    }

    window.document.title = '<?=$title?>';
    // ------------pagination_sanpham------------------ 

</script> 

