<?php
$headers = apache_request_headers();
$token = $headers['token'];
$checkToken = Check_existDB::checkToken($token);