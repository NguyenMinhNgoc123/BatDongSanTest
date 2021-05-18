<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/tenant/tenant_model.php');
include('../../../model/check_exist/exist_model.php');

$email = isset($_GET['email']) ? $_GET['email'] : die();

$data = json_decode(file_get_contents("php://input"));

$otp = $data->otp;

$check_code = Check_existDB::checkOTP($email,$otp);
//print_r($check_code);die();
if ($check_code){
    echo json_encode(array(
        'success' => 'xác nhận thành công - Vui lòng đổi mật khẩu mới',
        'note' =>'dẫn đến file change password forgot'
    ));
}else{
    echo json_encode(array('errors' => 'Mã otp không khớp'));
}
