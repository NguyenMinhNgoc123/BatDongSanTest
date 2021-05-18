<?php
header('Access-Control-Allow-Origin:*');
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include('../../config/database.php');
include('../../model/data-index/sell_rs_model.php');
include('../../model/data-index/public_model.php');

$data = [];
$data['srs'] = [];

$result_rs = ProductDBSell::getProductsVip();
$vip = count($result_rs);

foreach ($result_rs as $key_rrs => $value_rrs) {
    if ($key_rrs < 8) {

        $kind_new = productDB::getKindNews($value_rrs['kind_id']);;
        //if ($kind_new == 3 || $kind_new == 2) {

        $property_id = $value_rrs['property_id'];
        $result = productDB::getPrice($value_rrs['estimated_price']);
        $post_type_name = productDB::getProductPtype($value_rrs['ptype_id']);

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
            'ptype name'=>$post_type_name['ptypeName'],
            'caption' => $value_rrs['caption'],
            'image' => $img,
            'land_area' => $land_area,
            'estimated_price' => $result,
            'post_time' => $time,
            'kind_id' => $value_rrs['kind_id'],
            'kind_news'=>$kind_new['name']
        );
        array_push($data['srs'], $data_product);
    }
}
if ($vip < 8){
    $result_rs2 = ProductDBSell::getProductsEndow();
    $endow = count($result_rs2);
    foreach ($result_rs2 as $key_rrs => $value_rrs) {
        if ($key_rrs < (8-$vip)) {

            $kind_new = productDB::getKindNews($value_rrs['kind_id']);;
            //if ($kind_new == 3 || $kind_new == 2) {
            $post_type_name = productDB::getProductPtype($value_rrs['ptype_id']);

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
            $data_product2 = array(
                'property_id' => $property_id,
                'tenant_id' => $value_rrs['tenant_id'],
                'ptype name'=>$post_type_name['ptypeName'],
                'caption' => $value_rrs['caption'],
                'image' => $img,
                'land_area' => $land_area,
                'estimated_price' => $result,
                'post_time' => $time,
                'kind_id' => $value_rrs['kind_id'],
                'kind_news'=>$kind_new['name']
            );
            array_push($data['srs'], $data_product2);
        }
    }
    if ($endow < 8){
        $result_rs1 = ProductDBSell::getProductsOften();

        foreach ($result_rs1 as $key_rrs => $value_rrs) {
            if ($key_rrs < (8-$vip - $endow)) {

                $kind_new = productDB::getKindNews($value_rrs['kind_id']);;
                //if ($kind_new == 3 || $kind_new == 2) {
                $post_type_name = productDB::getProductPtype($value_rrs['ptype_id']);

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
                $data_product1 = array(
                    'property_id' => $property_id,
                    'tenant_id' => $value_rrs['tenant_id'],
                    'ptype name'=>$post_type_name['ptypeName'],
                    'caption' => $value_rrs['caption'],
                    'image' => $img,
                    'land_area' => $land_area,
                    'estimated_price' => $result,
                    'post_time' => $time,
                    'kind_id' => $value_rrs['kind_id'],
                    'kind_news' => $kind_new['name']
                );
                array_push($data['srs'], $data_product1);
            }
        }
    }
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);



