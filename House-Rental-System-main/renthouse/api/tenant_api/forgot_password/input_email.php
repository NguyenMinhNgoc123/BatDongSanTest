<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/tenant/tenant_model.php');
include('../../../model/check_exist/exist_model.php');

$data = json_decode(file_get_contents("php://input"));

$email =$data->email;

$check_email = Check_existDB::checkEmail($email);
//print_r($check_email);die();
if ($check_email){
    $code = rand(999999, 111111);
    $insert_code = tenantDB::getToken($code,$email);
//    print_r($insert_code);die();
    if ($insert_code){
        $subject = "HomeRent.com";
        $message = "Mã đặt lại mật khẩu của bạn $code";
        $sender = "From: HomeRent@gmail.com";
        if (mail($email, $subject, $message, $sender)) {
            $info = "Chúng tôi đã gửi một otp đặt lại mật khẩu đến email của bạn - $email";

            echo json_encode(array(
                'success' => $info,
                'note' =>'dẫn đến file input otp'
            ));
        }
    }
}else{
    echo json_encode(array('errors' => 'Email không tồn tại'));
};