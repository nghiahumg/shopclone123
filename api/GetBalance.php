<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../config.php");
require_once(__DIR__."/../libs/helper.php");
$CMSNT = new DB();


if(isset($_GET['username'])){
    $username = check_string($_GET['username']);
} else if(isset($_POST['username'])){
    $username = check_string($_POST['username']);
} else{
    $username = NULL;
}

if(isset($_GET['password'])){
    $password = check_string($_GET['password']);
} else if(isset($_POST['password'])){
    $password = check_string($_POST['password']);
} else{
    $password = NULL;
}


if ($username != NULL && $password != NULL) {
  
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '$username'  ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Thông tin đăng nhập không chính xác'
        ]));
    }
    if ($CMSNT->site('type_password') == 'bcrypt') {
        if (!password_verify($password, $getUser['password'])) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => 'Thông tin đăng nhập không chính xác'
            ]));
        }
    } else {
        if ($getUser['password'] != TypePassword($password)) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => 'Thông tin đăng nhập không chính xác'
            ]));
        }
    }
    if($CMSNT->site('status_api_buyproduct') == 0){
        die(__('Chức năng kết nối API đã được tắt trên website này'));
    }
    if ($money = $getUser['money']) {
        die(format_currency($money));
    } else {
        die(format_currency(0));
    }
}



