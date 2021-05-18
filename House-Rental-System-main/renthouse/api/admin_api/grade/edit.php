<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include('../../../config/database.php');
include('../../../model/admin/admin_model.php');
include('../../../model/data-index/public_model.php');
include('../../../model/check_exist/exist_model.php');
include('../../../model/admin/data-admin.php');
include('../../../model/tenant/tenant_model.php');


include('../check_token_admin.php');

$id = isset($_GET['id']) ? $_GET['id'] : die();

$exist_id = Check_existDB::checkGrade($id);
$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$quantities = $data->quantities;
$discount = $data->discount;

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if ($exist_id > 0){

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $update_at = date('Y/m/d H:i:s');

    dataDB::updateGrade($id,$name,$quantities,$discount,$update_at);
    echo json_encode(array('success' => 'cập nhật thành công'));
}else{
    echo json_encode(array('errors' => 'id không tồn tại'));
}