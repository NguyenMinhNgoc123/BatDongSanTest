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

$data = [];
$data['list'] = [];

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else {
    $enquiry = dataDB::getPostEnquiry();

    foreach ($enquiry as $key => $value) {
        $time = productDB::getTime($value['create_at']);
        if ($value['status'] == '0'){
            $status_name ='chưa phản hồi';
        }else{
            $status_name ='Đã phản hồi';
        }
        $data_enquiry = array(
            'id' => $value['id'],
            'full_name' => $value['full_name'],
            'email' => $value['email'] ,
            'phone_no' => $value['phone_no'],
            'description' => $value['description'],
            'create_at'=>$time,
            'status'=>$value['status'],
            'status_name'=>$status_name
        );
        array_push($data['list'], $data_enquiry);
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}