<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include('../../model/tenant/tenant_model.php');
include('../../model/check_exist/exist_model.php');

include('check_token.php');

$data = json_decode(file_get_contents("php://input"));


$full_name = $data->full_name;
$phone_no = $data->phone_no;
$sex = $data->sex;

$check_phone = Check_existDB::checkPhoneUpdate($checkToken['tenant_id'],$phone_no);

$profile = tenantDB::getProfile($checkToken['tenant_id']);
if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if (empty($full_name)) {
    echo json_encode(array('errors' => 'không được để trống tên'));
} else if (empty($phone_no)) {
    echo json_encode(array('errors' => 'Vui lòng nhập số điện thoại'));
} else if (strlen($phone_no) != 10){
    echo json_encode(array('errors' => 'Bạn nhập không đúng 10 số'));
} else if ($check_phone > 0) {
    echo json_encode(array('errors' => 'số điện thoại đã tồn tại'));
} else {
    $tenant_id = $checkToken['tenant_id'];
    tenantDB::Update($tenant_id, $full_name, $phone_no, $sex);
    echo json_encode(array('success' => 'Cập nhật thành công'));
}