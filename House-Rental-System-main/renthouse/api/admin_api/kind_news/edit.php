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

$kind_id = isset($_GET['id']) ? $_GET['id'] : die();

$exist_kind = Check_existDB::checkExistKindNews($kind_id);
$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$price = $data->price;

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if ($exist_kind > 0){
    $price=str_replace(',', '', $price);
    $price=str_replace('.', '', $price);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time = date('Y/m/d H:i:s');

    dataDB::updateKindNews($kind_id,$name,$price,$time);
    echo json_encode(array('success' => 'cập nhật thành công'));
}else{
    echo json_encode(array('errors' => 'id không tồn tại'));
}