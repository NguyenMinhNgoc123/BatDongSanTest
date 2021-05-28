<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/tenant/tenant_model.php');
include('../../../model/admin/data-admin.php');
include('../../../model/admin/admin_model.php');

include ('../check_token_admin.php');

$property_id = isset($_GET['id']) ? $_GET['id'] : die();
$note='0';
$list = dataDB::getListCheck($property_id,$note);
$unlink = tenantDB::ListImage($property_id);
if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if (empty($property_id)) {
    echo json_encode(array('errors' => 'id không hợp lệ'));
} else if ($list > 0){
    if ($unlink > 0){
        foreach ($unlink as $key => $value){
            //print_r('../../'.$value['p_photo']);
            if (is_file('../../../'.$value['p_photo'])){
                unlink('../../../'.$value['p_photo']);
            }
        }
    }
    $note ='0';
    dataDB::DeletePayment($property_id);
    dataDB::deleteNotifyNotType($property_id);
    dataDB::DeleteImage($property_id);
    dataDB::deleteProduct($property_id,$note);
    echo json_encode(array('success' => 'Xóa thành công'));
}else {
    echo json_encode(array('errors' => 'id hoặc token không hợp lệ'));
}
