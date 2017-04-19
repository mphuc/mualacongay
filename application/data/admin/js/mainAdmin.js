
function trim(str) { 
    var start = 0; var end = str.length; 
    while (start < str.length && str.charAt(start) == ' ') 
        start++; 
    while (end > 0 && str.charAt(end-1) == ' ') 
        end--; 
    return str.substr(start, end-start); 
}
function strip_tags(str){
    return str.replace(/(<([^>]+)>)/ig,"").replace(/&nbsp;/gi,'').replace(/ /gi,'');
}
// -----------thay the hinh anh mac dinh khi khong tim thay file--- 
function imgError(image) {
    image.onerror = "";
    image.src = dataadmin_url + 'img/notFound.png';
    return true;
}

function load_get_data(){
    $('.table_item tbody').html('<tr><td colspan=20 class="text_center">'+ $('.wrapper_load_window_phone').html() +'</td></tr>');  
}
// ---------------toggle_form_add_edit----------------
function toggle_form_add_edit(){
    if($('.wrapper_content_right').hasClass('active')){
        load_ajax_out('.form_add_edit');
        $('.wrapper_content_right').removeClass('active');
        $('.form_content_right').hide(10).animate({left:'-100%',opacity: 0},10,function(){
        });
        $('.table_content_right').show(10).animate({left:0,opacity: 1},10,function(){
        }); 
    }else{ 
        //load_ajax_in('.form_add_edit');
        $('.wrapper_content_right').addClass('active');
        $('.form_content_right').show(10).animate({left:0,opacity: 1},10,function(){
        });
        $('.table_content_right').hide(10).animate({left:'-100%',opacity: 0},10,function(){
        });  
    }
}  

