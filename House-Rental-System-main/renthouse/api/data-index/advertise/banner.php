<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/data-index/sell_rs_model.php');
include('../../../model/data-index/public_model.php');

$data = [];
$data['adv'] = [];

$result_rs = ProductDB::getProductsCover();

foreach ($result_rs as $key_rrs => $value_rrs) {
    if ($key_rrs < 3) {
        $kind_new = $value_rrs['kind_id'];
        //if ($kind_new == 3 || $kind_new == 2) {

        $property_id = $value_rrs['property_id'];
        $result = productDB::getPrice($value_rrs['estimated_price']);

        $result_img = ProductDBSell::getImgAvatar($property_id);
        foreach ($result_img as $key_img => $value_img) {
            if ($key_img == 1) {
                $img = $value_img['p_photo'];
            }
        }
        //xử lý giờ
        $time = productDB::getTime($value_rrs['update_note']);

        //--xử lý phòng bedroom
        $land_area = $value_rrs['land_area'];
        $data_product = array(
            'property_id' => $property_id,
            'tenant_id' => $value_rrs['tenant_id'],
            'caption' => $value_rrs['caption'],
            'image' => $img,
            'land_area' => $land_area,
            'estimated_price' => $result,
            'post_time' => $time,
            'kind_new' => $kind_new
        );
        array_push($data['adv'], $data_product);
    }
}
echo json_encode($data, JSON_UNESCAPED_UNICODE);



