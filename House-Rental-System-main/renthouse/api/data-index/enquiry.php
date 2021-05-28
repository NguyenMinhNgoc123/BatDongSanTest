<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include ('../../model/admin/data-admin.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

$data = json_decode(file_get_contents("php://input"));

$full_name = $data->full_name;
$email = $data->email;
$phone_no = $data->phone_no;
$description = $data->description;

if (empty($full_name)){
    echo json_encode(array('errors' => 'không được để trống tên'));
}else if (empty($email)){
    echo json_encode(array('errors' => 'không được để trống email'));
}else if (empty($description)){
    echo json_encode(array('errors' => 'không được để trống nội dung'));
}else{
    $check = dataDB::postEnquirycheck($full_name,$email,$phone_no,$description);
    if ($check){
        echo json_encode(array('errors' => 'Chỉ được gửi 1 lần'));
    }else{
        $status ='0';
        $date =date('Y/m/d H:i:s');
        $result11 = dataDB::postEnquiry($full_name,$email,$phone_no,$description,$date,$status);
        echo json_encode(array('success' => 'gửi phản hồi thành công'));
    }
}