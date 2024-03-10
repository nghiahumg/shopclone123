<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Dashboard',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <!-- DataTables  & Plugins -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/jszip/jszip.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/pdfmake.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/vfs_fonts.js"></script>   
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
require_once(__DIR__.'/../../../models/is_license.php');

function where_not_admin($type){
    global $CMSNT;
    $where_not_admin = "";
    foreach ($CMSNT->get_list("SELECT * FROM `users` WHERE `admin` = 1 ") as $qw) {
        $where_not_admin .= " `$type` != '".$qw['id']."' AND";
    }
    return $where_not_admin;
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?=base_url_admin('addons');?>" type="button" class="btn btn-primary"><i class="fas fa-puzzle-piece mr-1"></i>CỬA HÀNG ADDONS</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            
           
            <div class="row">
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `fake` = 0 ")['COUNT(id)']);?></h3>
                            <p>Đơn hàng đã bán</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL ")['COUNT(id)']);?>
                            </h3>
                            <p>Tài khoản đã bán</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` ")['COUNT(id)']);?></h3>
                            <p>Tổng thành viên</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?=base_url_admin('users');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 ")['SUM(`pay`)']);?>
                            </h3>
                            <p>Doanh thu đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?=base_url_admin('product-order');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê tháng <?=date('m', time());?></h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TÀI KHOẢN ĐÃ BÁN</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê tuần</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TÀI KHOẢN ĐÃ BÁN</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê hôm nay</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`pay`) FROM `orders` WHERE `fake` = 0 AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`pay`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-warning text-xl">
                                    <i class="ion ion-ios-cart-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `buyer` IS NOT NULL AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">TÀI KHOẢN ĐÃ BÁN</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tổng tiền nạp toàn thời gian</span>
                            <span class="info-box-number"><?=format_currency(
    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 ")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` ")['SUM(`price`)']+
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` ")['SUM(amount)']+
                                    $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' ")['SUM(price)']
);?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tổng tiền nạp tháng <?=date('m', time());?></span>
                            <span class="info-box-number"><?=format_currency(
                                        $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`price`)'] +
                                $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`pay`)'] +
                                $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND YEAR(update_date) = ".date('Y')." AND MONTH(update_date) = ".date('m')." ")['SUM(`price`)'] +
                                $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE  YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(`price`)']
                                +
                                $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE YEAR(create_gettime) = ".date('Y')." AND MONTH(create_gettime) = ".date('m')." ")['SUM(amount)'] 
                                +
                                $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' AND YEAR(created_at) = ".date('Y')." AND MONTH(created_at) = ".date('m')." ")['SUM(price)']
                                
                                );?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tổng tiền nạp tuần</span>
                            <span class="info-box-number"><?=format_currency(
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND WEEK(update_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE WEEK(create_gettime, 1) = WEEK(CURDATE(), 1) ")['SUM(amount)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' AND WEEK(created_at, 1) = WEEK(CURDATE(), 1) ")['SUM(price)']
                                );?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tổng tiền nạp hôm nay</span>
                            <span class="info-box-number"><?=format_currency(
                                        $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_pm` WHERE `status` = 1 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`pay`) FROM `invoices` WHERE `status` = 1 AND `fake` = 0 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`pay`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `cards` WHERE `status` = 1 AND `update_date` >= DATE(NOW()) AND `update_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`price`)'] +
                                    $CMSNT->get_row("SELECT SUM(`price`) FROM `payment_paypal` WHERE `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY")['SUM(`price`)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(amount) FROM `server2_autobank` WHERE `create_gettime` >= DATE(NOW()) AND `create_gettime` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(amount)']
                                    +
                                    $CMSNT->get_row("SELECT SUM(price) FROM `nowpayments` WHERE `payment_status` = 'finished' AND `created_at` >= DATE(NOW()) AND `created_at` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(price)']
                                    );?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                200 GIAO DỊCH GẦN ĐÂY (<i>Ẩn dòng tiền của Admin</i>)
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Username</th>
                                            <th>Số tiền trước</th>
                                            <th>Số tiền thay đổi</th>
                                            <th>Số tiền hiện tại</th>
                                            <th>Thời gian</th>
                                            <th>Nội dung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `dongtien` WHERE ".where_not_admin('user_id')." `id` > 0 ORDER BY id DESC LIMIT 200 ") as $row) {?>
                                        <tr>
                                            <td class="text-center"><?=$i++;?></td>
                                            <td class="text-center"><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getUser($row['user_id'], 'username');?></a>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color: green;"><?=format_currency($row['sotientruoc']);?></b>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color:red;"><?=format_currency($row['sotienthaydoi']);?></b>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color: blue;"><?=format_currency($row['sotiensau']);?></b>
                                            </td>
                                            <td class="text-center"><i><?=$row['thoigian'];?></i></td>
                                            <td><i><?=$row['noidung'];?></i></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end align-items-center border-top-table p-2">
                                <a type="button" href="<?=base_url_admin('dong-tien');?>" class="btn btn-primary">Xem
                                    Thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                200 NHẬT KÝ HOẠT ĐỘNG GẦN ĐÂY (<i>Ẩn nhật ký của Admin</i>)
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table id="datatable2" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Username</th>
                                            <th width="40%">Action</th>
                                            <th>Time</th>
                                            <th>Ip</th>
                                            <th width="30%">Device</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `logs` WHERE ".where_not_admin('user_id')." `id` > 0 ORDER BY id DESC LIMIT 200 ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td class="text-center"><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getUser($row['user_id'], 'username');?></a>
                                            </td>
                                            <td><?=$row['action'];?></td>
                                            <td><?=$row['createdate'];?></td>
                                            <td><?=$row['ip'];?></td>
                                            <td><?=$row['device'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end align-items-center border-top-table p-2">
                                <a type="button" href="<?=base_url_admin('logs');?>" class="btn btn-primary">Xem
                                    Thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


<?php
require_once(__DIR__.'/footer.php');
?>
 