                </div>  <!-- content_right-->
                <footer>

                </footer>
            </div> <!-- container-->
            <div class="wrapper_load_ajax">
                <div class="load_ajax">        
                    <div class="spinner">
                        <div class="spinner-container container1">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                        <div class="circle4"></div>
                        </div>
                        <div class="spinner-container container2">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                        <div class="circle4"></div>
                        </div>
                        <div class="spinner-container container3">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                        <div class="circle4"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper_popup_main"> 
                <div id="aminate_popup">
                    <div class="popup_main">
                        <div class="header_popup_main">
                            <span class="title_popup_main"><span class="fa fa-bars"></span> Thông tin sản phẩm</span>
                            <span class="btn_close_popup_main close_popup_main fa fa-times"></span>
                        </div>
                        <div class="scroll_popup_main">  
                            <div class="content_popup_main"></div>
                        </div>  
                        <div class="footer_popup_main"></div>
                    </div>
                </div>
            </div> 

            <div class="wrapper_load_window_phone">
                <div class="load_window_phone">
                    <span class="l-1"></span>
                    <span class="l-2"></span>
                    <span class="l-3"></span>
                    <span class="l-4"></span>
                    <span class="l-5"></span>
                    <span class="l-6"></span>
                </div>
            </div>
        
            <script src="<?=dataadmin_url?>js/bootstrap.js" ></script>               
            <script src="<?=dataadmin_url?>js/mcustomscrollbar/jquery.mCustomScrollbar.js" ></script>
            <script src="<?=dataadmin_url?>js/mcustomscrollbar/jquery.mousewheel.min.js" ></script> 
            <script src="<?=dataadmin_url?>js/jPaginator/jPaginator.js" ></script>
            <script src="<?=dataadmin_url?>js/jPaginator/jquery-ui-1.9.1.custom.min.js" ></script> 
            <script src="<?=dataadmin_url?>js/tablesorter/jquery.tablesorter.js" ></script>  
            <script src="<?=dataadmin_url?>js/fancybox/jquery.fancybox.js" ></script>    
            <script src="<?=dataadmin_url?>js/tinymce/tinymce.min.js" ></script>  
            <script src="<?=dataadmin_url?>js/validate/jquery.validate.js" ></script>   
            <script src="<?=dataadmin_url?>js/price_format/jquery.price_format.2.0.js" ></script>   
            <script src="<?=dataadmin_url?>js/ddslick/jquery.ddslick.js" ></script> 
            <script src="<?=dataadmin_url?>js/textarea_autosize/jquery.textarea_autosize.js" ></script>  
                
            <?php //echo base_url(); die; ?>

            <script type="text/javascript">
                var base_url = '<?=base_url();?>';
                var w_sidebar = '<?=$this->session->userdata("w_sidebar");?>';
                var dataadmin_url = base_url + 'application/data/admin/';
                var data_url = base_url + 'application/data/'; 
                var menuActive = '<?=$menuActive?>'; 
                
                // ---------------------kcfinder----------------     
                function openKCFinder() {
                    window.KCFinder = {
                        callBack: function(url) { 
                            $('#thumb_image').attr('src',url);
                            $('#fieldID').val(url);
                            window.KCFinder = null;
                            $.fancybox.close();
                        }
                    }; 
                }    
                $('.add_append_img').click(function() {
                    var id_element = $('.images_appen').length;
                    window.KCFinder = {
                        callBack: function(url) { 
                            if (id_element < 5)
                            {
                                $('.img_append').append('<div class="item_image_ap"><img src="'+url+'" class="images_appen" /> <input type="hidden" class="images_appen_affter img_append_'+id_element+'" name="image_appendds[]" value="'+url+'"/><i class="fa fa-times-circle"></i></div>')
                            }
                            
                            remove_appen();
                            window.KCFinder = null;
                            $.fancybox.close();
                        }
                    };       
                });

                function remove_appen(){
                    $('.item_image_ap i').click(function(){
                        $(this).parent('.item_image_ap').remove();
                    });
                }   
            </script>  
            <script src="<?=dataadmin_url?>js/general.js" ></script>
            <script src="<?=dataadmin_url?>js/mainAdmin.js" ></script> 
        </body>
</html>



