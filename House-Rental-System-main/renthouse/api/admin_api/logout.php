<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include('../../model/admin/admin_model.php');
include('../../model/check_exist/exist_model.php');
include('../../model/data-index/public_model.php');

include ('check_token_admin.php');

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else {
    $logout = AdminDB::Logout($checkTokenAdmin['token']);
    if ($logout > 0) {
        echo json_encode(array('success' => 'Đăng xuất thành công'));
    } else {
        echo json_encode(array('errors' => 'Đăng xuất không thành công'));
    }
}