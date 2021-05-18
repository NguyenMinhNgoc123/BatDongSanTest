<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');


include('../../../config/database.php');
include ('../../../model/tenant/tenant_model.php');
include('../../../model/data-index/public_model.php');
include ('../../../model/check_exist/exist_model.php');
include('../../../model/data-index/sell_rs_model.php');

include ('../check_token.php');

$data = [];
$data['list'] = [];

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
}else {
    $note = '1';
    $list_notify= tenantDB::getNotify($checkToken['tenant_id']);

    foreach ($list_notify as $key => $value) {
        $data_notify = array(
            'id'=> $value['id'],
            'tenant_id'=>$value['tenant_id'],
            'property_id'=>$value['comment'],
            'time'=> productDB::getTime($value['create_at'])

    );
        array_push($data['list'], $data_notify);

    }
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}