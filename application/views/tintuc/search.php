<div class="col-lg-9 col-sm-8 right_content" style="margin-top: 16px;">
    <div class="row">
        <div class="product-container">
    <div class="defaultTitle ">
        <span> Tìm kiếm</span>
        <div class="info_page_sanpham">
            Hiện <b><?=$from;?></b>  » <b><?=$to?></b> của <b><?=$all?></b> kết quả
        </div>
    </div>   

    <div class="defaultContent BlockContent">
        <p class="title_search"><b>Tìm kiếm tin tức</b>: Có <b><?=$all?></b> kết quả tìm kiếm cho từ khóa <b>"<?=$key?>"</b></p>
        <ul class="list_search">
            <?php 
            if(!is_array($list_search_tintuc)){ 
                echo 'Không có sản phẩm để hiển thị!'; 
            } else {
                foreach ($list_search_tintuc as $item) {  
                    $Ngay = date(" d/m/Y - H:s", strtotime($item['Ngay'])); ?>
                    <li> 
                        <a href="<?=base_url()?>tin-tuc/<?=url_title(removesign($item['TieuDe']))?>_<?=$item['TinTucID']?>"
                           class="image" style="background-image: url(<?=$item['Image']?>), url(<?=base_url()?>application/data/img/notFound.png)">
                        </a>
                        <div class="right_item_search">
                            <a href="<?=base_url()?>tin-tuc/<?=url_title(removesign($item['TieuDe']))?>_<?=$item['TinTucID']?>">
                                <p class="tensp"><?=$item['TieuDe']?></p>
                            </a>
                            <p class="ngay"><?=$Ngay?></p>
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
<script type="text/javascript">  
    // ------------pagination_sanpham------------------  
    $key = '<?=$key;?>'; 
    $base_url = '<?=base_url();?>'; 
    $cur_page = parseInt('<?=$cur_page;?>'); 
    $all_page = parseInt('<?=$all_page;?>');  

    if($all_page >= $cur_page){
        $('#pagination_sanpham').twbsPagination({
            totalPages: $all_page,
            visiblePages: 5,
            startPage: $cur_page,  
            onPageClick: function (event, page) {
                $('html,body').animate({'scrollTop':$('#Container').offset().top},500,function(){
                    url = $base_url + 'tin-tuc/search/'+$key+'/trang-'+ page + '.html';   
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

