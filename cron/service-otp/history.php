<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../../libs/db.php');
    require_once(__DIR__.'/../../config.php');
    require_once(__DIR__.'/../../libs/helper.php');
    require_once(__DIR__.'/../../libs/database/users.php');
    $CMSNT = new DB();

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_service_otp_history')) {
        if (time() - $CMSNT->site('check_time_cron_service_otp_history') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", [
        'value' => time()
    ], " `name` = 'check_time_cron_service_otp_history' ");


    foreach($CMSNT->get_list(" SELECT * FROM `otp_history` WHERE `status` = 1 ") as $row){

        if($CMSNT->site('server_thuesim') == 'chothuesimcode.com'){
            $data = curl_get('https://chothuesimcode.com/api?act=code&apik='.$CMSNT->site('token_thuesim').'&id='.$row['id_order_api']);
            $data = json_decode($data, true);
            if($data['ResponseCode'] == 2){
                $isUpdate = $CMSNT->update('otp_history', [
                    'status'    => $data['ResponseCode'],
                    'update_time'   => time()
                ], " `id` = '".$row['id']."' AND `status` = 1 ");
                if($isUpdate){
                    $user = new users();
                    $user->AddCredits($row['user_id'], $row['price'], "Hoàn tiền đơn hàng thuê OTP #".$row['transid']." SDT ".$row['number']);
                }
                continue;
            }
            if($data['ResponseCode'] == 3){
                $isUpdate = $CMSNT->update('otp_history', [
                    'status'    => $data['ResponseCode'],
                    'update_time'   => time()
                ], " `id` = '".$row['id']."' AND `status` = 1 ");
                if($isUpdate){
                    $user = new users();
                    $user->AddCredits($row['buyer'], $row['price'], "Hoàn tiền đơn hàng thuê OTP #".$row['transid']." SDT ".$row['number']);
                }
                continue;
            }
            if($data['ResponseCode'] == 0){
                $isUpdate = $CMSNT->update('otp_history', [
                    'status'    => $data['ResponseCode'],
                    'code'      => $data['Result']['Code'],
                    'sms'      => $data['Result']['SMS'],
                    'update_time'   => time()
                ], " `id` = '".$row['id']."' AND `status` = 1 ");
                continue;
            }
        }


    }