<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/admin/admin_model.php');
include('../../../model/data-index/public_model.php');
include ('../../../model/admin/data-admin.php');
include ('../../../model/tenant/tenant_model.php');

include ('../check_token_admin.php');

$data = [];
$data['list'] = [];

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
}else {
    $note = '0';
    $list_user= dataDB::getListUser();

    foreach ($list_user as $key => $value) {

        $data_product = array(
            'tenant_id' => $value['tenant_id'],
            'full_name' => $value['full_name'],
            'email'=>$value['email'],
            'password'=>$value['password'],
            'phone_no'=>$value['phone_no'],
            'sex'=>$value['sex'],
        );
        array_push($data['list'], $data_product);

    }
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}

//'caption' => $detail['caption'],
//        'ptypeName' => $ptypeName['ptypeName'],
//

//        'tfhouseName' => $post_type_name_value,