$(document).ready(function(){   
   // -------------------sidebar----------------
    function fix_width(){
        var h = document.documentElement.clientHeight;
        var w = document.documentElement.clientWidth; 
        $('.content_left').width(w_sidebar); 
        if( $('.content_left').width() == 220 && w < 800 ){ 
            $('.content_left').width(45);
        }
        var w_left = $('.content_left').width();
        var h_header = $('header').height();
        $('.scroll_content_left').height(h-h_header); 
        $('.content_right').css('margin-left',w_left).css('margin-top',$('header').height());               
        $('.content_left').css('top',$('header').height());                  
    }

    fix_width();
    $(window).resize(function(){
        fix_width();
    }); 

    $('body').on('click','.sidebar_toggle',function(){
        var p = $('.content_left');

        if(p.width() == 220){
            w_sidebar = 45;
        }else if(p.width() == 45){
            w_sidebar = 3;
        }else if(p.width() == 3){
            w_sidebar = 220;
        }  

        p.width(w_sidebar);
        $.post(base_url + 'admin/w_sidebar',{"w_sidebar":w_sidebar}).done(
            function(data){
            // alert(data)
            }); 
        fix_width();
    })

    $('.content_left').hover(function(){
        $('.content_left').addClass('max_content_left');
    },function(){
        $('.content_left').removeClass('max_content_left');
    })

    // -----LOADING-----
    function init() { 
        $(window).on('load',function(){
            fadeInContent();

            $.post(base_url+'admin/status_system',{}).done(
            function(data){  
                result = JSON.parse(data);
                if(result.connect_server_ftp == 1){
                    $('.connect_server_ftp').addClass('green');
                }else{
                    $('.connect_server_ftp').addClass('red');
                }

                
                    // $('.connect_server').addClass('green');
                    // $('#update_thongtin').fadeIn(200);
                    // $('#dongbo_dulieu').fadeIn(200);
                    // $('#capnhat_all').fadeIn(200);
                    // $('#block_capnhat_gia_sanpham').fadeIn(200);
                
            });  
            
        });
        window.onbeforeunload = fadeOutContent; 
    }
    function fadeInContent() {
        $('html').removeClass('loading'); 
        return;
    }
    function fadeOutContent() { 
        $('html').addClass('loading');
    }   
    init(); 
    // -----LOADING-----

    // -----------------includeJs--------------
    pathname=window.location.pathname;
    path = pathname.split('/'); 
    function includeJs(page) {  
        var url = dataadmin_url + "js/libJS/"+ page +".js";  
        var js= '<script type="text/javascript" src="'+ url +'" class="history '+ page +'"></script>'; 
        $('body').append(js);
    }
    if(window.location.hostname == 'localhost'){
        includeJs(path[3]);
    }else{
        includeJs(path[2]);
    }
 
    //-------------------tinyMCE kcfinder--------------------
 
    tinymce.init({
        selector: "textarea#tinymce4_noidung",
        theme: "modern", 
        // skin:"custom",
        language :"vi_VN",
        height: '600px', 

        plugins: [ 
            "youTube advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],    
        toolbar1: "newdocument undo redo | styleselect fontselect fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | pastetext removeformat | bullist numlist outdent indent | image media youTube insertfile | link unlink anchor | print preview fullpage | forecolor backcolor emoticons table | code | blockquote | charmap | fullscreen",

        file_browser_callback: function(field, url, type, win) {
            tinyMCE.activeEditor.windowManager.open({
                file: base_url + 'kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                title: 'Duyệt file',
                width: 1000,
                height: 550,
                inline: true,
                close_previous: false
            }, {
                window: win,
                input: field
            });
            return false;
        }, 
        relative_urls:false,
        remove_script_host:false, 
        menubar  :false,
        save_enablewhendirty: true,
        save_onsavecallback: function() {console.log("Save");}, 
    })   

    tinymce.init({
        selector: "textarea#tinymce4_mota",
        theme: "modern",   
        language :"vi_VN",
        height: '100px', 
        plugins: [
            "youTube advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],      
        toolbar1: "undo redo | bold italic underline | pastetext removeformat | link unlink anchor | print preview fullscreen ",
        statusbar: false,
        menubar  :false,
        save_enablewhendirty: true,   
    })  

    tinymce.init({
        selector: "textarea#message",
        theme: "modern",  
        language :"vi_VN",
        height: '250px', 
        plugins: [
            "paste link print fullscreen",
        ],      
        toolbar1: "bold italic underline | pastetext removeformat | link unlink anchor | print fullscreen ",
        statusbar: false,
        menubar  :false,
        save_enablewhendirty: true,   
    })  
 
    // -----------------hien <ul> cua sub_menu_admin-------------- 
    $('.menu_active_sidebar_left').parent().show();
    $('.menu_active_sidebar_left').parent('.group_menu_admin').parent().find('.item_menu_admin').addClass('active_group_menu_admin');

    $('[data-toggle="tooltip"]').tooltip();
    // $('[data-toggle="tooltip"]').tooltip('show');
    // $time_tooltip = setTimeout(function(){
    //     $('[data-toggle="tooltip"]').tooltip('hide');
    // },6000)

 
// -----mCustomScrollbar-------
    $(".scroll_aside").mCustomScrollbar({
        theme:"light-thin",
        autoHideScrollbar:true,
        advanced: {autoScrollOnFocus: false},
        scrollButtons:{ enable:true },
        scrollbarPosition:'inside',  
        scrollInertia: 100,   
    });     
// -----mCustomScrollbar------- 

    $('.item_menu_admin').click(function(){
        $menu = $(this).parents('li').find('ul');
        if($menu.css('display') == 'block'){
            $menu.slideUp(250);
            $(this).find('.more_icon').removeClass('fa-angle-down').addClass('fa-angle-right');
        }else{
            $('.item_menu_admin .more_icon').removeClass('fa-angle-down').addClass('fa-angle-right');
            $('.sidebar_admin ul').slideUp(250);
            $(this).find('.more_icon').removeClass('fa-angle-right').addClass('fa-angle-down');
            $menu.slideToggle(250);
        }
    })

    // -------------------------dropdown_togle---------------
    $('body').on('click','.dropdown_togle',function(e){
        $(this).focus();
        var t = $(this).parent().find('.dropdown_menu');
        if(t.hasClass('open')){
            t.hide().removeClass('open');
        }else{
            $('.dropdown_menu').hide().removeClass('open');
            t.show().addClass('open');

            s = t.offset().left;
            w = document.documentElement.clientWidth;
            p = t.width();
            h_header = $('header').height()+4;
            if( s <= 0 ){
                t.offset({ top: h_header, left: 0 });
            }else{
                t.css({'left':'auto'});
            }
            h_dropdown_togle = $(this).outerHeight();
            t.css({'top':h_dropdown_togle+7}); 
        }
        e.stopPropagation();
    })
    $('body').on('click','.dropdown_menu',function(e){
        e.stopPropagation();
    })      
    $('body').on('click','.dropdown_close',function(){
        $('.dropdown_menu').hide().removeClass('open');
    })
    $('body').click(function(e){
        $('.dropdown_menu').hide().removeClass('open');
        $('.popup_form').hide();
        $('.btn_thumb_image').removeClass('active');
    })

    //-------------------------toggle_form_add_edit---------------------
    $('body').on('click','.toggle_form_add_edit',function(){
        toggle_form_add_edit();
    })

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

//------------------------checkbox-----------------------
    //-----đếm số lượng item được check----------
    function count_check_item(){
        $count_check  = [];
        $arr = $('.table_content_right tbody .checkbox_item');
        $.each($arr,function(i){
            if($(this).is(':checked')){ 
                $count_check.push(1); 
            }
        })
        return $count_check;
    } 
    // ------------checkbox từng item---------
    $('body').on('change','.table_content_right tbody .checkbox_item',function(){
        if( $(this).is(':checked') ){
            $(this).parents('tr').addClass('bg_check');
            $('.btn_del_more').removeClass('disabled');
        }else{
            $(this).parents('tr').removeClass('bg_check');
        }
        $count = count_check_item();
        if($count == ''){
            $('.btn_del_more').addClass('disabled');
        }else{
            $('.btn_del_more').removeClass('disabled');  
        }
        $arr = $('.table_content_right tbody .checkbox_item');  
        if( $count.length != $arr.length )
            $('.table_content_right #checkbox_all').attr('checked',false);
    }) 
    // ------------checkbox tất cả item---------
    $('body').on('click','.table_content_right #checkbox_all',function(e){ 
        if( $(this).is(':checked') ){
            $('.table_item tbody tr').addClass('bg_check');
            $arr = $('.table_content_right tbody .checkbox_item');
            $('.btn_del_more').removeClass('disabled'); 
            $.each($arr,function(i){
                $arr[i].checked = true;
            })
        }else{
            $('.table_item tbody tr').removeClass('bg_check');
            $arr = $('.table_content_right tbody .checkbox_item');
            $('.btn_del_more').addClass('disabled');
            $.each($arr,function(i){
                $arr[i].checked = false;
            })
        }
    })   

    // --------------popup_form_search---------------
    $('.show_popup_form').focus(function(){
        $('.popup_form').hide();
        $(this).parent().find('.popup_form').show();
    })
    $('.show_popup_form').click(function(e){
        e.stopPropagation();
        $('.popup_form').hide();
        $(this).parent().find('.popup_form').show();
    })
    $('.popup_form').click(function(e){
        e.stopPropagation(); 
    }) 
    // --------------popup_form_search--------------- 

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

    $('.fancybox').fancybox({ 
        type:'ajax',
        maxWidth    : '70%',
        maxHeight   : '95%',
        fitToView   : false,
        height: '95%',  
        width : '70%',
        helpers : { 
            title: null,
        },
    });  
 
    $('.fancybox_element').fancybox({  
        openEffect  : 'none',
        closeEffect : 'none',
        height: '95%', 
        helpers : { 
            overlay : {closeClick: false},
            title: null,
        },
        closeBtn    :false,
        beforeShow: function() { 
        },
        keys : { 
            close  : null
        }
    });   

    $('body').on('click','.close_fancybox',function(){
        $.fancybox.close();
    })

    // ================================== change_password ===========================
    $('.fancybox_change_pass').click(function(e){
        e.stopPropagation();
        $('#form_change input').val(''); 
        $('#form_change label.error').remove();
        $('#form_change .notice').hide();
        url = $(this).attr('href'); 
        $('<a class="fancybox" href="' + url + '"/>').fancybox({ 
            'transitionIn'  :   'elastic',
            'transitionOut' :   'elastic',
            height: '95%', 
            beforeShow: function() { 
            }
        }).click();
        return false;
    })   

     $("#form_change").validate({
        submitHandler: function(form) { 
            change();
        }
    });      

    function change(){    
        var $btn = $('#submit_change').button('loading');
        $.post(base_url+'user/change_password',$("#form_change").serialize()).done(
        function(data){ 
            $btn.button('reset');
            if(data == -1){
                notice('red','<i class="fa fa-check"></i> Mật khẩu cũ không đúng!');
            }else if(data == 1){
                $.fancybox.close();
                message(1,'Cập nhật thành công!');
            }else{
                notice('red','<i class="fa fa-warning"></i> Cập nhật lỗi!');
            }
        });  
    } 


    $(window).on('popstate', function () { 
        location.reload();
    });

 })
