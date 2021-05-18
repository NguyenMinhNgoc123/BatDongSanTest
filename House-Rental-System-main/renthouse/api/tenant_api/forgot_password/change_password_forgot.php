<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/tenant/tenant_model.php');


$email = isset($_GET['email']) ? $_GET['email'] : die();

$data = json_decode(file_get_contents("php://input"));

$new_password = $data->new_password;
$confirm_password = $data->confirm_password;

if (!isset($email)){
    echo json_encode(array('errors' => 'Lỗi email'));
} else if (strlen($new_password) < 6) {
    echo json_encode(array('errors' => 'Mật khẩu phải 6 kí tự trở lên'));
} else if ($new_password != $confirm_password) {
    echo json_encode(array('errors' => 'Mật khẩu không khớp'));
}
else {
    $new_password = md5($new_password);
    $code = 0;
    tenantDB::changPasswordForgot($email, $new_password);
    echo json_encode(array('success' => 'Đổi mật khẩu thành công'));
}