<?php
header('Access-Control-Allow-Origin:*');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/data-index/public_model.php');
include('../../../model/dropdown_model.php');

$data = [];
$data['list'] = [];

$dropdown_list = dropdownDB::getWard();

foreach ($dropdown_list as $key => $value) {
    $data_ward = array(
        'ward_id' => $value['ward_id'],
        'wardName' => $value['wardName'],
        'district_id' => $value['district_id']
    );
    array_push($data['list'], $data_ward);
}
echo json_encode($data,JSON_UNESCAPED_UNICODE);
