<aside class="wrapper_content_right">  
    <h1 class="title_admin_right bg_title"><span class="fa fa-bar-chart"></span> Thống kê doanh thu</h1>
    <div class="table_content_right"> 
        <div class="inner_table_content_right">  

        <div class="content_chart">
            <div id="chartdiv"></div>
            <p class="no_data">Không có dữ liệu thống kê!</p>
        </div>

        <div class="select_thongke">
            <label>Năm: </label>
            <select id="nam_thongke" class="selectized">
                <?php for ($i=2020; $i >= 2010 ; $i--) { 
                    echo ('<option value="'.$i.'">'.$i.'</option>');
                }?>
            </select>
            <button id="btn_thongke" class="btn btn-info">Thống kê <i class="fa fa-random"> </i></button>
        </div>   

        </div><!-- inner_table_content_right -->
    </div><!-- table_content_right-->  
</aside> 

<script src="<?=dataadmin_url?>js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?=dataadmin_url?>js/amcharts/serial.js" type="text/javascript"></script>
<script src="<?=dataadmin_url?>js/amcharts/themes/light.js" type="text/javascript"></script>
<script src="<?=dataadmin_url?>js/amcharts/exporting/amexport_combined.js" type="text/javascript"></script>

<script type="text/javascript"> 
$(document).ready(function(){
    now = new Date();
    nam_thongke = now.getFullYear();
    $btn = $('#btn_thongke')
    $('#btn_thongke').click(function(){
        $Nam = $('#nam_thongke').val();
        chart($Nam);
    });

    $Nam = $('#nam_thongke').val(nam_thongke);
    chart(nam_thongke);
    function chart(Nam){
        $btn.button('loading');
        $('.no_data').html($('.wrapper_load_window_phone').html()).show();
        load_get_data();

        $base_url = '<?=base_url();?>';
        $.post($base_url+'hoadononline/thongke_hoadon',({"Nam":Nam})).done(
            function(data){
                $btn.button('reset'); 
                chartData = JSON.parse(data);
                if(chartData == null || chartData == ''){
                    $('.no_data').html('Không có dữ liệu thống kê!').show();
                    $('#chartdiv').html('');
                }else{
                    $('.no_data').hide(); 
                    AmCharts.theme = AmCharts.themes.light;
                    AmCharts.makeChart("chartdiv", {
                        "type": "serial", 
                        "fontFamily": "tahoma",
                        "fontSize": 13,
                        "theme": "patterns",
                        "dataProvider": chartData,
                        "valueAxes": [{
                            "gridColor":"#FFFFFF",
                            "gridAlpha": 0.2,
                            "dashLength": 0
                        }],
                        "gridAboveGraphs": true,
                        "startDuration": 1,
                        "graphs": [{
                            "balloonText": "[[category]]: <b>[[value]]</b>",
                            "fillAlphas": 0.8,
                            "lineAlpha": 0.2,
                            "type": "column",
                            "valueField": "tong",    
                            "labelText": "[[value]]",   //hiện giá trị bên trên cột
                        }],
                        "chartCursor": {
                            "categoryBalloonEnabled": false,
                            "cursorAlpha": 0,
                            "zoomable": false
                        },
                        "categoryField": "thang",
                        "categoryAxis": {
                            "gridPosition": "start",
                            "gridAlpha": 0,
                            "tickPosition":"start",
                            "tickLength":20,
                            "title":'Thống kê hóa đơn bán online năm '+ Nam
                        },
                        "pathToImages":"http://www.amcharts.com/lib/3/images/",
                        "amExport":{
                            "top":21,
                            "right":20,
                            "exportJPG":true,
                            "exportPNG":true, 
                        },
                        "titles": [
                            {
                                "text": "",
                                "size": 15
                            }
                        ]

                    });
                }
        })
    }
});
</script>

