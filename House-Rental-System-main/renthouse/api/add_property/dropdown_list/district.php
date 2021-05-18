<?php
header('Access-Control-Allow-Origin:*');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/data-index/public_model.php');
include('../../../model/dropdown_model.php');

$data = [];
$data['list'] = [];
$dropdown_list = dropdownDB::getDistrict();

foreach ($dropdown_list as $key => $value) {
    $data_district = array(
        'district_id' => $value['district_id'],
        'districtName' => $value['districtName'],
        'city_id' => $value['city_id'],
    );
    array_push($data['list'], $data_district);
}
echo json_encode($data,JSON_UNESCAPED_UNICODE);

