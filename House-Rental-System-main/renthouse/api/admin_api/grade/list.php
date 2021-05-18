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

$data=[];
$data['list'] = [];

if (empty($token)) {
    echo json_encode(array('errors' => 'Bạn cần phải đăng nhập'));
} else if (empty($checkTokenAdmin)) {
    echo json_encode(array('errors' => 'Token không hợp lệ'));
}else{
    $grade =dataDB::getGrade();

    foreach ($grade as $key => $value){
        $data_grade = array(
            'grade_id'=>$value['grade_id'],
            'name'=>$value['name'],
            'discount'=>$value['discount'].' %',
            'create_at'=>$value['create_at'],
            'update_at'=>$value['update_at'],
        );
        array_push($data['list'], $data_grade);
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}