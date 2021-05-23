<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/admin/admin_model.php');
include('../../../model/data-index/public_model.php');
include('../../../model/check_exist/exist_model.php');
include('../../../model/admin/data-admin.php');
include('../../../model/tenant/tenant_model.php');

include ('../check_token_admin.php');
//$headers = apache_request_headers();
//$token = $headers['token'];
//$checkToken = Check_existDB::checkToken($token);

$property_id = isset($_GET['id']) ? $_GET['id'] : die();
$data = [];
$data['image'] = [];
$note='1';
$detail = dataDB::getdetails($property_id,$note);

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if ($detail > 0) {
    $pm = dataDB::selectPayment($property_id);
    $ptypeName = ProductDB::getProductPtype($detail['ptype_id']);
    $cityName = ProductDB::getCityName($detail['city_id']);
    $districtName = ProductDB::getDistrictName($detail['district_id']);
    $wardName = ProductDB::getWardName($detail['ward_id']);


    $price = productDB::getPrice($detail['estimated_price']);
    $time = productDB::getTime($detail['create_at']);
    $chouse_name =productDB::getPropertyType($detail['chouse_id']);
    $phone = tenantDB::getProfile($detail['tenant_id']);
    $image =tenantDB::ListImage($property_id);
    if ($image){
        foreach ($image as $key1 =>$value1){
            $id_img = $key1;
            $property_id_img = $value1['property_id'];
            $image = $value1['p_photo'];
            $img = array(
                'property_id' => $property_id_img,
                'image' => $image
            );
            array_push($data['image'], $img);
        }
    }
    //$google_map = productDB::getGoogleMap($detail['apartment_number'],$detail['street'],$wardName['wardName'],$districtName['districtName'],$cityName['cityName']);

    $data_product = array(
        'property_id' => $property_id,
        'tenant_id' => $detail['tenant_id'],
        'chouse_name' => $chouse_name['property_typeName'],
        'chouse_id'=>$detail['chouse_id'],
        'caption' => $detail['caption'],
        'ptypeName' => $ptypeName['ptypeName'],
        'ptype_id'=>$detail['ptype_id'],
        'cityName' => $cityName['cityName'],
        'city_id'=>$detail['city_id'],
        'districtName' => $districtName['districtName'],
        'district_id'=>$detail['district_id'],
        'wardName' => $wardName['wardName'],
        'ward_id'=>$detail['ward_id'],
        'street' => $detail['street'],
        'apartment_number' => $detail['apartment_number'],
        'estimated_price' => $price,
        'land_area' => $detail['land_area'],
        'description' => $detail['description'],
        'create_at' => $time,
        'img' => $data
    );

    echo json_encode($data_product);
} else {
    echo json_encode(array('errors' => 'id hoặc token không hợp lệ'));
}



