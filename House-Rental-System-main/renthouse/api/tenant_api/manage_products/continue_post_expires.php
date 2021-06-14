<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

date_default_timezone_set('Asia/Ho_Chi_Minh');

include('../../../config/database.php');
include('../../../model/tenant/tenant_model.php');
include('../../../model/check_exist/exist_model.php');
include('../../../model/admin/data-admin.php');
include('../../../model/admin/admin_model.php');

include('../check_token.php');

$property_id = isset($_GET['id']) ? $_GET['id'] : die();

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if (empty($property_id)) {
    echo json_encode(array('errors' => 'id không hợp lệ'));
} else {
    $note = '2';
    $check = Check_existDB::checkPropertyNote2($property_id, $checkToken['tenant_id'], $note);


    if ($check > 0) {
        $note = '0';
        $update_note = date('Y/m/d H:i:s');
        tenantDB::continueProduct($property_id, $note, $update_note);
        tenantDB::DeleteNotify($property_id, $checkToken['tenant_id']);
        $status_expires = date('Y/m/d H:i:s', strtotime('+ 3 days'));
        $start_status = date('Y/m/d H:i:s');
        $start_date = '0000-00-00 00:00:00';
        $end_date = '0000-00-00 00:00:00';
        $status = 'unpaid';
        dataDB::updateExpires($property_id, $status, $start_date, $end_date, $start_status, $status_expires);


        $time_expires = dataDB::getTimeExpires($status_expires);


        $comment = 'Sản phẩm có mã là ' . $property_id . ' Còn ' . $time_expires . '. Bài viết sẽ tự động xóa sau 3 ngày!';
        $type = '2';
        dataDB::insertNotify($checkToken['tenant_id'], $property_id, $comment, $type);

        echo json_encode(array('success' => 'Gia hạn thành công .Hãy thanh toán để được duyệt bài'));
    } else {
        echo json_encode(array('success' => 'bài viết chưa hết hạn hoặc id không tồn tại'));
    }
}