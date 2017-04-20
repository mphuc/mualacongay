function imgError(image) {
    image.onerror = "";
    image.src = dataadmin_url + 'img/notFound.png';
    return true;
}
function format_price(nStr){
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}  

// -----mCustomScrollbar-------
$("#list_tintuc_noibat").mCustomScrollbar({
    theme:"light-3", 
    advanced: {autoScrollOnFocus: false},
    scrollButtons:{ enable:true },
    scrollbarPosition:'inside',  
    scrollInertia: 100,   
});     
// -----mCustomScrollbar------- 

function notice($type,$s){
    $(".notice").stop().fadeIn(10);
    $('.notice').html($s).attr('class','flash animated notice '+$type).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass('flash animated');
    });;
    // $(".notice").fadeOut(8000);
}

// --------------------SCROLL ANIMATE----------------------------
function onScrollInit( items, trigger ) {
  items.each( function() {
    var osElement = $(this),
        osAnimationClass = osElement.attr('data-os-animation'),
        osAnimationDelay = osElement.attr('data-os-animation-delay');
      
        osElement.css({
          '-webkit-animation-delay':  osAnimationDelay,
          '-moz-animation-delay':     osAnimationDelay,
          'animation-delay':          osAnimationDelay
        });

        var osTrigger = ( trigger ) ? trigger : osElement;
        
        osTrigger.waypoint(function() {
          osElement.addClass('animated').addClass(osAnimationClass);
          },{
              triggerOnce: true,
              offset: '90%'
        });
  });
}

onScrollInit( $('.os-animation') ); 

