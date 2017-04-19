$(document).ready(function(){   
    load_get_data();
    load_ajax_in('.nav_item');

    // ========= UPDATE DATA==========
    $('#update_sanpham').click(function(){
        var $btn = $(this).button('loading');
        load_ajax_in('.nav_item');
        $.post(base_url+'data/update_sanpham',{}).done(
            function(data){
                load_ajax_out('.nav_item');
                $btn.button('reset');
                message(1,'Cập nhật thành công!');
                reset_pagination_all_hoadononline_admin();
            })
    })

    // ========= UPDATE DATA==========

     // -----------Phân trang sản phẩm-------------- 
    function init_hoadononline_admin(){
        $.post(base_url + 'hoadononline/count_all_hoadononline_admin').done(function(data){    
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
                    $filter = $('.form_filter input[type="radio"]:not(.clear_filter)');
                    $filter = $filter.is(':checked');
                    if( trim($('#input_search').val()) != '' )
                        search_hoadononline_admin(num); 
                    else if($filter){
                        filter_hoadononline_admin(num);
                    }else
                        get_hoadononline_admin(num);
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
                    $filter = $('.form_filter input[type="radio"]:not(.clear_filter)');
                    $filter = $filter.is(':checked');
                    if( trim($('#input_search').val()) != '' )
                        search_hoadononline_admin(num); 
                    else if($filter)
                        filter_hoadononline_admin(num);
                    else
                        get_hoadononline_admin(num);
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_hoadononline_admin(1);
        })
    }
    init_hoadononline_admin(); //----khởi tạo---

    $('.selector_limit_item').change(function(){
        $key = trim($('#input_search').val()); 
        $filter = $('.form_filter input[type="radio"]:not(.clear_filter)');
        $filter = $filter.is(':checked');
        if($key != ''){
            reset_pagination_search_hoadononline_admin(); 
        }else if($filter){
            reset_pagination_filter_hoadononline_admin();  
        }else{ 
            $.post(base_url + 'hoadononline/count_all_hoadononline_admin').done(function(data){
                $number = parseInt($('.selector_limit_item').val());   
                $total_page = Math.ceil(data/$number); 
                $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                get_hoadononline_admin(1);
                $to = ($number > $result.count) ? $result.count:$number;
                info_page_item(1,$to,data);
            })
        }
    }) 
    function get_hoadononline_admin($page){  
        load_get_data();
        load_ajax_in('.nav_item');

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1;  
        $.post(base_url + 'hoadononline/get_hoadononline_admin',({'offset':$offset,'number':$number})).done(function(data){
            load_ajax_out('.nav_item');

            $result = JSON.parse(data);
            $('#hoadononline_admin tbody').html($result.list_sp);  
            $(".tablesorter").trigger('update');  
            $('[data-toggle="tooltip"]').tooltip();  
            if ($result.list_sp == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1;
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count; 
            info_page_item($from,$to,$result.count);
        })
    }
    function reset_pagination_all_hoadononline_admin(){
        load_get_data();
        load_ajax_in('.nav_item');

        $.post(base_url + 'hoadononline/count_all_hoadononline_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_hoadononline_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    } 

    // --------------sort sản phẩm-----------
    $("#hoadononline_admin").tablesorter({headers: {
        0: { sorter: false }, 
        1: { sorter: false }, 
        2: { sorter: false }, 
        3: { sorter: false }, 
        6: { sorter: false }, 
        7: { sorter: false }, 
    }});
    
    // ------SEARCH SẢN PHẨM--------- 
    $('.form_search').on('submit',function(e){
        e.preventDefault();
        $key = trim($('#input_search').val()); 
        if($key == ''){
            reset_pagination_all_hoadononline_admin();
            $('#input_search').removeClass('bg_search');
        }else{
            load_get_data();
            
            $('#input_search').addClass('bg_search');
            $number = parseInt($('.selector_limit_item').val()); 
            $.post(base_url + 'hoadononline/search_hoadononline_admin',({'key':$key,'number':$number,'offset':0 })).done(function(data){
                $result = JSON.parse(data);
                $('#hoadononline_admin tbody').html($result.list_search);
                $(".tablesorter").trigger('update'); 
                $('[data-toggle="tooltip"]').tooltip();
                $total_page = Math.ceil($result.count/$number);  
                $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                $from = ($result.list_search == '') ? 0:1;
                $to = ($number > $result.count) ? $result.count:$number;
                info_page_item($from,$to,$result.count);  
            }) 
        } 
        $('.popup_form_search').hide();
        $('#input_filter').val(''); 
        $('#input_filter').removeClass('bg_search');
        $('.form_filter input[type="radio"]').removeAttr('checked'); 
    })
    function search_hoadononline_admin($page){ 
        load_get_data();
        load_ajax_in('.nav_item');

        $number = parseInt($('.selector_limit_item').val());   
        $key = $('#input_search').val();
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0;
        ($page == 0) ? $offset = 0 : $offset = $offset;
        $.post(base_url + 'hoadononline/search_hoadononline_admin',({'key':$key,'offset':$offset,'number':$number })).done(function(data){
            load_ajax_out('.nav_item');
            
            $result = JSON.parse(data);
            $('#hoadononline_admin tbody').html($result.list_search);
            $(".tablesorter").trigger('update');
            $('[data-toggle="tooltip"]').tooltip();
            if ($result.list_search == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1; 
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count;
            info_page_item($from,$to,$result.count);
        })
    }
    function reset_pagination_search_hoadononline_admin(){
        load_get_data();
        load_ajax_in('.nav_item');

        $key = $('#input_search').val();
        $.post(base_url + 'hoadononline/count_search_hoadononline_admin',({'key':$key })).done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            search_hoadononline_admin($page);  
        })
    }  
    $('.clear_search').click(function(){
        $('#input_search').val(''); 
        reset_pagination_all_hoadononline_admin();
        $('#input_search').removeClass('bg_search');
    })   


    // ---------------- FILTER sanpham---------  
    $('.form_filter input[type="radio"]:not(.clear_filter)').change(function(){ 
        reset_pagination_filter_hoadononline_admin();
    }) 
    function filter_hoadononline_admin($page){ 
        load_get_data();
        load_ajax_in('.nav_item');

        $number = parseInt($('.selector_limit_item').val());   
        $val = $('.form_filter input[type="radio"]:checked').val();
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0;
        ($page == 0) ? $offset = 0 : $offset = $offset; 
        $.post(base_url + 'hoadononline/filter_hoadononline_admin',({'val':$val,'number':$number,'offset':$offset})).done(function(data){
            load_ajax_out('.nav_item');
            
            $result = JSON.parse(data);
            $('#hoadononline_admin tbody').html($result.list_search);
            $(".tablesorter").trigger('update');
            $('[data-toggle="tooltip"]').tooltip();
            if ($result.list_search == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1; 
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count;
            info_page_item($from,$to,$result.count);
        })
        $('#input_search').val(''); 
        $('#input_search').removeClass('bg_search');
    }
    function reset_pagination_filter_hoadononline_admin(){
        load_get_data();
        load_ajax_in('.nav_item');

        $val = $('.form_filter input[type="radio"]:checked').val();
        $.post(base_url + 'hoadononline/count_filter_hoadononline_admin',({'val':$val})).done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            filter_hoadononline_admin($page);  
        })
    }    
    $('.clear_filter').click(function(){
        $('#input_filter').val(''); 
        reset_pagination_all_hoadononline_admin();
        $('#input_filter').removeClass('bg_search');
        $('.form_filter input[type="radio"]:not(.clear_filter)').removeAttr('checked');
    })  


    // =====================CHI TIẾT HÓA ĐƠN==================== 
    // ----------------fancybox---------------
    $('.fancybox').fancybox({ 
        type:'ajax',
        maxWidth    : 800,
        maxHeight   : 600,
        fitToView   : false,
        height: '95%',  
        width : '70%',
    });  
    // =====================CHI TIẾT HÓA ĐƠN==================== 

    $('body').on('change','.select_tinhtrang',function(){
        HoaDonOnlineID = $(this).attr('HoaDonOnlineID');
        TinhTrang = $(this).val();
        $.post(base_url + 'hoadononline/update_tinhtrang',({"TinhTrang":TinhTrang,"HoaDonOnlineID":HoaDonOnlineID})).done(
            function(data){
                if(data == 1){ 
                    message(1,'Cập nhật thành công!');
                }else{
                    message(2,'Cập nhật không thành công!');
                }
            })

    })

 
})