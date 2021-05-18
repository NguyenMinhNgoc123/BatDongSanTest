<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include('../../model/tenant/tenant_model.php');
include('../../model/check_exist/exist_model.php');

include ('check_token.php');

$full_name = filter_input(INPUT_POST, 'full_name');
$phone_no = filter_input(INPUT_POST, 'phone_no');
$address = filter_input(INPUT_POST, 'address');
$sex = filter_input(INPUT_POST, 'sex_id');
$id_photo = filter_input(INPUT_POST, 'id_photo');

$check_phone = Check_existDB::checkPhone($phone_no);
$profile = tenantDB::getProfile($checkToken['tenant_id']);
if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else {
    $tenant_id = $checkToken['tenant_id'];
    if (empty($full_name)) {
        $full_name = $profile['full_name'];
    }

    if (empty($phone_no)) {
        if ($profile['phone_no'] != '') {
            $phone_no = $profile['phone_no'];
        } else {
            echo json_encode(array('errors' => 'Vui lòng nhập số điện thoại'));
            die();
        }
    } else {
        if (strlen($phone_no) != 10) {
            echo json_encode(array('errors' => 'Bạn nhập không đúng 10 số'));
            die();
        } else {
            if ($phone_no == $profile['phone_no']) {
                $phone_no = $profile['phone_no'];
            } else {
                if ($check_phone > 0) {
                    echo json_encode(array('errors' => 'Số điện thoại đã tồn tại'));
                    die();
                }
            }
        }

    }

    if (empty($address)) {
        $address = $profile['address'];
    }

    if (empty($sex)) {
        $sex = $profile['sex_id'];
    }


    if (!isset($_FILES['id_photo'])) {
        $id_photo = $profile['id_photo'];
        tenantDB::Update($tenant_id, $full_name, $phone_no, $address, $id_photo, $sex);
        echo json_encode(array('success' => 'Cập nhật thành công'));
    } else {
        $image_dir_path = getcwd() . '/tenant-photo';

        $file = $_FILES['id_photo'];
        $filename = $file['tmp_name'];//lấy tên của ảnh
        $name_img = uniqid() . '.jpg';
        $path = '../../tenant-photo/' . $name_img;
        $where = 'tenant-photo/' . $name_img;

        $image = file_get_contents($filename);
        $image = imagecreatefromstring($image);
        if ($image) {
            imagejpeg($image, $path);
            imagedestroy($image);
            $id_photo = $where;
            tenantDB::Update($tenant_id, $full_name, $phone_no, $address, $id_photo, $sex);
            echo json_encode(array('success' => 'Cập nhật thành công'));
        } else {
            echo json_encode(array('errors' => 'Cập nhật không thành công'));

        }
    }

}