<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../config/database.php');
include('../../model/tenant/tenant_model.php');
include('../../model/check_exist/exist_model.php');


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
