<?php
header('Access-Control-Allow-Origin:*');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/data-index/public_model.php');
include('../../../model/dropdown_model.php');

$data = [];
$data['list'] = [];
$dropdown_list = dropdownDB::getBank();

foreach ($dropdown_list as $key => $value) {
    $data_pro = array(
        'id'=>$value['id'],
        'name'=>$value['name'],
        'bank_number'=>$value['bank_number'],
        'bank_name'=>$value['bank_name']
    );
    array_push($data['list'], $data_pro);
}
echo json_encode($data,JSON_UNESCAPED_UNICODE);