$(document).ready(function(){     
    $(window).resize(function(){
        resize()
    })
    function resize(){
        var w = document.documentElement.clientWidth; 
        // $('.connect').html(w);
        // $('.disconnect').html(w);
        if(w > 820){
            $('#nav_main').removeClass('fadeOutDown animated').show();

            // ----------------------slide sản phẩm aside--------------------
            $(".main_slide_right").carouFredSel({
                circular: true,
                infinite: true,
                responsive: true,
                auto    : true,
                scroll  : {
                    fx      : "slide",
                    items   : 1,
                },
                prev        : ".nav_slide_right .prev",
                next        : ".nav_slide_right .next",
                swipe: {
                    onMouse: true,
                    onTouch: true
                },
                items: {
                    height: "variable",
                }
            });

             $(".main_slide_right").hover(
                function() {
                    $('.main_slide_right').trigger("stop");
                }, 
                function() {
                    $(".main_slide_right").trigger("play",true);
                }
            );
             $('.wrapper_slide_right').height($('.caroufredsel_wrapper').height());
            // ----------------------slide sản phẩm aside--------------------

        }  
    }
    resize();
    // ------------------toggle_nav----------------------
    $('.toggle_nav').click(function(e){
        e.stopPropagation();
        if($('#nav_main').hasClass('fadeInUp')){
            $('#nav_main').stop().removeClass('fadeInUp').addClass('fadeOutDown animated').fadeOut('100');
        }else{
            $('#nav_main').stop().removeClass('fadeOutDown').addClass('fadeInUp animated').fadeIn('100');
        }
    })
    $('body').on('click',function() {
        var w = document.documentElement.clientWidth; 
        if( w < 820 ){
            $('#nav_main').stop().removeClass('fadeInUp').addClass('fadeOutDown animated').fadeOut('100');
        }
    });

    //-----------------hover tên member----------------------
    $('.ten_member').hover(
       function () {
            $(this).find('.nav_member_top').stop().removeClass('fadeOutDown').addClass('fadeInUp animated').fadeIn('100').show();
       }, 
       function () {
            $(this).find('.nav_member_top').stop().removeClass('fadeInUp').addClass('fadeOutDown animated').fadeOut('100');
       }
    );
    $('.nav_member_top').hover(function(e){
        // e.stopPropagation();
    })

    // ----------------------popstate-------------------
    $(window).on('popstate', function () {
        location.reload();
    });   

    // -----LOADING-----  
    $(window).on('load',function(){
        $(".load_main ").hide();
    });
    window.onbeforeunload = function(){
        $(".load_main ").show();
    };   

    // ***********************************  CART ********************************************* 
	
    $('body').on('click','.sub_quantity',function(){
        $value_quantity = $(this).parents('.block_quantity').find('.value_quantity');
        if($value_quantity.val() > 1 )
            $value_quantity.val(parseInt($value_quantity.val()) - 1);
    })    
    $('body').on('click','.add_quantity',function(){
        $value_quantity = $(this).parents('.block_quantity').find('.value_quantity');
        $value_quantity.val(parseInt($value_quantity.val()) + 1);
    })


    $('body').on('click','.add_cart',function(){
        $btn = $(this).button('loading');
        $SanPhamID = $(this).attr('SanPhamID'); 
        $SoLuong = 1;
        $.post(base_url+'cart/add_cart',{"SanPhamID":$SanPhamID,"SoLuong":$SoLuong}).done(
        function(data){ 
            $(".block-minicart > a:hover").css({'color': '#ffffff','background-color': '#27aba6'});
            $btn.button('reset');
            if(!isNaN(data)){
                $('.count_cart').html(data);

            }
        });    

        $fly = $(this).parents('.item').find('.ProductImage');
        $img = $fly.attr('image');
        $fly.animate_from_to('.shopping_cart img', {
            initial_css: {
                "opacity": 0.6, 
                "image": $img,
                "background": "none",
            },
            callback: function(){ 
                $('.shopping_cart_inner').addClass('swing animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                    $(this).removeClass('swing animated');
                });
                // count_cart();
            }
        }); 

    }) 
    $('body').on('click','.add_cart2',function(){
        $btn = $(this).button('loading');
        $SanPhamID = $(this).attr('SanPhamID');
        $SoLuong = $('.order_chitiet_sanpham .value_quantity').val();
        $SoLuong = isNaN($SoLuong) ? 1:$SoLuong;
        $.post(base_url+'cart/add_cart',{"SanPhamID":$SanPhamID,"SoLuong":$SoLuong}).done(
        function(data){ 
            $btn.button('reset');
            if(!isNaN(data)){
                $('.count_cart').html(data);
            }
        });   
 
        $img = $(".fotorama__stage .fotorama__active .fotorama__img").attr('src');
        $(".fotorama__stage .fotorama__active .fotorama__img").animate_from_to('.shopping_cart img', {
            initial_css: {
                "opacity": 0.6,
                "image": $img,
                "background": "none",
            },
            callback: function(){ 
                $('.shopping_cart_inner').addClass('swing animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                    $(this).removeClass('swing animated');
                });
                // count_cart();
            }
        }); 
    })

    function update_cart(){
        $arr = $('.thanhtien');
        $total_cart = 0;
        $.each($arr,function(i){
            $total_cart = $total_cart + parseInt($($arr[i]).html().replace(/[.]/g,''));
        })
        $('.total_cart').html(format_price($total_cart));
    }
 
    $('body').on('click','.cart_table .add_quantity, .cart_table .sub_quantity',function(){ 
        $value_quantity = $(this).parents('.item').find('.value_quantity'); 
        $SanPhamID = $(this).parents('.item').attr('SanPhamID');
        $SoLuong = parseInt($value_quantity.val().replace(/[.]/g,''));
        load_ajax_in('.cart_table tbody');

        $.post(base_url+'cart/update_cart',{"SanPhamID":$SanPhamID,"SoLuong":$SoLuong}).done(
        function(data){ 
            $('.cart_table').html(data);
            update_cart();
            count_cart();
        });    
    })

    $('body').on('click','.remove_cart',function(){
        $(this).parents('.item').remove();
        $SanPhamID = $(this).parents('.item').attr('SanPhamID');
        load_ajax_in('.cart_table tbody');
        $.post(base_url+'cart/remove_cart',{"SanPhamID":$SanPhamID}).done(
        function(data){ 
            update_cart();
            count_cart();
            load_ajax_out('.cart_table tbody');
        });   
    })

    function count_cart(){
        $.post(base_url+'cart/count_cart',{}).done(
        function(data){ 
            $('.count_cart').html(data);
            if(data==0){
                $('.alert_cart').html('<p class="noitems">Giỏ hàng trống!</p>');
                $('.right_cart').remove();
                $('.cart_table').html('');
            }
        });  
    }

    $(window).scroll(function(){
        var $top=$(window).scrollTop();
        if($top > 80){
            $('.shopping_cart').addClass('fix_cart').fadeIn(200);
            $('.back_top').fadeIn(200);
        }else {
            $('.shopping_cart').css('opacity',1).removeClass('fix_cart');
            $('.back_top').fadeOut(200);
        } ;
    });

    $('.back_top').click(function(){
        $('html,body').animate({'scrollTop': 0},200);
    })

    // ====================search=======================
    function trim(str) { 
        var start = 0; var end = str.length; 
        while (start < str.length && str.charAt(start) == ' ') 
            start++; 
        while (end > 0 && str.charAt(end-1) == ' ') 
            end--; 
        return str.substr(start, end-start); 
    }

    $('body').click(function(e){
        $('.result_wrapper').stop().removeClass('fadeInUp').addClass('fadeOutDown animated').fadeOut('100');
    })

    $('.search_input,.result_wrapper').click(function(e){
        if(trim($('.result_wrapper').html()) != ''){
            $('.result_wrapper').stop().removeClass('fadeOutDown').addClass('fadeInUp animated').fadeIn('100').show();
            e.stopPropagation();
        }
    })   

    $('#SearchForm').submit(function(e){
        e.preventDefault();
        search_main();
    })

    $('.search_input').keyup(function(){
        search_main();
    }) 

    function search_main(){
       key = trim($('.search_input').val());
        if(key.length >= 2){
            $('.result_wrapper').stop().removeClass('fadeOutDown').addClass('fadeInUp animated').fadeIn('100').show();
            $('.result_wrapper').html('<div class="load_search">' + $('.wrapper_load_window_phone').html() + '</div>');
            $.post(base_url+'sanpham/search_main',{"key":key}).done(
            function(data){ 
                if(data == ''){
                    $('.result_wrapper').html('<span class="no_result">Không có kết quả tìm kiếm!</span>');
                }else{
                    $('.result_wrapper').html(data);
                }
            });  
        }else{
            $('.result_wrapper').stop().removeClass('fadeInUp').addClass('fadeOutDown animated').fadeOut('100');
        } 
    }

    $('#form_search').submit(function(){
        search_main();
        return false;
    })
 
    $('body').keydown(function(e) {
        if($('.result_wrapper a').is(":focus") || $('.search_input').is(":focus")){
            var charCode = (e.which) ? e.which : event.keyCode
            if(charCode == 40 || charCode == 38) {
                if(charCode == 40){ 
                    if($('.search_input').is(":focus")){
                        $('.result_wrapper a:first').focus();
                    }else{
                        next = $('.result_wrapper a:focus').next();
                        if(next.prop("tagName") == 'A'){
                            next.focus();
                        }else{
                            next.next().focus();
                        }
                    }
                }else if(charCode == 38){ 
                    if($('.result_wrapper a:first').is(":focus")){
                        $('.search_input').focus();
                    }else{
                        prev = $('.result_wrapper a:focus').prev();
                        if(prev.prop("tagName") == 'A'){
                            prev.focus();
                        }else{
                            prev.prev().focus();
                        }
                    }
                }

                e.preventDefault();
                return false;
            }
            return true;
        }
    });
 
// -------------------------c---------------------
    
    $(window).resize(function(){
        setTimeout(function(){
            $('.ProductList .product_title').dotdotdot();
        },1000)
    })
    $('.ProductList .product_title').dotdotdot();

}); 