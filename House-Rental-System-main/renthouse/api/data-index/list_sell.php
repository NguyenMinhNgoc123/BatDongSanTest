<?php
header('Access-Control-Allow-Origin:*');
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include('../../config/database.php');
include('../../model/data-index/public_model.php');
include('../../model/data-index/sell_rs_model.php');
include('../../model/admin/admin_model.php');
include('../../model/admin/data-admin.php');
include('../../model/check_exist/exist_model.php');
include('../../model/tenant/tenant_model.php');

//---------------------------------------------------------------
$data = [];
$data['list'] = [];


if (isset($_GET['page']) && isset($_GET['row_per_page'])){
    $page = $_GET['page'];
    $row_per_page = $_GET['row_per_page'];
    $begin = ($page * $row_per_page) - $row_per_page;

    $list_product = ProductDBSell::getProducts($begin,$row_per_page);

    $countPost=ProductDBSell::getProductsCount();
    $result1 = ceil($countPost/$row_per_page);
    $data['total_page'] = $result1;

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

        $chouse_name =productDB::getPropertyType($value_rs['chouse_id']);
        $post_type_name = productDB::getProductPtype($value_rs['ptype_id']);
        $land_area = $value_rs['land_area'];
        $data_product = array(
            'property_id' => $property_id,
            'tenant_id' => $value_rs['tenant_id'],
            'caption'=>$value_rs['caption'],
            'chouse_name'=>$chouse_name['property_typeName'],
            'ptype_name'=>$post_type_name['ptypeName'],
            'cityName'=>$cityName['cityName'],
            'districtName'=>$districtName['districtName'],
            'wardName'=>$wardName['wardName'],
            'street'=>$value_rs['street'],
            'apartment_number'=>$value_rs['apartment_number'],
            'image' => $img,
            'land_area' => $land_area,
            'estimated_price' => $result,
            'post_time' => $time,
            'kind_id'=>$value_rs['kind_id'],
            'kind_new'=>$kind_new['name']
        );
        array_push($data['list'], $data_product);
    }
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}




