<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include('../../model/tenant/tenant_model.php');
include('../../model/check_exist/exist_model.php');

$data = json_decode(file_get_contents("php://input"));

$tenant_id = $data->tenant_id;
$full_name = $data->full_name;
$email = $data->email;
$password = $data->password;
$confirm_password =$data->confirm_password;
$phone_no = $data->phone_no;
$sex = $data->sex;


$status = 'notverified';
$check_email =Check_existDB::checkEmail($email);
$check_phone = Check_existDB::checkPhone($phone_no);
if (empty($full_name)){
    echo json_encode(array('errors'=>'Không được để trống tên'));
}else if (empty($email) || empty($phone_no)){
    echo json_encode(array('errors'=>'Không được để trống email và số điện thoại'));
}else if (empty($password) || empty($confirm_password)){
    echo json_encode(array('errors'=>'Không được để trống password và confirm password'));
} else if (strlen($password) < 6 || strlen($confirm_password) > 20) {
    echo json_encode(array('errors'=>'Mật khẩu quá ngắn hoặc quá dài'));
}else if ($password != $confirm_password){
    echo json_encode(array('errors'=>'Mật khẩu không khớp'));
} else if ($check_email > 0) {
    echo json_encode(array('errors' => 'Email đã tồn tại'));
} else if (strlen($phone_no) != 10 ) {
    echo json_encode(array('errors' => 'Bạn nhập không đúng 10 số'));
} else if (is_numeric($phone_no) === false){
    echo json_encode(array('errors' => 'Bạn nhập không đúng định dạng số điện thoại'));
}else if ($check_phone > 0) {
    echo json_encode(array('errors' => 'phone đã tồn tại'));
} else {
    $password = md5($password);
//    $image_dir_path = getcwd() . '/tenant-photo';
//    $id_photo = filter_input(INPUT_POST, 'id_photo');
//    $file = $_FILES['id_photo'];
//    $filename = $file['tmp_name'];//lấy tên của ảnh
//    $name_img = uniqid() . '.jpg';
//    $path = '../../tenant-photo/' .$name_img;
//    $where= 'tenant-photo/' . $name_img;
//
//    $image = file_get_contents($filename);
//    $image = imagecreatefromstring($image);

//    if ($image) {
//        imagejpeg($image, $path);
//        imagedestroy($image);
//        $id_photo = $where;

        tenantDB::addTenantID($tenant_id,$full_name,$email,$password,$phone_no,$sex,$status);
        echo json_encode(array('success' => 'Đăng ký thành công'));
//    } else {
//        echo json_encode(array('errors' => 'Đăng ký không thành công'));
//
//    }
}










