$(document).ready(function(){      
    // ---------------EDIT trang thong tin---------------
    $('body').on('click','.edit_thongtin',function(){
        $(".form_add_edit p.error").remove();
        validator.resetForm();
        Trang = $(this).attr('Trang');
        title = $(this).parents('tr').find('.title_trang').html();
        $('.form_add_edit').attr('Trang',Trang);
        $.post(base_url + 'thongtin/get_chitiet_thongtin_admin',{"Trang":Trang}).done(
            function(data){
                if(Trang == 'GoogleMap' || Trang == 'Fanpage_Like' || Trang == 'Copyright'){
                    $('.tinymce').hide();
                    $('.type_input').show();
                    $('#input_noidung').val(data);
                }else{
                    $('.tinymce').show();
                    $('.type_input').hide();
                    tinyMCE.editors['tinymce4_noidung'].setContent(data);   
                }
                $('.title_trang_edit').html(title);
                $('.close_add_edit').hide();
                $('html,body').animate({'scrollTop': 0},10);
                load_ajax_out('.form_add_edit');
            })
    })

    function edit_thongtin(){
        $('.ok_add_edit').button('loading');  
        Trang = $('.form_add_edit').attr('Trang'); 

        if(Trang == 'GoogleMap' || Trang == 'Fanpage_Like' || Trang == 'Copyright'){
            NoiDung = $('#input_noidung').val();
        }else{
            NoiDung = tinyMCE.editors['tinymce4_noidung'].getContent(); 
        }

        $.post(base_url+'thongtin/edit_thongtin',{
            "Trang":Trang,"NoiDung":NoiDung
        }).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    message(1,'Chỉnh sửa thành công!');
                    // ------------- load lại danh mục
                    toggle_form_add_edit();
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
        result = 1;
        $(".form_add_edit p.error").remove();
 
        if(NoiDung == ''){
            $('<p class="error">Nội dung không được trống.</p>').insertAfter('#tinymce4_noidung');
            result = 0;
            tinyMCE.editors['tinymce4_noidung'].focus();
            $('html,body').animate({'scrollTop':$('#tinymce4_noidung').parent().offset().top - 50},1);
        }else{
            $('#tinymce4_noidung').next('.error').remove();
        } 
        return result;
    }

    $(".form_add_edit").submit(function(){
        validate_tinymce();
    }) 

    validator = $(".form_add_edit").validate({
        submitHandler: function(form) {  
            if(Trang == 'GoogleMap' || Trang == 'Fanpage_Like' || Trang == 'Copyright'){
                edit_thongtin();
            }else if(validate_tinymce()){      
                edit_thongtin();
            }
        }
    });  

})