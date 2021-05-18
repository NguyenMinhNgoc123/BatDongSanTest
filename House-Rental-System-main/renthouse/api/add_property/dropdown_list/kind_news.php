<?php
header('Access-Control-Allow-Origin:*');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/data-index/public_model.php');
include('../../../model/dropdown_model.php');

$data = [];
$data['list'] = [];
$dropdown_list = dropdownDB::getKindNews();

foreach ($dropdown_list as $key => $value) {
    $price = productDB::getPrice($value['price']);
    $data_pro = array(
        'id'=>$value['kind_id'],
        'name'=>$value['name'],
        'price'=>$price.' /ngày',
    );
    array_push($data['list'], $data_pro);
}
echo json_encode($data,JSON_UNESCAPED_UNICODE);