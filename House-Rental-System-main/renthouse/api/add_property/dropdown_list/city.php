<?php
header('Access-Control-Allow-Origin:*');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/data-index/public_model.php');
include('../../../model/dropdown_model.php');

$data = [];
$data['list'] = [];
$dropdown_list = dropdownDB::getCity();

foreach ($dropdown_list as $key => $value) {
    $data_city= array(
        'city_id' => $value['city_id'],
        'cityName'=>$value['cityName']
    );
    array_push($data['list'], $data_city);
}
echo json_encode($data,JSON_UNESCAPED_UNICODE);
