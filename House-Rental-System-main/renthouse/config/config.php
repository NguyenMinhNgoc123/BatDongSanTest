<?php
try {
    $dsn = 'mysql:host=localhost;dbname=renthouse1';
    $username = 'root';
    $pass = '852654';
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    $connect = new PDO($dsn, $username, $pass, $options);
} catch
(PDOException $exception) {
    $error_message = $exception->getMessage();
    echo 'error connection' . $error_message;
}


 ?>