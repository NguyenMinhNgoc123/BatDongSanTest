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
    $payment = dataDB::getPayment();

    foreach ($payment as $key => $value) {
        $unlink = dataDB::getImg($value['property_id']);
        if ($value['status'] == 'unpaid') {
            $time_expires = dataDB::getTimeExpires($value['status_expires']);

            if ($time_expires == 0) {
                if ($unlink > 0) {
//                $comment = 'Sản phẩm có mã là ' . $value['property_id'] . ' hết hạn đã bị xóa do không thanh toán';
                    $type = '1';
                    $note = '0';
                    foreach ($unlink as $key1 => $value1) {
                        //print_r('../../'.$value['p_photo']);
                        if (is_file('../../' . $value1['p_photo'])) {
                            unlink('../../' . $value1['p_photo']);
                        }
                    }
                    $end_date = date('Y/m/d H:i:s', strtotime('+ 3 days'));
                    dataDB::deleteNotifyNotType($value['property_id']);
//                dataDB::insertNotify($value['tenant_id'], $value['property_id'], $comment, $type);
                    dataDB::DeleteImage($value['property_id']);
                    dataDB::DeletePayment($value['property_id']);
                    dataDB::deleteProduct($value['property_id'], $note = '0');
                    dataDB::deleteProduct($value['property_id'], $note = '2');
                }
            } else {
                $comment = 'Sản phẩm có mã là ' . $value['property_id'] . ' Còn ' . $time_expires . '. Hãy thanh toán để bài viết được duyệt nhé!';
                $type = '2';
                $checkNotify = AdminDB::checkNotify($value['tenant_id'], $value['property_id'], $type);
                if ($checkNotify > 0) {
                    dataDB::updateNotify($value['tenant_id'], $value['property_id'], $comment, $type);
                } else {
                    dataDB::insertNotify($value['tenant_id'], $value['property_id'], $comment, $type);
                }
            }
        } else {
            if ($value['status'] == 'paid') {
                $time_expires_paid = dataDB::getTimeExpiresPaid($value['end_date']);
//            print_r($time_expires_paid);die();
                if ($time_expires_paid == 0) {
                    $comment = 'Sản phẩm có mã là ' . $value['property_id'] . ' đã hết hạn bạn có muốn tiếp tục ?';
                    $note = '2';
                    $status = 'unpaid';
                    $type = '3';
                    $start_status = date('Y/m/d H:i:s');
                    $status_expires = date('Y/m/d H:i:s', strtotime('+ 3 days'));
                    $start_date = '0000-00-00 00:00:00';
                    $end_date = '0000-00-00 00:00:00';

                    dataDB::deleteNotifyy($value['property_id'],'4');
                    dataDB::updateExpiresProduct($value['property_id'], $note);
                    dataDB::updateExpires($value['property_id'], $status, $start_date, $end_date, $start_status, $status_expires);
                    dataDB::insertNotify($value['tenant_id'], $value['property_id'], $comment, $type);
                } else {
                    $comment = 'Sản phẩm có mã là ' . $value['property_id'] . ' Còn ' . $time_expires_paid;
                    $type = '4';
                    $checkNotify = AdminDB::checkNotify($value['tenant_id'], $value['property_id'], $type);
                    if ($checkNotify > 0) {
                        dataDB::updateNotify($value['tenant_id'], $value['property_id'], $comment, $type);
                    } else {
                        dataDB::deleteNotifyy($value['property_id'],'2');
                        dataDB::insertNotify($value['tenant_id'], $value['property_id'], $comment, $type);
                    }
                }
            }
        }
    }

    echo json_encode(array('success' => 'Duyệt thành công'));
}else {
    echo json_encode(array('errors' => 'id hoặc token không hợp lệ'));
}


$payment = dataDB::getPayment();

foreach ($payment as $key => $value) {
    $unlink = dataDB::getImg($value['property_id']);
    if ($value['status'] == 'unpaid') {
        $time_expires = dataDB::getTimeExpires($value['status_expires']);

        if ($time_expires == 0) {
            if ($unlink > 0) {
//                $comment = 'Sản phẩm có mã là ' . $value['property_id'] . ' hết hạn đã bị xóa do không thanh toán';
                $type = '1';
                $note = '0';
                foreach ($unlink as $key1 => $value1) {
                    //print_r('../../'.$value['p_photo']);
                    if (is_file('../../' . $value1['p_photo'])) {
                        unlink('../../' . $value1['p_photo']);
                    }
                }
                $end_date = date('Y/m/d H:i:s', strtotime('+ 3 days'));
                dataDB::deleteNotifyNotType($value['property_id']);
//                dataDB::insertNotify($value['tenant_id'], $value['property_id'], $comment, $type);
                dataDB::DeleteImage($value['property_id']);
                dataDB::DeletePayment($value['property_id']);
                dataDB::deleteProduct($value['property_id'], $note = '0');
                dataDB::deleteProduct($value['property_id'], $note = '2');
            }
        } else {
            $comment = 'Sản phẩm có mã là ' . $value['property_id'] . ' Còn ' . $time_expires . '. Hãy thanh toán để bài viết được duyệt nhé!';
            $type = '2';
            $checkNotify = AdminDB::checkNotify($value['tenant_id'], $value['property_id'], $type);
            if ($checkNotify > 0) {
                dataDB::updateNotify($value['tenant_id'], $value['property_id'], $comment, $type);
            } else {
                dataDB::insertNotify($value['tenant_id'], $value['property_id'], $comment, $type);
            }
        }
    } else {
        if ($value['status'] == 'paid') {
            $time_expires_paid = dataDB::getTimeExpiresPaid($value['end_date']);
//            print_r($time_expires_paid);die();
            if ($time_expires_paid == 0) {
                $comment = 'Sản phẩm có mã là ' . $value['property_id'] . ' đã hết hạn bạn có muốn tiếp tục ?';
                $note = '2';
                $status = 'unpaid';
                $type = '3';
                $start_status = date('Y/m/d H:i:s');
                $status_expires = date('Y/m/d H:i:s', strtotime('+ 3 days'));
                $start_date = '0000-00-00 00:00:00';
                $end_date = '0000-00-00 00:00:00';

                dataDB::deleteNotifyy($value['property_id'],'4');
                dataDB::updateExpiresProduct($value['property_id'], $note);
                dataDB::updateExpires($value['property_id'], $status, $start_date, $end_date, $start_status, $status_expires);
                dataDB::insertNotify($value['tenant_id'], $value['property_id'], $comment, $type);
            } else {
                $comment = 'Sản phẩm có mã là ' . $value['property_id'] . ' Còn ' . $time_expires_paid;
                $type = '4';
                $checkNotify = AdminDB::checkNotify($value['tenant_id'], $value['property_id'], $type);
                if ($checkNotify > 0) {
                    dataDB::updateNotify($value['tenant_id'], $value['property_id'], $comment, $type);
                } else {
                    dataDB::deleteNotifyy($value['property_id'],'2');
                    dataDB::insertNotify($value['tenant_id'], $value['property_id'], $comment, $type);
                }
            }
        }
    }
}
