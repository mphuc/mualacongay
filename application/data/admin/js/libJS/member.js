$(document).ready(function(){         
     // -----------Phân trang sản phẩm-------------- 
    function init_member_admin(){
        $.post(base_url + 'member/count_all_member_admin').done(function(data){    
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
                        search_member_admin(num); 
                    else if($filter){
                        filter_member_admin(num);
                    }else
                        get_member_admin(num);
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
                        search_member_admin(num); 
                    else if($filter)
                        filter_member_admin(num);
                    else
                        get_member_admin(num);
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_member_admin(1);
        })
    }
    init_member_admin(); //----khởi tạo---

    $('.selector_limit_item').change(function(){
        $key = trim($('#input_search').val()); 
        $filter = $('.form_filter input[type="radio"]:not(.clear_filter)');
        $filter = $filter.is(':checked');
        if($key != ''){
            reset_pagination_search_member_admin(); 
        }else if($filter){
            reset_pagination_filter_member_admin();  
        }else{ 
            $.post(base_url + 'member/count_all_member_admin').done(function(data){
                $number = parseInt($('.selector_limit_item').val());   
                $total_page = Math.ceil(data/$number); 
                $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                get_member_admin(1);
                $to = ($number > $result.count) ? $result.count:$number;
                info_page_item(1,$to,data);
            })
        }
    }) 
    function get_member_admin($page){  
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1;  
        $.post(base_url + 'member/get_member_admin',({'offset':$offset,'number':$number})).done(function(data){
            $result = JSON.parse(data);
            $('#member_admin tbody').html($result.list_member);  
            if ($result.list_member == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1;
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count; 
            info_page_item($from,$to,$result.count);
        })
    }
    function reset_pagination_all_member_admin(){
        $.post(base_url + 'member/count_all_member_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_member_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    } 
    
    // ------SEARCH SẢN PHẨM--------- 
    $('.form_search').on('submit',function(e){
        e.preventDefault();
        $key = trim($('#input_search').val()); 
        if($key == ''){
            reset_pagination_all_member_admin();
            $('#input_search').removeClass('bg_search');
        }else{
            load_get_data();
            
            $('#input_search').addClass('bg_search');
            $number = parseInt($('.selector_limit_item').val()); 
            $.post(base_url + 'member/search_member_admin',({'key':$key,'number':$number,'offset':0 })).done(function(data){
                $result = JSON.parse(data);
                $('#member_admin tbody').html($result.list_search);
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
    function search_member_admin($page){ 
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        $key = $('#input_search').val();
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0;
        ($page == 0) ? $offset = 0 : $offset = $offset;
        $.post(base_url + 'member/search_member_admin',({'key':$key,'offset':$offset,'number':$number })).done(function(data){
            $result = JSON.parse(data);
            $('#member_admin tbody').html($result.list_search);
            if ($result.list_search == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1; 
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count;
            info_page_item($from,$to,$result.count);
        })
    }
    function reset_pagination_search_member_admin(){
        $key = $('#input_search').val();
        $.post(base_url + 'member/count_search_member_admin',({'key':$key })).done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            search_member_admin($page);  
        })
    }  
    $('.clear_search').click(function(){
        $('#input_search').val(''); 
        reset_pagination_all_member_admin();
        $('#input_search').removeClass('bg_search');
    })   


    // ---------------- FILTER sanpham---------  
    $('.form_filter input[type="radio"]:not(.clear_filter)').change(function(){ 
        reset_pagination_filter_member_admin();
    }) 
    function filter_member_admin($page){ 
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        $val = $('.form_filter input[type="radio"]:checked').val();
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0;
        ($page == 0) ? $offset = 0 : $offset = $offset; 
        $.post(base_url + 'member/filter_member_admin',({'val':$val,'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#member_admin tbody').html($result.list_search);
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
    function reset_pagination_filter_member_admin(){
        $val = $('.form_filter input[type="radio"]:checked').val();
        $.post(base_url + 'member/count_filter_member_admin',({'val':$val})).done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            filter_member_admin($page);  
        })
    }    
    $('.clear_filter').click(function(){
        $('#input_filter').val(''); 
        reset_pagination_all_member_admin();
        $('#input_filter').removeClass('bg_search');
        $('.form_filter input[type="radio"]:not(.clear_filter)').removeAttr('checked');
    })  
 
 
})