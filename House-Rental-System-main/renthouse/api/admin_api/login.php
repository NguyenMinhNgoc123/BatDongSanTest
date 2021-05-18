<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include('../../model/admin/admin_model.php');
include('../../model/check_exist/exist_model.php');
include('../../model/data-index/public_model.php');

$data = json_decode(file_get_contents("php://input"));

$email = $data->email_ad;
$password = $data->password_ad;

$password = md5($password);
$userSession=[];
if (!empty($email) && !empty($password)){
    $check_login = AdminDB::getLogin($email,$password);
    if ($check_login > 0){
        $checkTokenLogin = AdminDB::checkTokenAdmin($check_login['admin_id']);
        if (empty($checkTokenLogin)){
            $token =md5(random_bytes(40));
            $admin_id = $check_login['admin_id'];
            AdminDB::getCreateToken($token,$admin_id);
            $userSession = array(
                'token'=>$token,
                'admin_id'=>$admin_id
            );
        }else{
            $userSession = array(
                'token'=>$checkTokenLogin['token'],
                'admin_id'=>$checkTokenLogin['admin_id'],
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