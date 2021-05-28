<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/admin/admin_model.php');
include('../../../model/data-index/public_model.php');
include('../../../model/check_exist/exist_model.php');
include('../../../model/admin/data-admin.php');

include('../check_token_admin.php');

$id = isset($_GET['id']) ? $_GET['id'] : die();

$data = json_decode(file_get_contents("php://input"));

$feedback = $data->feedback;

$checkFeedback = dataDB::EnquiryCheck($id);
if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if (empty($feedback)) {
    echo json_encode(array('errors' => 'không được để trống'));
} else if ($checkFeedback == 0) {
    echo json_encode(array('errors' => 'id không tồn tại'));
} else {
    $status = '1';
    $update = dataDB::updateEnquiry($id, $feedback, $status);

    $subject = "HomeRent.com";
    $message = $feedback;
    $sender = "From: HomeRent@gmail.com";
    if (mail($checkFeedback['email'], $subject, $message, $sender)) {
        $info = "phản hồi đến mail thành công";

        echo json_encode(array(
            'success' => $info,
        ));
    }


}