<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/data-index/sell_rs_model.php');
include('../../../model/data-index/public_model.php');
include ('../../../model/check_exist/exist_model.php');
include ('../../../model/tenant/tenant_model.php');

include ('../check_token.php');
//$headers = apache_request_headers();
//$token = $headers['token'];
//$checkToken = Check_existDB::checkToken($token);

$property_id = isset($_GET['id']) ? $_GET['id'] : die();
$data = [];
$data['image'] = [];
$note='1';

$detail = tenantDB::getPayment($property_id,$checkToken['tenant_id']);

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if ($detail > 0) {
    //$pm = tenantDB::getPayment($property_id,$checkToken['tenant_id']);
//    $ptypeName = ProductDB::getProductPtype($detail['ptype_id']);
//    $cityName = ProductDB::getCityName($detail['city_id']);
//    $districtName = ProductDB::getDistrictName($detail['district_id']);
//    $wardName = ProductDB::getWardName($detail['ward_id']);
    $bank = productDB::getBank();
    if ($detail){
        if ($detail['status'] == 'unpaid') {
            $status = 'Chưa thanh toán';
        } else {
            if ($detail['status'] == 'paid') {
                $status = 'Đã thanh toán';
            }
        }
        $payment_price = productDB::getPrice($detail['price']);
        $day_number = $detail['day_number'];
    }else{
        $status=null;
        $payment_price=null;
        $day_number=null;
    }

//    $result_img = ProductDBSell::getImgAvatar($property_id);
//    foreach ($result_img as $key_img => $value_img) {
//        $id_img = $key_img;
//        $property_id_img = $value_img['property_id'];
//        $image = $value_img['p_photo'];
//        $img = array(
//            'property_id' => $property_id_img,
//            'image' => $image
//        );
//        array_push($data['image'], $img);
//    }
//    $price = productDB::getPrice($detail['estimated_price']);
//    $time = productDB::getTime($detail['create_at']);
//    $chouse_name =productDB::getPropertyType($detail['chouse_id']);
//    $phone = tenantDB::getProfile($checkToken['tenant_id']);
//    $google_map = productDB::getGoogleMap($detail['apartment_number'],$detail['street'],$wardName['wardName'],$districtName['districtName'],$cityName['cityName']);

    $data_product = array(
        'property_id' => $property_id,
        'tenant_id' => $detail['tenant_id'],
        'bank_name'=>$bank['bank_name'],
        'name'=>$bank['name'],
        'bank_number'=>$bank['bank_number'],
        'price'=>$payment_price,
        'price_root'=>$detail['price'],
    );

    echo json_encode($data_product);
} else {
    echo json_encode(array('errors' => 'id hoặc token không hợp lệ'));
}



