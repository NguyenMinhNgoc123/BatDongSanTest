<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');

include('../../../config/database.php');
include('../../../model/tenant/tenant_model.php');
include('../../../model/check_exist/exist_model.php');
include('../../../model/admin/data-admin.php');
include('../../../model/admin/admin_model.php');
include ('../../../model/data-index/public_model.php');
include ('../check_token_admin.php');

date_default_timezone_set('Asia/Ho_Chi_Minh');

$property_id = isset($_GET['id']) ? $_GET['id'] : die();
$note='0';
$list = dataDB::getListCheck($property_id,$note);
if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if (empty($property_id)) {
    echo json_encode(array('errors' => 'id không hợp lệ'));
} else if ($list > 0){
    $note ='1';
    $update_note = date('Y/m/d H:i:s');;
    dataDB::confirmProduct($property_id,$note,$update_note);
    $selectPayment = dataDB::selectPayment($property_id);
    $status = 'paid';
    $start_date = date('Y/m/d H:i:s');
    $end_date = date('Y/m/d H:i:s',strtotime('+ '.$selectPayment['day_number'].'days'));
    dataDB::confirmPayment($property_id,$status,$start_date,$end_date,'0000-00-00 00:00:00','0000-00-00 00:00:00');

    $pr = productDB::getProductDetails($property_id);
    $checkPotential = dataDB::checkPotential($pr['tenant_id']);
    if ($pr['kind_id'] == 3){
        if ($checkPotential > 0 ){
            dataDB::updatePotential($pr['tenant_id'],$checkPotential['quantities'] + 1);
        }else{
            dataDB::insertPotential($pr['tenant_id'],$pr['kind_id'],1);
        }
    }
    echo json_encode(array('success' => 'Duyệt thành công'));
}else {
    echo json_encode(array('errors' => 'id hoặc token không hợp lệ'));
}
