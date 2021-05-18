<?php


define('APP_ID','461563511716856');
define('APP_SECRET','a0849ac7a5620e25a1673654d5666810');
define('API_VERSION','v10.0');
define('FB_BASE_URL','http://localhost/BatDongSanTest/House-Rental-System-main/renthouse/');

require_once (__DIR__ . '/vendor/autoload.php');

$fb = new Facebook\Facebook([
    'app_id' =>APP_ID,
    'app_secret'=> APP_SECRET,
    'default_graph_version' => API_VERSION,
]);
$fb_helper= $fb->getRedirectLoginHelper();

try {
    if (isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
        $accessToken = $fb_helper->getAccessToken();
    }
}catch (\Facebook\Exceptions\FacebookResponseException $exception){
    echo 'Facebook API Error: ' . $exception->getMessage();
    exit();
}
catch (\Facebook\Exceptions\FacebookSDKException $exception){
    echo 'Facebook SDK Error: '. $exception->getMessage();
    exit();
}