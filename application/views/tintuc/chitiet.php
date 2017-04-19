<div class="col-lg-9 col-sm-8 right_content" style="margin-top: 16px;">
    <div class="row">
        <div class="product-container">
    <div class="bg_right_content">
        <h2 class="title_tintuc"><?=$chitiet_tintuc['TieuDe'];?></h2>
        <div>
            <span class="ngay_tintuc">
                <i class="fa fa-calendar-o"> </i> 
            <?php 
                $Ngay = date(" d/m/Y", strtotime($chitiet_tintuc['Ngay']));
                $Gio = date(" H:i", strtotime($chitiet_tintuc['Ngay']));

                $weekday = date("l", strtotime($chitiet_tintuc['Ngay']));

                $weekday = strtolower($weekday);
                switch($weekday) {
                    case 'monday':
                        $weekday = 'Thứ hai';
                        break;
                    case 'tuesday':
                        $weekday = 'Thứ ba';
                        break;
                    case 'wednesday':
                        $weekday = 'Thứ tư';
                        break;
                    case 'thursday':
                        $weekday = 'Thứ năm';
                        break;
                    case 'friday':
                        $weekday = 'Thứ sáu';
                        break;
                    case 'saturday':
                        $weekday = 'Thứ bảy';
                        break;
                    default:
                        $weekday = 'Chủ nhật';
                        break;
                }
                echo $weekday.' '.$Ngay.' <span class="gio_tintuc fa fa-clock-o"><span>'.$Gio.'</span></span>';

                ?>
            </span>
            <div class="fb-like like_tintuc" data-href="<?=base_url()?>tin-tuc/<?=$chitiet_tintuc['TinTucID']?>" data-layout="button_count" data-action="like" data-show-faces="true" ></div>
        </div>
        <div class="content_tintuc">
            <ul class="more_tintuc_top">
                <li><a href=""></a></li>
            </ul>
            <div><?=$chitiet_tintuc['NoiDung'];?></div>

        </div> 
    </div> 
    <ul class="more_tintuc_bottom">
        <h2>Xem thêm các chủ đề khác:</h2>
        <?php foreach ($more_tintuc as $item) { ?>
            <li>
                <a href="<?=base_url()?>tin-tuc/<?=url_title(removesign($item['TieuDe']))?>_<?=$item['TinTucID']?>">
                    <i class="fa fa-hand-o-right"></i>
                    <span class="title_more"><?=$item['TieuDe']?></span>
                    <span class="ngay_more"><?=date("d/m/Y", strtotime($item['Ngay']));?></span>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
</div>
</div>