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
include('../../../model/tenant/tenant_model.php');

include('../check_token_admin.php');

$data = [];
$data1 = [];

$data['list'] = [];
$data1['list'] = [];

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else {
    $list_product = dataDB::getProducts();

    foreach ($list_product as $key => $value) {

        $property_id = $value['property_id'];

        $result = productDB::getPrice($value['estimated_price']);

        //xử lý giờ
        //$time = productDB::getTime($value['create_at']);
        $payment =dataDB::selectPayment($property_id);
        if ($payment){
            if ($payment['status'] == 'unpaid') {
                $status_pm = 'Chưa thanh toán';
            } else {
                if ($payment['status'] == 'paid') {
                    $status_pm = 'Đã thanh toán';
                }
            }
            $payment_price = productDB::getPrice($payment['price']);
            $day_number = $payment['day_number'];
        }else{
            $status_pm=null;
            $payment_price=null;
            $day_number=null;
        }
        $cityName = ProductDB::getCityName($value['city_id']);
        $districtName = ProductDB::getDistrictName($value['district_id']);
        $wardName = ProductDB::getWardName($value['ward_id']);
        $email = tenantDB::getProfile($value['tenant_id']);
        $chouse_name = productDB::getPropertyType($value['chouse_id']);
        $post_type_name = productDB::getProductPtype($value['ptype_id']);
        $land_area = $value['land_area'];
        $status = dataDB::selectPayment($value['property_id']);
        if ($status > 0 ){
            $post_price=productDB::getPrice($status['price']);
        }else{
            $post_price = '';
        }
        //$result_img = dataDB::getImg($property_id);

        $data_product = array(
            'property_id' => $property_id,
            'post_price' => $post_price,
            'email' => $email['email'],
            'name'=>$email['full_name'],
            'phone'=>$email['phone_no'],
            'chouse_name' => $chouse_name['property_typeName'],
            'cityName' => $cityName['cityName'],
            'districtName' => $districtName['districtName'],
            'wardName' => $wardName['wardName'],
            'street' => $value['street'],
            'apartment_number' => $value['apartment_number'],
            'ptype_id'=>$value['ptype_id'],
            'ptype_name' => $post_type_name['ptypeName'],
            'land_area' => $land_area,
            'estimated_price' => $value['estimated_price'],
            //'description' => $value['description'],
            'day_number'=>$status['day_number'],
            'payment'=>$payment['price'],
            'payment_status'=>$status_pm,
            'post_time' => $value['create_at'],
            'note' => $value['note']
        );
        array_push($data['list'], $data_product);
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}




