$(document).ready(function(){   
  
     // -----------Phân trang sản phẩm-------------- 
    function init_loaisp_admin(){
        $.post(base_url + 'loaisp/count_all_loaisp_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $(".pagination_sp1").jPaginator({
                nbPages:$total_page,
                speed: 5,
                nbVisible:8,
                selectedPage:1, 
                overBtnLeft:'.pre_left',
                overBtnRight:'.next_right',
                maxBtnLeft:'.first_left',
                maxBtnRight:'.last_right',
                minSlidesForSlider:2,
                onPageClicked: function(a,num) { 
                    get_loaisp_admin(num);
                    $(".pagination_sp2").trigger("reset",{ selectedPage:num }); 
                }
            });     
            $(".pagination_sp2").jPaginator({
                nbPages:$total_page,
                speed: 5,
                nbVisible:8,
                selectedPage:1, 
                overBtnLeft:'.pre_left',
                overBtnRight:'.next_right',
                maxBtnLeft:'.first_left',
                maxBtnRight:'.last_right',
                minSlidesForSlider:5,
                onPageClicked: function(a,num) { 
                    get_loaisp_admin(num);
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_loaisp_admin(1);
        })
    }
    init_loaisp_admin(); //----khởi tạo---
    $('.selector_limit_item').change(function(){ 
        $.post(base_url + 'loaisp/count_all_loaisp_admin').done(function(data){
            $number = parseInt($('.selector_limit_item').val());   
            $total_page = Math.ceil(data/$number); 
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            get_loaisp_admin(1);
            $to = ($number > $result.count) ? $result.count:$number;
            info_page_item(1,$to,data);
        })
    }) 
    function get_loaisp_admin($page){  
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1;  
        $.post(base_url + 'loaisp/get_loaisp_admin',({'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#loaisp_admin tbody').html($result.list_loaisp); 
            $(".tablesorter").trigger('update');    
            if ($result.list_loaisp == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1;
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count; 
            info_page_item($from,$to,$result.count); 
        })
    }
    function reset_pagination_all_loaisp_admin(){
        $.post(base_url + 'loaisp/count_all_loaisp_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number); 
            $page = $('.pagination_item .selected').html();
            if( $page > $total_page ){
                $page = $total_page;
            }
            ($page == 0) ? $page = 1 : $page;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_loaisp_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    } 

    // --------------sort loai sản phẩm-----------
    $("#loaisp_admin").tablesorter({headers: {
        0: { sorter: false },
        2: { sorter: false },
        9: { sorter: false } 
    }});
     

    // $(".form_add_edit").submit(function(){
        
    //     if($(".form_add_edit").hasClass('form_add'))
    //         add_loaisp();         
    //     else if($(".form_add_edit").hasClass('form_edit'))
    //     {
    //         edit_loaisp();
    //     }
    // })
    $('body').on('click','.form_add .ok_add_edit',function(){
        $('.form_add .ok_add_edit').button('loading');
        TenLoaiSP = $('#input_tieude').val();
        MaLoaiSP = $('#input_maloai').val();
        DanhMucID = $('#input_danhmuc').val();
        $.post(base_url+'loaisp/insert_loaisp',{
            "TenLoaiSP":TenLoaiSP,"MaLoaiSP" : MaLoaiSP , "DanhMucID" : DanhMucID}).done(
            function(data){
                $(' .form_add .ok_add_edit').button('reset');
                if( typeof result === 'object') {
                    $.fancybox.close();
                    $(' .form_edit .ok_add_edit').button('reset');
                    message(1,'Thêm thành công!');
                    load_ajax_out('.form_add_edit');
                    $('.wrapper_content_right').removeClass('active');
                    $('.form_content_right').hide(10).animate({left:'-100%',opacity: 0},10,function(){
                    });
                     $('.table_content_right').show(10).animate({left:0,opacity: 1},10,function(){
                    });
                     reset_pagination_all_loaisp_admin();
                     setTimeout(function(){// wait for 5 secs(2)
                           location.reload(); // then reload the page.(3)
                      }, 400); 
                }else{ 
                    message(2,'Cập nhật không thành công!');
                } 

            })
    })
    $('body').on('click','.form_edit .ok_add_edit',function(){
        
        $('.form_edit .ok_add_edit').button('loading');
        LoaiSPID = $('.form_add_edit').attr('loaispid');
        TenLoaiSP = $('#input_tieude').val();
        MaLoaiSP = $('#input_maloai').val();
        DanhMucID = $('#input_danhmuc').val();
        $.post(base_url+'loaisp/edit_loaisp',{
            "TenLoaiSP":TenLoaiSP,"MaLoaiSP" : MaLoaiSP , "DanhMucID" : DanhMucID, "LoaiSPID":LoaiSPID
        }).done(
            function(data){
                $(' .form_edit .ok_add_edit').button('reset');
                if( typeof result === 'object') {
                    $.fancybox.close();
                    
                    message(1,'Cập nhật thành công!');
                    load_ajax_out('.form_add_edit');
                    $('.wrapper_content_right').removeClass('active');
                    $('.form_content_right').hide(10).animate({left:'-100%',opacity: 0},10,function(){
                    });
                     $('.table_content_right').show(10).animate({left:0,opacity: 1},10,function(){
                    }); 
                     reset_pagination_all_loaisp_admin();
                }else{ 
                    message(2,'Cập nhật không thành công!');
                } 
            })
    })
    
    // ---------------EDIT dm---------------
    $('body').on('click','.edit_tintuc',function(){
        $(".form_add_edit p.error").remove();
    
        LoaiSPID = $(this).attr('LoaiSPID');

        $.post(base_url + 'loaisp/get_chitiet_loaisp_admin',{"LoaiSPID":LoaiSPID}).done(function(data){
            kq = JSON.parse(data);
            
            $('#input_tieude').val(kq['TenLoaiSP']);  
            $('#input_maloai').val(kq['MaLoaiSP']);  
            $('#input_danhmuc').val(kq['DanhMucID']);   
            
            $('.form_add_edit').removeClass('form_add');
            $('.form_add_edit').addClass('form_edit');
            $('.form_add_edit').attr('LoaiSPID',kq['LoaiSPID']);
            $('.close_add_edit').hide();
            $('html,body').animate({'scrollTop': 0},10);
            load_ajax_out('.form_add_edit');
        })
    })



    $('body').on('click','.ok_del_danhmuc',function(){
        $btn = $(this).button('loading');
        LoaiSPID = $(this).attr('LoaiSPID');
        $.post(base_url+'loaisp/delete_loaisp',{"LoaiSPID":LoaiSPID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    message(1,'Xóa thành công!');
                    reset_pagination_all_loaisp_admin();
                }else{
                    message(2,'Xóa không thành công!');
                   
                }
            });
    })
})