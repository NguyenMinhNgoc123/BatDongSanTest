<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Methods: GET,PUT,DELETE,OPTIONS');
header('Content-type: application/json; charset=utf-8');

include('../../../config/database.php');
include('../../../model/data-index/public_model.php');
include('../../../model/check_exist/exist_model.php');
include('../../../model/tenant/tenant_model.php');

include('../check_token.php');

$tenant_id = isset($_GET['id']) ? $_GET['id'] : die();
//$insert_chat = json_decode(file_get_contents("php://input"));

//$chat = $insert_chat->chat;

$data = [];
$data['chat'] = [];
$extra='';
$main='';
if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkToken)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
} else if ($checkToken['tenant_id'] == $tenant_id) {
    echo json_encode(array('errors' => 'Không thể chat với chính mình'));
} else {
    $check_messages = tenantDB::getChat($checkToken['tenant_id']);
    if ($check_messages > 0){
        $show_messages = tenantDB::getMessages($checkToken['tenant_id'],$tenant_id);

    }else{
        $show_messages = [];
    }

    foreach ($show_messages as $key => $value){
        $time = productDB::getTime($value['create_at']);
        if ($value['incoming_msg_id'] == $checkToken['tenant_id']){
            $main = $value['msg'];
            $data_chat_main = array(
                'main'=>$main,
                'time'=>$time
            );
        }else{
            if ($value['incoming_msg_id'] == $tenant_id){
                $extra = $value['msg'];
                $data_chat_main = array(
                    'extra'=>$extra,
                    'time'=>$time

                );
            }
        }
        array_push($data['chat'], $data_chat_main);
    }
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}

