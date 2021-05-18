<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST,GET');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include('../../../config/database.php');
include('../../../model/data-index/public_model.php');
include('../../../model/data-index/sell_rs_model.php');

$data = json_decode(file_get_contents("php://input"));

$caption = $data->caption_s;
$city_id = $data->city_id_s;
$district_id = $data->district_id_s;
$ward_id = $data->ward_id_s;
$price_begin = $data->price_begin;
$price_end = $data->price_end;
$land_area_begin = $data->land_area_begin;
$land_area_end = $data->land_area_end;

$data = [];
$data['list'] = [];

if (isset($_GET['page']) && isset($_GET['row_per_page'])) {
    $page = $_GET['page'];
    $row_per_page = $_GET['row_per_page'];
    $begin = ($page * $row_per_page) - $row_per_page;

        //giá bắt đầu
        if (!isset($price_begin) || $price_begin == null || $price_begin == ' ') {
            $price_begin = 0;
        }

        //giá kết thúc
        if (!isset($price_end) || $price_end == null || $price_end == ' ') {
            $price_end = 999999999999;
        }
        //diện tích bắt đầu
        if (!isset($land_area_begin) || $land_area_begin == null || $land_area_begin == ' ') {
            $land_area_begin = 0;
        }

        //diện tích kết thúc
        if (!isset($land_area_end) || $land_area_end == null || $land_area_end == ' ') {
            $land_area_end = 999999999999;
        }

        if (isset($city_id) && isset($district_id) && isset($ward_id)) {
            $list_product = ProductDBSell::getProductsSearchAll($begin, $row_per_page, $caption, $city_id, $district_id, $ward_id, $price_begin, $price_end, $land_area_begin, $land_area_end);
        }

        if (isset($city_id) && isset($district_id) && (empty($ward_id) || $ward_id == null || $ward_id == ' ')) {
            $list_product = ProductDBSell::getProductsSearchCityDistrict($begin, $row_per_page, $caption, $city_id, $district_id, $price_begin, $price_end, $land_area_begin, $land_area_end);
        }

        if (isset($city_id) && (empty($district_id) || $district_id == null || $district_id == ' ') && (empty($ward_id) || $ward_id == null || $ward_id == ' ')) {
            $list_product = ProductDBSell::getProductsSearchCity($begin, $row_per_page, $caption, $city_id, $price_begin, $price_end, $land_area_begin, $land_area_end);
        }
        if (empty($city_id) && empty($district_id) && empty($ward_id)){
            $list_product = ProductDBSell::getProductsSearchNot($begin, $row_per_page, $caption, $price_begin, $price_end, $land_area_begin, $land_area_end);
        }


    foreach ($list_product as $key_rs => $value_rs) {
        $property_id = $value_rs['property_id'];

        $result = productDB::getPrice($value_rs['estimated_price']);
        $kind_new = productDB::getKindNews($value_rs['kind_id']);;

        $cityName = ProductDB::getCityName($value_rs['city_id']);
        $districtName = ProductDB::getDistrictName($value_rs['district_id']);
        $wardName = ProductDB::getWardName($value_rs['ward_id']);

        $result_img = ProductDBSell::getImgAvatar($property_id);
        foreach ($result_img as $key_img => $value_img) {
            if ($key_img == 1) {
                $img = $value_img['p_photo'];
            }
        }
        //xử lý giờ
        $time = productDB::getTime($value_rs['update_note']);
        //--xử lý phòng bedroom

        $chouse_name = productDB::getPropertyType($value_rs['chouse_id']);
        $post_type_name = productDB::getProductPtype($value_rs['ptype_id']);
        $data_product = array(
            'property_id' => $property_id,
            'tenant_id' => $value_rs['tenant_id'],
            'caption' => $value_rs['caption'],
            'chouse_name' => $chouse_name['property_typeName'],
            'ptype_name' => $post_type_name['ptypeName'],
            'cityName'=>$cityName['cityName'],
            'districtName'=>$districtName['districtName'],
            'wardName'=>$wardName['wardName'],
            'street'=>$value_rs['street'],
            'apartment_number'=>$value_rs['apartment_number'],
            'image' => $img,
            'land_area' => $value_rs['land_area'],
            'estimated_price' => $result,
            'post_time' => $time,
            'kind_id' => $value_rs['kind_id'],
            'kind_new' => $kind_new['name']
        );
        array_push($data['list'], $data_product);
    }
}
echo json_encode($data, JSON_UNESCAPED_UNICODE);



