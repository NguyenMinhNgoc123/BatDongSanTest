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

$data=[];
$data['list'] = [];

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
}else{
    $kind_news =dataDB::getKindNews();

    foreach ($kind_news as $key => $value){
        $price = productDB::getPrice($value['price']);
        $data_kind_news = array(
            'kind_id'=>$value['kind_id'],
            'name'=>$value['name'],
            'price'=>$price,
            'create_at'=>$value['create_at'],
            'update_price'=>$value['update_price'],
        );
        array_push($data['list'], $data_kind_news);
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}