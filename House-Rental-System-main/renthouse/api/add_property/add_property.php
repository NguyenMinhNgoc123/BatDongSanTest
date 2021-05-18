<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');

include('../../config/database.php');
include('../../model/add_pr/add_model.php');
include('../../model/check_exist/exist_model.php');
include('../../model/data-index/public_model.php');


include ('../tenant_api/check_token.php');

$property_id = null;
$chouse_id = filter_input(INPUT_POST, 'chouse_id');
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
$day_number = filter_input(INPUT_POST, 'day_number');

//xử lý dấu phẩy đáu chấm
$estimated_price=str_replace(',', '', $estimated_price);
$estimated_price=str_replace('.', '', $estimated_price);

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
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
} else {
    if (empty($file = $_FILES['p_photo'])) {
        echo json_encode(array('errors' => 'Bạn cần phải có ảnh'));
    } else if (empty($file['name'][2])) {
        echo json_encode(array('errors' => 'Bạn cần phải có ít nhất 3 ảnh'));
    } else {
        if (isset($file['name'][2])) {
            $tenant_id = $checkToken['tenant_id'];

            $add_apartment = productAddDB::CreateAddProducts($property_id, $tenant_id,$kind_id, $caption, $chouse_id, $ptype_id,
                $city_id, $district_id, $ward_id, $street, $apartment_number, $estimated_price, $land_area, $description);
            $db = Database::getDB();
            $last_id = $db->lastInsertId();
            //$file = $_FILES['p_photo'];

            $filename = $file['tmp_name'];//lấy tên của ảnh
            $type = $file['type'];
            foreach ($filename as $key => $value) {
                if ($type[$key] == 'image/jpeg' || $type[$key] == 'image/jpg' || $type[$key] == 'image/png') {
                    $name_img = uniqid() . '.jpg';
                    $path = '../../owner/product-photo/' . $name_img;
                    $where = 'owner/product-photo/' . $name_img;

                    $image = file_get_contents($value);
                    $image = imagecreatefromstring($image);

                    imagejpeg($image, $path);
                    imagedestroy($image);
                    $p_photo = $where;
                    productAddDB::getImgage($p_photo, $last_id);
                }
            }
            $status = 'unpaid';
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $status_expires = date('Y/m/d H:i:s',strtotime('+ 3 days'));
            $start_status = date('Y/m/d H:i:s');
            $kind_price = productDB::getKindNews($kind_id);

            $checkTenant = Check_existDB::checkTenant($tenant_id);
            $checkPotentials = Check_existDB::checkGrade($checkTenant['grade_id']);
            if ($checkPotentials > 0){
                if ($checkTenant['grade_id'] == $checkPotentials['grade_id']){
                    $price = ($day_number* $kind_price['price'])*((100-$checkPotentials['discount'])/100);
                }
            }else{
                $price = $day_number* $kind_price['price'];
            }
            productAddDB::createPayment($last_id,$tenant_id,$kind_id,$day_number,$price,$status,$start_status,$status_expires);
            $result = productDB::getPrice($price);
            if ($checkTenant['grade_id'] != $checkPotentials['grade_id']){
                $rank = 'Bạn là khách thường chưa được giảm giá';
            }else{
                $rank = 'Bạn là khách hàng hạng '.$checkPotentials['name'].' được giảm giá '.$checkPotentials['discount'].'%';

            }
        }
        echo json_encode(array(
            'rank'=>$rank,
            'success' => 'Đã tạo thành công - Hãy thanh toán : '.$result.' Để admin có thể duyệt bài',
            'last_id' => $last_id,
            'apartment' => 'thêm bài viết ok'
        ));
    }
}