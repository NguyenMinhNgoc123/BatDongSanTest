<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: DELETE');

include('../../../config/database.php');
include('../../../model/tenant/tenant_model.php');
include('../../../model/check_exist/exist_model.php');
include('../../../model/admin/data-admin.php');
include('../../../model/admin/admin_model.php');

include ('../check_token_admin.php');

$tenant_id = isset($_GET['id']) ? $_GET['id'] : die();

$list = dataDB::getListTenant($tenant_id);

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if (empty($tenant_id)) {
    echo json_encode(array('errors' => 'id không hợp lệ'));
} else if ($list > 0){
    dataDB::deleteAccountPayment($tenant_id);
    dataDB::deleteAccountNotify($tenant_id);
    $checkTenant = dataDB::getCheckTenant($tenant_id);
    dataDB::DeleteImage($checkTenant['property_id']);
    dataDB::deleteProductTenant($checkTenant['property_id']);
    dataDB::deleteSession($tenant_id);
    dataDB::deleteTenant($tenant_id);
    echo json_encode(array('success' => 'Xóa tài khoản thành công'));
}else {
    echo json_encode(array('errors' => 'id hoặc token không hợp lệ'));
}
