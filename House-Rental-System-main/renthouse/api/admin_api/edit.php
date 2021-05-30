<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-type: application/json;multipart/form-data; charset=utf-8');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');

include('../../config/database.php');
include('../../model/admin/admin_model.php');
include('../../model/check_exist/exist_model.php');
include('../../model/admin/data-admin.php');


include('check_token_admin.php');

$chouse_id = filter_input(INPUT_POST,'chouse_id');
$ptype_id = filter_input(INPUT_POST, 'ptype_id');
$caption = filter_input(INPUT_POST, 'caption');
$kind_id = filter_input(INPUT_POST, 'kind_id');
$city_id = filter_input(INPUT_POST, 'city_id');
$district_id = filter_input(INPUT_POST, 'district_id');
$ward_id = filter_input(INPUT_POST, 'ward_id');
$street = filter_input(INPUT_POST, 'street');
$apartment_number = filter_input(INPUT_POST, 'apartment_number');
$estimated_price = filter_input(INPUT_POST, 'estimated_price');
$land_area = filter_input(INPUT_POST, 'land_area');
$description = filter_input(INPUT_POST, 'description');
$property_photo_id = filter_input(INPUT_POST, 'property_photo_id');

//xử lý dấu phẩy đáu chấm
$estimated_price = str_replace(',', '', $estimated_price);
$estimated_price = str_replace('.', '', $estimated_price);

$property_id = isset($_GET['id']) ? $_GET['id'] : die();

$note = '0';
$detail = dataDB::getdetails($property_id, $note);

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if (empty($chouse_id)) {
    echo json_encode(array('errors' => 'Không được để trống trường loại nhà'));
}else if (empty($ptype_id)) {
    echo json_encode(array('errors' => 'Không được để trống trường hình thức'));
}else if (empty($kind_id)) {
    echo json_encode(array('errors' => 'Không được để trống trường loại tin'));
} else if (empty($city_id)) {
    echo json_encode(array('errors' => 'Không được để trống trường thành phố'));
} else if (empty($district_id)) {
    echo json_encode(array('errors' => 'Không được để trống trường Quận huyện'));
} else if (empty($ward_id)) {
    echo json_encode(array('errors' => 'Không được để trống trường phường xã'));
}else if (empty($estimated_price)) {
    echo json_encode(array('errors' => 'Không được để trống trường Giá'));
} else if (is_numeric($estimated_price) == false) {
    echo json_encode(array('errors' => 'Không được nhập chữ trong trường giá tiền'));
} else if (empty($land_area)) {
    echo json_encode(array('errors' => 'Không được để trống trường diện tích sử dụng'));
} else if (empty($caption)) {
    echo json_encode(array('errors' => 'Không được để trống trường Tiêu đề'));
}else if ($detail) {

    $check_chouse_id = Check_existDB::checkExistPropertyType($chouse_id);
    $check_ptype_id = Check_existDB::checkExistPostType($ptype_id);
    if ($check_chouse_id) {
        if ($ptype_id) {
            $result =Check_existDB::checkPropertyPhoto($property_photo_id);
            if ($result > 0){
                $file = $_FILES['p_photo'];
                if ($file){
                    $img_old =$result['p_photo'];
                    if (is_file('../../../'.$img_old)){
                        unlink('../../../'.$img_old);
                    }
                    $c_image= $_FILES['p_photo']['name'];
                    $photo_name =$_FILES['p_photo']['tmp_name'];

                    $name_img = uniqid() . '.jpg';
                    $path = '../../owner/product-photo/' . $name_img;
                    $where = 'owner/product-photo/' . $name_img;

                    move_uploaded_file($photo_name,$path);
                    $p_photo = $where;
                    dataDB::editImg($property_photo_id,$property_id,$p_photo);
                }else{
                    echo json_encode(array('success' => 'lỗi ảnh'));
                }
            }
            dataDB::updateProducts($property_id, $chouse_id, $ptype_id, $caption, $kind_id, $city_id, $district_id, $ward_id, $street, $apartment_number, $estimated_price, $land_area, $description);
            echo json_encode(array('success' => 'cập nhật thành công'));
        } else {
            echo json_encode(array('errors' => 'id loại hình không hợp lệ'));
        }
    }
} else {
    echo json_encode(array('errors' => 'id hoặc token không hợp lệ'));
}



