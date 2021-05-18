<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/tenant/tenant_model.php');
include('../../../model/check_exist/exist_model.php');

include ('../check_token.php');

$property_id = isset($_GET['id']) ? $_GET['id'] : die();

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if (empty($property_id)) {
    echo json_encode(array('errors' => 'id không hợp lệ'));
} else {
    $tenant_id = $checkToken['tenant_id'];
    $exist = Check_existDB::checkExistProducts($property_id, $tenant_id);
    $unlink = tenantDB::ListImage($property_id);
    if ($exist > 0) {
        if ($unlink > 0){
            foreach ($unlink as $key => $value){
                //print_r('../../'.$value['p_photo']);
                if (is_file('../../../'.$value['p_photo'])){
                    unlink('../../../'.$value['p_photo']);
                }
            }
        }
        $image = tenantDB::DeleteImage($property_id);
        if ($image > 0) {
            $products = tenantDB::DeleteProducts($property_id, $tenant_id);
            echo json_encode(array('success' => 'xóa thành công'));
        } else {
            echo json_encode(array('errors' => 'Sản phẩm không tồn tại'));
        }
    } else {
        echo json_encode(array('errors' => 'Sản phẩm không sở hữu của bạn'));
    }
}