<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include('../../model/data-index/sell_rs_model.php');
include('../../model/data-index/rent_rs_model.php');
include('../../model/data-index/public_model.php');
include('../../model/tenant/tenant_model.php');

$property_id = isset($_GET['id']) ? $_GET['id'] : die();
$data = [];
$data['image'] = [];
$detail_rs = ProductDB::getProductDetails($property_id);

if ($detail_rs > 0) {
    $ptyeName = ProductDB::getProductPtype($detail_rs['ptype_id']);
    $cityName = ProductDB::getCityName($detail_rs['city_id']);
    $districtName = ProductDB::getDistrictName($detail_rs['district_id']);
    $wardName = ProductDB::getWardName($detail_rs['ward_id']);

    $result_img = ProductDBSell::getImgAvatar($property_id);
    foreach ($result_img as $key_img => $value_img) {
        $id_img = $key_img;
        $property_id_img = $value_img['property_id'];
        $image = $value_img['p_photo'];
        $img = array(
            'id' => $property_id_img,
            'image' => $image
        );
        array_push($data['image'], $img);
    }
    if ($detail_rs['update_note'] =='0000-00-00 00:00:00'){
        $time = 'chưa duyệt';
    }else{
        $time = productDB::getTime($detail_rs['update_note']);
    }

    $phone = tenantDB::getProfile($detail_rs['tenant_id']);
    $chouse_name =productDB::getPropertyType($detail_rs['chouse_id']);
    //print_r($chouse_name['property_typeName']);die();
    $google_map = productDB::getGoogleMap($detail_rs['apartment_number'],$detail_rs['street'],$wardName['wardName'],$districtName['districtName'],$cityName['cityName']);
    $data_product = array(
        'property_id' => $property_id,
        'tenant_id' => $detail_rs['tenant_id'],
        'chouse_name' => $chouse_name['property_typeName'],
        'caption' => $detail_rs['caption'],
        'ptypeName' => $ptyeName['ptypeName'],
        'cityName' => $cityName['cityName'],
        'districtName' => $districtName['districtName'],
        'wardName' => $wardName['wardName'],
        'street' => $detail_rs['street'],
        'apartment_number' => $detail_rs['apartment_number'],
        'estimated_price' => $detail_rs['estimated_price'],
        'land_area' => $detail_rs['land_area'],
        'description' => $detail_rs['description'],
        'post_time' => $time,
        'name'=>$phone['full_name'],
        'phone'=>$phone['phone_no'],
        'sex'=>$phone['sex'],
        'google_map'=>$google_map,
        'img' => $data
    );

    echo json_encode($data_product);
} else {
    echo json_encode(array('errors' => 'id không hợp lệ'));
}



