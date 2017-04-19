<article class="right_content"> 
    <div class="defaultTitle ">
        <span> Tìm kiếm</span>
        <div class="info_page_sanpham">
            Hiện <b><?=$from;?></b>  » <b><?=$to?></b> của <b><?=$all?></b> kết quả
        </div>
    </div>   

    <div class="defaultContent BlockContent">
        <p class="title_search"><b>Tìm kiếm sản phẩm</b>: Có <b><?=$all?></b> kết quả tìm kiếm cho từ khóa <b>"<?=$key?>"</b></p>
        <ul class="list_search">
            <?php 
            if(!is_array($list_search_sanpham)){ 
                echo 'Không có sản phẩm để hiển thị!'; 
            } else {
                foreach ($list_search_sanpham as $item) {  ?>
                    <li> 
                        <a href="<?=base_url()?>san-pham/<?=url_title(removesign($item['TenSP']))?>_<?=$item['SanPhamID']?>"
                           class="image" style="background-image: url(<?=$item['images']?>), url(<?=base_url()?>application/data/img/notFound.png)">
                        </a>
                        <div class="right_item_search">
                            <a href="<?=base_url()?>san-pham/<?=url_title(removesign($item['TenSP']))?>_<?=$item['SanPhamID']?>">
                                <p class="tensp"><?=$item['TenSP']?></p>
                            </a> 
                            <p class="ngay">Mã sản phẩm: <b> <?=$item['MaSP']?></b> </p>
                        </div>
                    </li>
            <?php }
            } ?>

        </ul>  
        <div id="pagination_sanpham" class="pagination"></div>
    </div>
</article>


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
                    url = $base_url + 'san-pham/search/'+$key+'/trang-'+ page + '.html';   
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

