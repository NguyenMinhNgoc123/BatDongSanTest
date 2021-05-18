<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/data-index/public_model.php');
include('../../../model/check_exist/exist_model.php');
include('../../../model/tenant/tenant_model.php');

include('../check_token.php');

$data = [];
$data['list'] = [];

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else {
    $show_messages = tenantDB::getChat($checkToken['tenant_id']);

    if ($show_messages != null){
        foreach ($show_messages as $key =>$value){
            $name = tenantDB::getProfile($value['chat_with']);
            $data_show = array(
                'tenant_id'=>$name['tenant_id'],
                'full_name'=>$name['full_name'],

            );
            array_push($data['list'], $data_show);
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(array('notify' => 'Bạn chưa nhắn tin với ai'));
    }
}