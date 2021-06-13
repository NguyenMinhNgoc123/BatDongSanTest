<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include('../../model/tenant/tenant_model.php');
include('../../model/check_exist/exist_model.php');
include('../../model/admin/admin_model.php');
include('../../model/admin/data-admin.php');

date_default_timezone_set('Asia/Ho_Chi_Minh');

//$tenant_id = $checkToken['tenant_id'];
//    print_r($tenant_id);die();
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
//xử lý notify property_id không tồn tại
$notify_property_id = dataDB::getNotify();
foreach ($notify_property_id as $key1 => $value1){
    $check = Check_existDB::checkProperty($value1['property_id']);
    $time= strtotime(date('Y/m/d H:i:s'));
    $create_at_notify = strtotime($value1['create_at'].'+ 3 days');
    if ($check == 0 && $create_at_notify < $time){
        dataDB::deleteNotifyNotType($value1['property_id']);
    }
}
//xử lý xếp hạng tenant
$checkTenant = dataDB::getListUser();
foreach ($checkTenant as $key2 => $value2){
    $checkPotential = Check_existDB::checkPotential($value2['tenant_id']);
    if ($checkPotential > 0){
        $quantities =$checkPotential['quantities'];
        foreach (dataDB::getGrade() as $key3 =>$value3){
            if ($value3['quantities'] == $quantities){
                $grade_id =$value3['grade_id'];
                dataDB::updateTenantGrade($value2['tenant_id'],$grade_id);
            }else{
                if ($value3['quantities'] < $quantities){
                    $grade_id =$value3['grade_id'];
                    dataDB::updateTenantGrade($value2['tenant_id'],$grade_id);
                }
            }

        }
    }
}
// xử lý lỗi add property không có trong payment
$checkAddProperty = dataDB::getProducts();
foreach ($checkAddProperty as $key3 => $value3){
    $unlink = dataDB::getImg($value3['property_id']);
    $property_payment=dataDB::selectPayment($value3['property_id']);
    if ($property_payment == 0){
        if ($unlink > 0) {
            $type = '1';
            $note = '0';
            foreach ($unlink as $key1 => $value1) {
                //print_r('../../'.$value['p_photo']);
                if (is_file('../../' . $value1['p_photo'])) {
                    unlink('../../' . $value1['p_photo']);
                }
            }
            tenantDB::DeleteImage($value3['property_id']);
            dataDB::deleteProduct($value3['property_id'],0);
        }
    }
}
//-------------------------------------------------------------------------
$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;

$password = md5($password);
$userSession=[];
if (!empty($email) && !empty($password)){
    $check_login = tenantDB::getLogin($email,$password);
    if ($check_login > 0){
        $checkTokenLogin = Check_existDB::checkTokenTenant($check_login['tenant_id']);
        if (empty($checkTokenLogin)){
            $token =md5(random_bytes(40));
            $fresh_token =md5(random_bytes(40));
            $token_expired = date('Y-m-d H:i:s', strtotime('+30 day'));
            $fresh_token_expired =date('Y-m-d H:i:s', strtotime('+365 day'));
            $tenant_id= $check_login['tenant_id'];
            tenantDB::getCreateToken($token,$fresh_token,$token_expired,$fresh_token_expired,$tenant_id);
            $userSession = array(
                'token'=>$token,
                'fresh_token'=>$fresh_token,
                'token_expired'=>$token_expired,
                'fresh_token_expired'=>$fresh_token_expired,
                'tenant_id'=>$tenant_id,
            );
        }else{
            $userSession = array(
                'token'=>$checkTokenLogin['token'],
                'fresh_token'=>$checkTokenLogin['fresh_token'],
                'token_expired'=>$checkTokenLogin['token_expired'],
                'fresh_token_expired'=>$checkTokenLogin['fresh_token_expired'],
                'tenant_id'=>$checkTokenLogin['tenant_id'],
            );;
        }
        //echo json_encode(array('success' =>'Đăng nhập thành công' ));
        echo json_encode(array(
            'success' =>'Đăng nhập thành công' ,
            'code'=> 200,
            'data'=>$userSession
        ));
    }else{
        echo json_encode(array('errors' => 'Mật khẩu tài khoản không đúng'));
    }
}else{
    echo json_encode(array('errors' => 'Không được để trống'));
}
