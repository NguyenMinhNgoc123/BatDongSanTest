<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include('../../model/tenant/tenant_model.php');
include('../../model/check_exist/exist_model.php');

include ('check_token.php');

$data = json_decode(file_get_contents("php://input"));

$password = $data->password;
$new_password = $data->new_password;
$confirm_password = $data->confirm_password;

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if (strlen($new_password) < 7) {
    echo json_encode(array('errors' => 'Mật khẩu phải 8 kí tự trở lên'));
} else{
    $tenant_id =$checkToken['tenant_id'];
    $checkTenant = Check_existDB::checkTenant($tenant_id);
    if ($checkTenant['password']== null){
        if ($new_password != $confirm_password){
            echo json_encode(array('errors' => 'Mật khẩu mới không trùng nhau'));die();
        }else{
            $new_password =md5($new_password);
            tenantDB::changPassword($tenant_id,$new_password);
            echo json_encode(array('success' => 'Đổi mật khẩu thành công'));
        }
    }else{
        if (!empty($password)){
            $password = md5($password);
            $checkPass = Check_existDB::checkPassword($tenant_id,$password);
            if ($checkPass > 0){
                if ($new_password != $confirm_password){
                    echo json_encode(array('errors' => 'Mật khẩu mới không trùng nhau'));
                }else{
                    $new_password =md5($new_password);
                    tenantDB::changPassword($tenant_id,$new_password);
                    echo json_encode(array('success' => 'Đổi mật khẩu thành công'));
                }
            }else{
                echo json_encode(array('errors' => 'Mật khẩu cũ không khớp'));
            }
        }else{
            echo json_encode(array('errors' => 'Mật khẩu hiện tại bị trống'));
        }

    }
}