<?php
$headers = apache_request_headers();
$token = $headers['token_admin'];
$checkTokenAdmin = AdminDB::checkToken($token);