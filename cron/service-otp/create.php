<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../../libs/db.php');
    require_once(__DIR__.'/../../config.php');
    require_once(__DIR__.'/../../libs/helper.php');
    $CMSNT = new DB();

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_service_otp_cron')) {
        if (time() - $CMSNT->site('check_time_cron_service_otp_cron') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron_service_otp_cron' ");

    if($CMSNT->site('status_thuesim') != 1){
        die('Chức năng này đang tắt');
    }
    if($CMSNT->site('server_thuesim') == ''){
        die('Vui lòng chọn server');
    }


    if($CMSNT->site('server_thuesim') == 'chothuesimcode.com'){
        $data = curl_get('https://chothuesimcode.com/api?act=app&apik='.$CMSNT->site('token_thuesim'));
        $data = json_decode($data, true);
        if($data['ResponseCode'] != 0){
            die($data['Msg']);
        }
        foreach($data['Result'] as $row){
            
            $id_api = check_string($row['Id']);
            $name_api = check_string($row['Name']);
            $price_api = check_string($row['Cost']) * 1000;
            $price = $price_api;
            if($CMSNT->site('ck_rate_thuesim') != 0){
                $price = $price + $price * $CMSNT->site('ck_rate_thuesim') / 100;
            }

            if($service_otp = $CMSNT->get_row("SELECT * FROM `service_otp` WHERE `id_api` = '$id_api' AND `server` = '".$CMSNT->site('server_thuesim')."' ")){
                // UPDATE
                $CMSNT->update('service_otp', [
                    'server'    => $CMSNT->site('server_thuesim'),
                    'id_api'    => $id_api,
                    'name_api'  => $name_api,
                    'name'      => $name_api,
                    'price_api' => $price_api,
                    'price'     => $price,
                    'update_time'   => time()
                ], " `id` = '".$service_otp['id']."' " );

            }else{
                // INSERT
                $CMSNT->insert('service_otp', [
                    'server'    => $CMSNT->site('server_thuesim'),
                    'id_api'    => $id_api,
                    'name_api'  => $name_api,
                    'name'      => $name_api,
                    'price_api' => $price_api,
                    'price'     => $price,
                    'status'    => 1,
                    'update_time'   => time()
                ]);

            }
        }
    }

    // XOÁ DỊCH VỤ HẾT HẠN
    $CMSNT->remove('service_otp', " ".time()." - `update_time` >= 86164 ");