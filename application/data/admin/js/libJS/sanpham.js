$(document).ready(function(){       
     //-----đếm số lượng item được check----------
    function count_check_tintuc(){
        $count_check  = [];
        $arr = $('.table_content_right tbody .checkbox_item');
        $.each($arr,function(i){
            if($(this).is(':checked')){
                $SanPhamID = $(this).attr('SanPhamID');
                $count_check.push($SanPhamID); 
            }
        })
        return $count_check;
    } 
     // -----------Phân trang sản phẩm-------------- 
    function init_sp_admin(){
        $.post(base_url + 'sanpham/count_all_sp_admin').done(function(data){    
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
                    $filter = get_type_filter_sp_admin();
                    if( trim($('#input_search').val()) != '' )
                        search_sp_admin(num); 
                    else if($filter.length > 0)
                        filter_sp_admin(num);
                    else
                        get_sp_admin(num);
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
                    $filter = get_type_filter_sp_admin();
                    if( trim($('#input_search').val()) != '' )
                        search_sp_admin(num); 
                    else if($filter.length > 0)
                        filter_sp_admin(num);
                    else
                        get_sp_admin(num);
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_sp_admin(1);
        })
    }
    init_sp_admin(); //----khởi tạo---
    $('.selector_limit_item').change(function(){
        $key = trim($('#input_search').val()); 
        $filter = get_type_filter_sp_admin();
        if($key != ''){
            reset_pagination_search_sp_admin(); 
        }else if($filter.length > 0){
            reset_pagination_filter_sp_admin();  
        }else{ 
            // load_ajax_in('.table_content_right');
            $.post(base_url + 'sanpham/count_all_sp_admin').done(function(data){
                $number = parseInt($('.selector_limit_item').val());   
                $total_page = Math.ceil(data/$number); 
                $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                get_sp_admin(1);
                $to = ($number > $result.count) ? $result.count:$number;
                info_page_item(1,$to,data);
                // load_ajax_out('.table_content_right');
            })
        }
    }) 
    function get_sp_admin($page){  
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1; 
        $.post(base_url + 'sanpham/get_sp_admin',({'offset':$offset,'number':$number})).done(function(data){
            $result = JSON.parse(data);
            $('#sp_admin tbody').html($result.list_sp); 
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
    function reset_pagination_all_sp_admin(){
        $("#filter_on_LoaiSPID").val(0); 
        $.post(base_url + 'sanpham/count_all_sp_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_sp_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    } 

    // --------------sort sản phẩm-----------
    $("#sp_admin").tablesorter({headers: {
        0: { sorter: false },
        2: { sorter: false },
        4: { sorter: false }, 
        6: { sorter: false }, 
    }});
    
    // ------SEARCH SẢN PHẨM--------- 
    $('.form_search').on('submit',function(e){
        e.preventDefault();
        $key = trim($('#input_search').val()); 
        if($key == ''){
            reset_pagination_all_sp_admin();
            $('#input_search').removeClass('bg_search');
        }else{
            // load_ajax_in('.table_content_right');
            $('#input_search').addClass('bg_search');
            $number = parseInt($('.selector_limit_item').val()); 
            $type = get_type_search_sp_admin();
            $.post(base_url + 'sanpham/search_sp_admin',({'key':$key,'number':$number,'offset':0,'type':$type})).done(function(data){
                $result = JSON.parse(data);
                $('#sp_admin tbody').html($result.list_search);
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
        $('.form_filter input[type="radio"]').removeAttr('checked');
    })
    function search_sp_admin($page){ 
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        $key = $('#input_search').val();
        $type = get_type_search_sp_admin();
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0;
        ($page == 0) ? $offset = 0 : $offset = $offset; 
        $.post(base_url + 'sanpham/search_sp_admin',({'key':$key,'offset':$offset,'number':$number,'type':$type})).done(function(data){
            $result = JSON.parse(data);
            $('#sp_admin tbody').html($result.list_search);
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
    function reset_pagination_search_sp_admin(){
        $key = $('#input_search').val();
        $type = get_type_search_sp_admin();
        $.post(base_url + 'sanpham/count_search_sp_admin',({'key':$key,'type':$type})).done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $page = 1; 
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            search_sp_admin($page);  
        })
    } 

    function get_type_search_sp_admin(){
        $arr = $('.popup_form_search input');
        $type = [];
        $.each($arr,function(){
            if($(this).is(':checked'))
                $type.push($(this).val());
        }) 
        if($type == ''){
            $type = null;  
        }
        return $type;
    }  
    $('.clear_search').click(function(){
        $('#input_search').val(''); 
        reset_pagination_all_sp_admin();
        $('#input_search').removeClass('bg_search');
    })   


    // ---------------- FILTER sanpham---------
    $('.form_filter input[type="radio"]:not(.clear_filter)').change(function(){ 
        reset_pagination_filter_sp_admin();
        $("#filter_on_LoaiSPID").val(0); 
    }) 

    $('#filter_on_LoaiSPID').change(function(){
        if($(this).val()!=0){
            $('.form_filter input[type="radio"]').removeAttr('checked');
            reset_pagination_filter_sp_admin();
        }else{
            reset_pagination_all_sp_admin();
        }
    }) 
    function filter_sp_admin($page){ 
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        $type = get_type_filter_sp_admin();
        $key = $type[0];
        $val = $type[1];
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0;
        ($page == 0) ? $offset = 0 : $offset = $offset; 
        $.post(base_url + 'sanpham/filter_sp_admin',({'key':$key,'val':$val,'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#sp_admin tbody').html($result.list_search);
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
        $('#input_search').val('').removeClass('bg_search');
    }
    function reset_pagination_filter_sp_admin(){
        $type = get_type_filter_sp_admin();
        $key = $type[0];
        $val = $type[1];
        $.post(base_url + 'sanpham/count_filter_sp_admin',({'key':$key,'val':$val,'type':$type})).done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $page = 1; 
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            filter_sp_admin($page);  
        })
    }  
    function get_type_filter_sp_admin(){ 
        $type = [];
        var radio = $('.form_filter input[type="radio"]:not(.clear_filter)');
        var i=0,ok=0;
        while (i < radio.length) {
            if($(radio[i]).is(':checked')){ 
                $type[0] = $(radio[i]).attr('key'); 
                $type[1] = $(radio[i]).attr('val'); 
                ok=1;
            } 
            i++;
        } 
        if(ok == 0 && $("#filter_on_LoaiSPID").val() != 0){
            $type[0] = $('#filter_on_LoaiSPID').attr('key'); 
            $type[1] = $("#filter_on_LoaiSPID").val(); 
        }

        return $type;
    }  
    $('.clear_filter').click(function(){
        reset_pagination_all_sp_admin();
        $('.form_filter input[type="radio"]:not(.clear_filter)').removeAttr('checked'); 
        $("#filter_on_LoaiSPID").val(0); 
    })  

    // ----------------fancybox---------------
    $('.fancybox').fancybox({ 
        type:'ajax',
        maxWidth    : 800,
        maxHeight   : 600,
        fitToView   : false,
        height: '95%',  
        width : '70%',
    });  


        //-----------------ADD sp---------------
    function reset_form_add_edit(){
        validator.resetForm();
        $('#input_tieude').val('');   
        tinyMCE.editors['tinymce4_mota'].setContent(''); 
        tinyMCE.editors['tinymce4_noidung'].setContent(''); 
        $('html,body').animate({'scrollTop': 0},200);
        load_ajax_out('.form_add_edit');
    }
    $('.reset_form_add_edit').click(function(){
        reset_form_add_edit();
    })

    $('body').on('click','.add_sp',function (){
        $('.form_add_edit').removeClass('form_edit');
        $('.form_add_edit').addClass('form_add');
        $('.form_add_edit').removeAttr('IDsp');
        $('.close_add_edit').show();
        reset_form_add_edit();
    })   
    function remove_appen(){
        $('.item_image_ap i').click(function(){
            $(this).parent('.item_image_ap').remove();
        });
    }   
    function add_baiviet(){

        $('.ok_add_edit').button('loading');
        TenSP = $('#input_tieude').val();
        NoiDung = tinyMCE.editors['tinymce4_noidung'].getContent(); 
        MoTa = tinyMCE.editors['tinymce4_mota'].getContent(); 
        MaSP =  $('#input_masp').val();
        GiaVon =  $('#input_giasp').val();
        TonKho =  $('#input_soluongsp').val();
        LoaiSPID =  $('#input_danhmuc').val();
        //images = $('#fieldID').val();
        images = images1 = images2 = images3 = images4 = "";
        var id_element = $('.images_appen').length;

        if (id_element >= 1) 
        {
            images = $('.img_append_0').val()
        }
        if (id_element >= 2) 
        {
            images1 = $('.img_append_1').val()
        }
        if (id_element >= 3) 
        {
            images2 = $('.img_append_2').val()
        }
        if (id_element >= 4) 
        {
            images3 = $('.img_append_3').val()
        }
        if (id_element >= 5) 
        {
            images4 = $('.img_append_4').val()
        }
        $.post(base_url+'sanpham/insert_sanpham',{
            "TenSP":TenSP,"NoiDung":NoiDung,"MoTa":MoTa,"MaSP": MaSP,"GiaVon":GiaVon, "TonKho":TonKho,"LoaiSPID" : LoaiSPID,"images" : images,"images1" : images1,"images2" : images2,"images3" : images3,"images4" : images4 }).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    $('#input_tieude').focus();
                    reset_form_add_edit();
                    $page = parseInt($('.pagination_item .selected').html());
                    message(1,'Thêm thành công!');
                    // ------------- load lại sản phẩm
                  
                    $('.wrapper_content_right').removeClass('active');
                    $('.form_content_right').hide(10).animate({left:'-100%',opacity: 0},10,function(){
                    });
                     $('.table_content_right').show(10).animate({left:0,opacity: 1},10,function(){
                    });
                     setTimeout(function(){// wait for 5 secs(2)
                           location.reload(); // then reload the page.(3)
                      }, 400); 
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        )
        return false;
    }
    // ---------------EDIT sp---------------
    $('body').on('click','.edit_sanpham',function(){
        $(".form_add_edit p.error").remove();
        SanPhamID = $(this).attr('SanPhamID');
        $.post(base_url + 'sanpham/get_chitiet_sanpham_admin',{"SanPhamID":SanPhamID}).done(function(data){
            kq = JSON.parse(data);
            $('#input_tieude').val(kq['TenSP']);   
            tinyMCE.editors['tinymce4_noidung'].setContent(kq['NoiDung']);  
            tinyMCE.editors['tinymce4_mota'].setContent(kq['MoTa']);
            $('.item_image_ap').remove();
          
            $('#input_masp').val(kq['MaSP']);
            $('#input_giasp').val(kq['GiaVon']);
            $('#input_soluongsp').val(kq['TonKho']);
            $('#input_danhmuc').val(kq['LoaiSPID']);
            $('#fieldID').val(kq['images']);
            $('#thumb_image').attr('src',kq['images']);

            $('.form_add_edit').removeClass('form_add');
            $('.form_add_edit').addClass('form_edit');
            $('.form_add_edit').attr('SanPhamID',kq['SanPhamID']);
            $('.close_add_edit').hide();
            $('html,body').animate({'scrollTop': 0},10);
            if (kq['images'] != "")
            {
                $('.img_append').append('<div class="item_image_ap"><img src="'+kq['images']+'" class="images_appen" /> <input type="hidden" class="images_appen_affter img_append_0" name="image_appendds[]" value="'+kq['images']+'"/><i class="fa fa-times-circle"></i></div>')
                remove_appen();
            }
            if (kq['images1'] != "")
            {
                $('.img_append').append('<div class="item_image_ap"><img src="'+kq['images1']+'" class="images_appen" /> <input type="hidden" class="images_appen_affter img_append_1" name="image_appendds[]" value="'+kq['images1']+'"/><i class="fa fa-times-circle"></i></div>')
                remove_appen();
            }
            if (kq['images2'] != "")
            {
                $('.img_append').append('<div class="item_image_ap"><img src="'+kq['images2']+'" class="images_appen" /> <input type="hidden" class="images_appen_affter img_append_2" name="image_appendds[]" value="'+kq['images2']+'"/><i class="fa fa-times-circle"></i></div>')
                remove_appen();
            }
            if (kq['images3'] != "")
            {
                $('.img_append').append('<div class="item_image_ap"><img src="'+kq['images3']+'" class="images_appen" /> <input type="hidden" class="images_appen_affter img_append_2" name="image_appendds[]" value="'+kq['images3']+'"/><i class="fa fa-times-circle"></i></div>')
                remove_appen();
            }
            if (kq['images4'] != "")
            {
                $('.img_append').append('<div class="item_image_ap"><img src="'+kq['images4']+'" class="images_appen" /> <input type="hidden" class="images_appen_affter img_append_2" name="image_appendds[]" value="'+kq['images4']+'"/><i class="fa fa-times-circle"></i></div>')
                remove_appen();
            }
            load_ajax_out('.form_add_edit');
        })
    })

    function edit_baiviet(){
        $('.ok_add_edit').button('loading');
        TenSP = $('#input_tieude').val();
        NoiDung = tinyMCE.editors['tinymce4_noidung'].getContent(); 
        MoTa = tinyMCE.editors['tinymce4_mota'].getContent(); 
        MaSP =  $('#input_masp').val();
        GiaVon =  $('#input_giasp').val();
        TonKho =  $('#input_soluongsp').val();
        LoaiSPID =  $('#input_danhmuc').val();
        //images = $('#fieldID').val();
        SanPhamID = $(this).attr('SanPhamID');

        images = images1 = images2 = images3 = images4 = "";
        var id_element = $('.images_appen').length;

        if (id_element >= 1) 
        {
            images = $('.img_append_0').val()
        }
        if (id_element >= 2) 
        {
            images1 = $('.img_append_1').val()
        }
        if (id_element >= 3) 
        {
            images2 = $('.img_append_2').val()
        }
        if (id_element >= 4) 
        {
            images3 = $('.img_append_3').val()
        }
        if (id_element >= 5) 
        {
            images4 = $('.img_append_4').val()
        }

        $.post(base_url+'sanpham/edit_sanpham',{
           "SanPhamID":SanPhamID, "TenSP":TenSP,"NoiDung":NoiDung,"MoTa":MoTa,"MaSP": MaSP,"GiaVon":GiaVon, "TonKho":TonKho,"LoaiSPID" : LoaiSPID,"images" : images,"images1" : images1,"images2" : images2,"images3" : images3,"images4" : images4  }).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    $('#input_tieude').focus();
                    reset_form_add_edit();
                    $page = parseInt($('.pagination_item .selected').html());
                    message(1,'Cập nhật thành công!');
                     $('.wrapper_content_right').removeClass('active');
                    $('.form_content_right').hide(10).animate({left:'-100%',opacity: 0},10,function(){
                    });
                     $('.table_content_right').show(10).animate({left:0,opacity: 1},10,function(){
                    });
                    reset_pagination_all_sp_admin();   
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        )
        return false;
    } 

    function validate_tinymce(){

        NoiDung = tinyMCE.editors['tinymce4_noidung'].getContent(); 
        MoTa = tinyMCE.editors['tinymce4_mota'].getContent();  

        result = 1;
        $(".form_add_edit p.error").remove();
        /*if($('#input_masp').val() == ''){
            $('<p class="error">Nhập mã sản phẩm.</p>').insertAfter('#input_masp');
            result = 0;
        }
        else{
            $('#input_masp').next('.error').remove();
        }

        if($('#input_giasp').val() == ''){
            $('<p class="error">Nhập giá sản phẩm.</p>').insertAfter('#input_giasp');
            result = 0;
        }
        else{
            $('#input_giasp').next('.error').remove();
        }
*/
        if(strip_tags(MoTa) == ''){
            $('<p class="error">Nhập mô tả bài viết.</p>').insertAfter('#tinymce4_mota');
            result = 0;
        }else{
            $('#tinymce4_mota').next('.error').remove();
        }
        if(strip_tags(NoiDung) == ''){
            $('<p class="error">Nhập nội dung bài viết.</p>').insertAfter('#tinymce4_noidung');
            result = 0;
        }else{
            $('#tinymce4_noidung').next('.error').remove();
        }  
        /*if($('#input_file').val() == ''){
            $('<p class="error">Chọn file sản phẩm.</p>').insertAfter('#input_file');
            result = 0;
        }
        else{
            $('#input_file').next('.error').remove();
        }*/
        if($('#input_tieude').val().trim() == ''){
            result = 0;
            $('html,body').animate({'scrollTop':$('#input_tieude').parent().offset().top - 50},1);
        }else if(strip_tags(MoTa) == ''){
            tinyMCE.editors['tinymce4_mota'].focus()
            $('html,body').animate({'scrollTop':$('#tinymce4_mota').parent().offset().top - 50},1);
        }else if(strip_tags(NoiDung) == ''){
            tinyMCE.editors['tinymce4_noidung'].focus()
            $('html,body').animate({'scrollTop':$('#tinymce4_noidung').parent().offset().top - 50},1);
        }

        return result;
    }

    $(".form_add_edit").submit(function(){
        validate_tinymce();
    })

    validator = $(".form_add_edit").validate({
        submitHandler: function(form) {
            if(validate_tinymce()){
                if($(".form_add_edit").hasClass('form_add'))
                {
                    add_baiviet(); 

                    return false;        
                }
                else if($(".form_add_edit").hasClass('form_edit'))
                    edit_baiviet();
            }
        }
    });  
    $('.iframe-btn').fancybox({    
        'type'      : 'iframe', 
        fitToView: false,
        autoSize: false,
        autoDimensions: false,
        width: '95%',
        height: '95%',  
    }); 

    $('.close_thumb_image').click(function(e){
        e.stopPropagation();
        $('#thumb_image').attr('src',dataadmin_url + 'img/notFound.png');
        $('#fieldID').val('');
        return false;
    })    
    $('body').on('click','.fancybox',function(){
        return false;
    })
    $('#fieldID').keyup(function(){
        $('#thumb_image').attr('src',$('#fieldID').val());  
    })

    $('body').on('click','.fancybox_image',function(e){
        e.stopPropagation();
        url = $(this).attr('src'); 
        $('<a class="fancybox" href="' + url + '"/>').fancybox({ 
            type:'image',
            'transitionIn'  :   'elastic',
            'transitionOut' :   'elastic',
            height: '95%',  
        }).click();
        return false;
    }) 
    $('body').on('click','.ok_del_sanpham',function(){
        $btn = $(this).button('loading');
        SanPhamID = $(this).attr('sanphamid');
        $.post(base_url+'sanpham/delete_sanpham',{"SanPhamID":SanPhamID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    message(1,'Xóa thành công!');
                    if( trim($('#input_search').val()) == '' )
                        reset_pagination_all_sp_admin(); 

                    else
                        reset_pagination_all_sp_admin();
                }else{
                    message(2,'Xóa không thành công!');
                   
                }
            });
    })
})