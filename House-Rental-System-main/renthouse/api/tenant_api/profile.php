<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include ('../../model/tenant/tenant_model.php');
include ('../../model/check_exist/exist_model.php');

include ('check_token.php');

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
}else{
    $profile =tenantDB::getProfile($checkToken['tenant_id']);

    $data_profile = array(
        'tenant_id'=>$checkToken['tenant_id'],
        'full_name'=>$profile['full_name'],
        'email'=>$profile['email'],
        'phone_no'=>$profile['phone_no'],
        'sex'=>$profile['sex'],
        'reDate'=>$profile['reDate']
    );
    echo json_encode($data_profile);
}
