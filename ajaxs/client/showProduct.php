<?php
define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/lang.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {?>

<style>
.ribbon-wrapper.ribbon-lg .ribbon {
    right: 0;
    top: 26px;
    width: 150px;
}

.ribbon-wrapper .ribbon {
    box-shadow: 0 0 3px rgb(0 0 0 / 30%);
    font-size: .8rem;
    line-height: 100%;
    padding: 0.375rem 0;
    position: relative;
    right: -2px;
    text-align: center;
    text-shadow: 0 -1px 0 rgb(0 0 0 / 40%);
    text-transform: uppercase;
    top: 10px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
    width: 90px;
}

.ribbon-wrapper.ribbon-lg {
    height: 120px;
    width: 120px;
}

.ribbon-wrapper {
    height: 70px;
    overflow: hidden;
    position: absolute;
    right: 12px;
    top: -2px;
    width: 70px;
    z-index: 10;
}
</style>
<style>
.ribbon-wrapper.ribbon-lg .ribbon {
    right: 0;
    top: 26px;
    width: 150px;
}

.ribbon-wrapper .ribbon {
    box-shadow: 0 0 3px rgb(0 0 0 / 30%);
    font-size: .8rem;
    line-height: 100%;
    padding: 0.375rem 0;
    position: relative;
    right: -2px;
    text-align: center;
    text-shadow: 0 -1px 0 rgb(0 0 0 / 40%);
    text-transform: uppercase;
    top: 10px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
    width: 90px;
}

.ribbon-wrapper.ribbon-lg {
    height: 120px;
    width: 120px;
}

.ribbon-wrapper {
    height: 70px;
    overflow: hidden;
    position: absolute;
    right: 12px;
    top: -2px;
    width: 70px;
    z-index: 10;
}
</style>
<style>
.thumbnail-mobile {
    width: 32px;
    height: 24px;
    overflow: hidden;
    border: 1px solid #e5e5e5;
}

.thumbnail-mobile img {
    width: 100%;
    height: 100%;
    transition-duration: 0.1s;
}

.thumbnail-mobile img:hover {
    position: absolute;
    width: 350px;
    height: 210px;
    right: -20px;
    border: 3px solid #00ac15;
    border-radius: 9px;
    z-index: 1000;
}
</style>

<div class="row">
<?php
    if ($_POST['id'] == 0) {
        $listProduct = $CMSNT->get_list("SELECT * FROM `products` WHERE `status` = 1 ORDER BY `stt` ASC ");
    } else {
        $listProduct = $CMSNT->get_list("SELECT * FROM `products` WHERE `category_id` = '".check_string($_POST['id'])."' AND `status` = 1 ORDER BY `stt` ASC  ");
    }
    if ($listProduct) {  
?>





<?php // LIST ?>
<?php if($CMSNT->site('type_showProduct') == 2):?>
    <div class="col-sm-12 col-md-12 col-lg-12 mt-12 mt-md-3 p-0 ">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-color-heading" style="background:<?=$CMSNT->site('theme_color');?>;color:white;">
                    <tr>
                        <th><?=__('Sản phẩm');?></th>
                        <?php if($CMSNT->site('display_country') == 1):?>
                        <th class="text-center d-none-600" width="10%"><?=__('Quốc gia');?></th>
                        <?php endif?>
                        <?php if($CMSNT->site('display_preview') == 1):?>
                        <th class="text-center d-none-1100" width="10%"><?=__('Xem trước');?></th>
                        <?php endif?>
                        <th class="text-center d-none-600" width="10%"><?=__('Hiện có');?></th>
                        <?php if ($CMSNT->site('display_sold') == 1):?>
                        <th class="text-center d-none-600" width="10%"><?=__('Đã bán');?></th>    
                        <?php endif?>
                        <th class="text-center d-none-600" width="10%"><?=__('Giá');?></th>
                        <th class="text-center d-none-600" width="10%"><?=__('Thao tác');?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($listProduct as $product) {?>
                    <?php
                    $conlai = $product['id_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
                    if($CMSNT->site('hide_product_empty') == 1){
                        if($conlai == 0){
                            continue;
                        }
                    }?>

                    <tr>
                        <td>
                            <div class="col-product-name">
                                <img class="mr-1 py-1 d-none-600"
                                    src="<?=base_url(getRowRealtime("categories", $product['category_id'], 'image'));?>">
                                <div class="name-product">
                                    <h3><?=__($product['name']);?></h3>
                                    <div class="content-mota">
                                        <?=__($product['content']);?>
                                    </div>
                                    <div class="d-none-more-than-601">
                                        <div class="col-md-12 p-0 mt-2">
                                            <span class="btn mb-1 btn-sm btn-outline-danger">
                                                <i class="far fa-money-bill-alt mr-1"></i>
                                                <b><?=format_currency($product['price']);?></b>
                                            </span>
                                            <span class="btn mb-1 btn-sm btn-outline-info">
                                                <?=__('Còn lại:');?>
                                                <b><?=format_cash($conlai);?></b>
                                            </span>
                                            <?php if ($CMSNT->site('display_sold') == 1):?>
                                            <span class="btn mb-1 btn-sm btn-outline-info">
                                                <?=__('Đã bán:');?>
                                                <b><?=format_cash($product['sold']);?></b>
                                            </span>   
                                            <?php endif?>
                                            <?php if($CMSNT->site('display_country') == 1):?>
                                            <span class="btn mb-1 btn-sm btn-outline-warning p-0">
                                                <?=getFlag($product['flag']);?>
                                            </span>
                                            <?php endif?>
                                            <?php if($CMSNT->site('display_preview') == 1 && $product['preview'] != ''):?>
                                            <span class="btn mb-1 btn-sm btn-outline-success">
                                                <div class="thumbnail-mobile">
                                                    <img src="<?=base_url($product['preview']);?>">
                                                </div>
                                            </span>
                                            <?php endif?>
                                        </div>
                                        <div class="col-md-12 p-0 mt-2">
                                            <?php if($conlai == 0){?>
                                            <button class="btn btn-block btn-sm btn-secondary" disabled="">
                                                <i class="fas fa-frown mr-1"></i><?=__('HẾT HÀNG');?>
                                            </button>
                                            <?php }else{?>
                                            <button class="btn btn-block btn-sm btn-primary"
                                                onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>,`<?=__($product['name']);?>`)">
                                                <i class="fas fa-shopping-cart mr-1"></i><?=__('MUA NGAY');?>
                                            </button>
                                            <?php }?>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <?php if($CMSNT->site('display_country') == 1):?>
                        <td class="text-center d-none-600">
                            <?=getFlag($product['flag']);?> 
                        </td>
                        <?php endif?>
                        <?php if($CMSNT->site('display_preview') == 1):?>
                        <td class="text-center d-none-1100">
                            <?php if($product['preview'] != ''):?>
                            <span class="btn mb-1 btn-sm btn-outline-success">
                                <div class="thumbnail">
                                    <img src="<?=base_url($product['preview']);?>">
                                </div>
                            </span>
                            <?php endif?>
                        </td>
                        <?php endif?>
                        <td class="text-center d-none-600"><span class="btn mb-1 btn-sm btn-outline-info">
                        <?=__('Còn lại:');?>
                                <b><?=format_cash($conlai);?></b>
                            </span></td>
                        <?php if ($CMSNT->site('display_sold') == 1):?>
                            <td class="text-center d-none-600"><span class="btn mb-1 btn-sm btn-outline-info">
                            <?=__('Đã bán:');?>
                                <b><?=format_cash($product['sold']);?></b>
                            </span></td>  
                        <?php endif?>
                        <td class="text-center d-none-600"><span class="btn mb-1 btn-sm btn-outline-danger">
                                <i class="far fa-money-bill-alt mr-1"></i>
                                <b><?=format_currency($product['price']);?></b>
                            </span>
                        </td>
                        <td class="text-center d-none-600">
                            <?php if($conlai == 0){?>
                            <button class="btn btn-block btn-sm btn-secondary" disabled="">
                                <i class="fas fa-frown mr-1"></i><?=__('HẾT HÀNG');?>
                            </button>
                            <?php }else{?>
                            <button class="btn btn-block btn-sm btn-primary"
                                onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>,`<?=__($product['name']);?>`)">
                                <i class="fas fa-shopping-cart mr-1"></i><?=__('MUA NGAY');?>
                            </button>
                            <?php }?>
                        </td>
                    </tr>

                    <?php }?>


                </tbody>
            </table>
        </div>
    </div>
<?php endif?>





<?php // BOX ?>
<?php if($CMSNT->site('type_showProduct') == 1):?>
    <?php foreach ($listProduct as $product):?>
                <?php
                $conlai = $product['id_api'] != 0 ? $product['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$product['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
                if($CMSNT->site('hide_product_empty') == 1){
                    if($conlai == 0){
                        continue;
                    }
                }
                ?>
                <div class="col-sm-6 col-md-6 col-lg-4 mt-4 mt-md-3">
                    <div class="basic-drop-shadow p-3 shadow-showcase">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <p><img class="mr-1"
                                        src="<?=base_url(getRowRealtime("categories", $product['category_id'], 'image'));?>"
                                        width="25px"><b><?=__($product['name']);?></b>
                                    <?=$product['preview'] != null ? '<a href="'.base_url($product['preview']).'" target="_blank"><i class="fas fa-search"></i></a>' : '';?>
                                </p>
                                <p style="font-size: 12px;"><i
                                        class="fas fa-angle-right mr-1"></i><i><?=__($product['content']);?></i></p>
                            </div>
                            <div class="col-md-7">
                                <span class="btn mb-1 btn-sm btn-outline-danger">
                                    <?=__('Giá:');?>
                                    <b><?=format_currency($product['price']);?></b>
                                </span>
                                <span class="btn mb-1 btn-sm btn-outline-info">
                                    <?=__('Còn lại:');?>
                                    <b><?=format_cash($conlai);?></b>
                                </span>
                                <?php if ($CMSNT->site('display_sold') == 1):?>
                                <span class="btn mb-1 btn-sm btn-outline-success">
                                    <?=__('Đã bán:');?>
                                    <b><?=format_cash($product['sold']);?></b>
                                </span>   
                                <?php endif?>
                                <?php if($CMSNT->site('display_country') == 1):?>
                                <span class="btn mb-1 btn-sm btn-outline-warning">
                                <?=__('Quốc gia:');?>
                                    <?=getFlag($product['flag']);?>
                                </span>
                                <?php endif?>
                                <?php if($CMSNT->site('display_preview') == 1 && $product['preview'] != ''):?>
                                <span class="btn mb-1 btn-sm btn-outline-success">
                                    <div class="thumbnail-mobile">
                                        <img src="<?=base_url($product['preview']);?>">
                                    </div>
                                </span>
                                <?php endif?>
                            </div>
                            <div class="col-md-5">
                                <?php if($CMSNT->site('display_rating') == 1):?>
                                <div class="mb-2"></div>
                                <?php
                        // tổng rating
                        $total_review = $CMSNT->get_row("SELECT COUNT(id) FROM `reviews` WHERE `product_id` = '".$product['id']."' ")['COUNT(id)'];
                        // tổng số sao
                        $total_user_rating = $CMSNT->get_row("SELECT SUM(`rating`) FROM `reviews` WHERE `product_id` = '".$product['id']."' ")['SUM(`rating`)'];
                        // không có review thì 0 sao
                        if ($total_review == 0) {
                            $average_rating = 5;
                        } else {
                            // tính trung bình số sao
                            $average_rating = number_format($total_user_rating / $total_review, 1);
                        }
                        ?>
                                <div class="text-center">
                                    <i
                                        class="fas fa-star <?=$average_rating >= 1 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                    <i
                                        class="fas fa-star <?=$average_rating >= 2 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                    <i
                                        class="fas fa-star <?=$average_rating >= 3 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                    <i
                                        class="fas fa-star <?=$average_rating >= 4 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                    <i
                                        class="fas fa-star <?=$average_rating >= 5 ? 'text-warning' : 'star-light';?> mr-1 main_star"></i>
                                </div>
                                <?php endif?>
                                <div class="mb-4"></div>
                                <?php if($conlai == 0){?>
                                <button class="btn btn-block btn-secondary" disabled>
                                    <i class="fas fa-frown mr-1"></i><?=__('HẾT HÀNG');?>
                                </button>
                                <?php }else{?>
                                <button class="btn btn-block btn-primary"
                                    onclick="modalBuy(<?=$product['id'];?>, <?=$product['price'];?>, `<?=__($product['name']);?>`)">
                                    <i class="fas fa-shopping-cart mr-1"></i><?=__('MUA NGAY');?>
                                </button>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach?>
<?php endif?>







 <?php  } else {?>
    <div class="col-sm-12 text-center">
        <div class="iq-maintenance">
            <img src="<?=base_url('public/datum');?>/assets/images/error/maintenance.png" class="img-fluid" alt="">
            <h3 class="mt-4 mb-2"><?=__('Sản phẩm không tồn tại');?></h3>
        </div>
    </div>



    <?php
    }?>
</div>


<?php
}?>