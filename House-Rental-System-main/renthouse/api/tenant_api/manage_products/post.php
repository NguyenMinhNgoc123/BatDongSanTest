<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/tenant/tenant_model.php');
include('../../../model/data-index/public_model.php');
include('../../../model/check_exist/exist_model.php');
include('../../../model/data-index/sell_rs_model.php');

include('../check_token.php');

$ptype = isset($_GET['ptype_id']) ? $_GET['ptype_id'] : die();
$data = [];
$data['list'] = [];

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else {
    $note_0 = 0;
    $note_1 = 1;
    if ($ptype == '0'){
        $list_product = tenantDB::getProductTenantNote($checkToken['tenant_id'], $note_0, $note_1);
    }else{
        if ($ptype == 1) {

            $ptype_id ='1';
        }
        if ($ptype == 2) {
            $ptype_id ='2';
        }
        $list_product = tenantDB::getProductTenantPtype($checkToken['tenant_id'],$ptype_id,$note_0,$note_1);

    }

    foreach ($list_product as $key => $value) {

        $property_id = $value['property_id'];
        $pm = tenantDB::getPayment($property_id,$checkToken['tenant_id']);
        $result = productDB::getPrice($value['estimated_price']);

        $result_img = ProductDBSell::getImgAvatar($property_id);
        if ($result_img){
            foreach ($result_img as $key_img => $value_img) {
                if ($key_img == 1) {
                    $img = $value_img['p_photo'];
                }
            }
        }else{
            $img =null;
        }
        //xử lý giờ
        $time = productDB::getTime($value['create_at']);
        //xử lý thanh toán
        if ($pm){
            if ($pm['status'] == 'unpaid') {
                $status = 'Chưa thanh toán';
            } else {
                if ($pm['status'] == 'paid') {
                    $status = 'Đã thanh toán';
                }
            }
            $payment_price = productDB::getPrice($pm['price']);
            $day_number = $pm['day_number'];
        }else{
            $status=null;
            $payment_price=null;
            $day_number=null;
        }


        $chouse_name = productDB::getPropertyType($value['chouse_id']);
        $post_type_name = productDB::getProductPtype($value['ptype_id']);
        $land_area = $value['land_area'];
        $data_product = array(
            'property_id' => $property_id,
            'tenant_id' => $value['tenant_id'],
            'ptype_id'=>$value['ptype_id'],
            'street'=>$value['street'],
            'apartment_number'=>$value['apartment_number'],
            'price_post' => $payment_price,
            'day_number'=>$day_number,
            'post_status' => $status,
            'chouse_name' => $chouse_name['property_typeName'],
            'ptype_name' => $post_type_name['ptypeName'],
            'image' => $img,
            'land_area' => $land_area,
            'estimated_price' => $result,
            'post_time' => $time,
            'status' => $value['note']
        );
        array_push($data['list'], $data_product);

    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}