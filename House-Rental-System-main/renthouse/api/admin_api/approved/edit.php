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

include('../check_token_admin.php');
//$headers = apache_request_headers();
//$token = $headers['token'];
//$checkToken = Check_existDB::checkToken($token);

$property_id = isset($_GET['id']) ? $_GET['id'] : die();
$data = [];
$data['image'] = [];
$note = '1';
$detail = dataDB::getdetails($property_id, $note);

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if ($detail > 0) {
    $data = json_decode(file_get_contents("php://input"));

    $chouse_id = $data->chouse_id;
    $ptype_id = $data->ptype_id;
    $caption = $data->caption;
    $kind_id = $data->kind_id;
    $city_id = $data->city_id;
    $district_id = $data->district_id;
    $ward_id = $data->ward_id;
    $street = $data->street;
    $apartment_number = $data->apartment_number;
    $estimated_price = $data->estimated_price;
    $land_area = $data->land_area;
    $description = $data->description;
    //xử lý dấu phẩy đáu chấm
    $estimated_price=str_replace(',', '', $estimated_price);
    $estimated_price=str_replace('.', '', $estimated_price);

    if ($chouse_id=='' || $ptype_id=='' || $caption=='' || $kind_id=='' || $city_id=='' || $district_id=='' || $ward_id=='' || $street=='' || $estimated_price=='' || $land_area=='' || $description==''){
        echo json_encode(array('errors' => 'không được để trống ngoại trừ số nhà'));
    }else{
        $check_chouse_id = Check_existDB::checkExistPropertyType($chouse_id);
        $check_ptype_id = Check_existDB::checkExistPostType($ptype_id);
        if ($check_chouse_id){
            if ($ptype_id){
                dataDB::updateProducts($property_id,$chouse_id,$ptype_id,$caption,$kind_id,$city_id,$district_id,$ward_id,$street,$apartment_number,$estimated_price,$land_area,$description);
                echo json_encode(array('success' => 'cập nhật thành công'));
            }else{
                echo json_encode(array('errors' => 'id loại hình không hợp lệ'));
            }
        }else{
            echo json_encode(array('errors' => 'id hình thức không hợp lệ'));
        }
    }
} else {
    echo json_encode(array('errors' => 'id hoặc token không hợp lệ'));
}



