//    ------------message----------
function message(type,s){
    if(!$('.wapper_message').length)
        $('body').append('<div class="wapper_message"></div>')
    var d=new Date();
    var m=d.getSeconds();
    if(type == 1){
        $('.wapper_message').append('<div class="bg_green message id'+m+'"><span class="fa fa-check"></span> '+s+'</div>') ;
    }else if(type == 2){
        $('.wapper_message').append('<div class="bg_red message id'+m+'"><span class="fa fa-times"></span> '+s+'</div>') ;
    }else if(type == 3){
        $('.wapper_message').append('<div class="bg_yellow message id'+m+'"><span class="fa fa-warning"></span> '+s+'</div>') ;
    }
    $('.id'+m).animate({opacity:0},8000,function(){
        $('.id'+m).remove();
    })
}
$('body').on('click','.message',function(){
    $(this).remove();
});
$('body').on('mouseover','.message',function(){
    $(this).stop().css('opacity','1');
});
$('body').on('mouseout','.message',function(){
    $(this).animate({opacity:0},5000,function(){
        $(this).remove();
    });
})

// ----------loading ajax-------------------
function load_ajax_in($element){
    $($element).append('<div class="wrapper_load_ajax_window_phone">' + $('.wrapper_load_window_phone').html() + '</div>');
}
function load_ajax_out($element){
    $($element + ' .wrapper_load_ajax_window_phone').remove();
}
// ----------loading ajax-------------------  

// --------notice----------------

function notice($type,$s){
    $(".notice").stop().fadeIn(10);
    $('.notice').html($s).attr('class','flash animated notice '+$type).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass('flash animated');
    });
}