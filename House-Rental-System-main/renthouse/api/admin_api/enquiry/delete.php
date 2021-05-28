<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/admin/admin_model.php');
include('../../../model/data-index/public_model.php');
include('../../../model/check_exist/exist_model.php');
include('../../../model/admin/data-admin.php');

include('../check_token_admin.php');

$id = isset($_GET['id']) ? $_GET['id'] : die();

$checkFeedback = dataDB::EnquiryCheck($id);

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if ($checkFeedback == 0) {
    echo json_encode(array('errors' => 'id không tồn tại'));
} else {
    dataDB::DelelteEnquiry($id);
    echo json_encode(array('success' => 'Xóa phản hồi thành công'));
}