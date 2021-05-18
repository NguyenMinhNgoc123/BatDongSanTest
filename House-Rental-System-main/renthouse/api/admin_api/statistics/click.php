<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET,DELETE,PUT,POST');
header('Content-type: application/json; charset=utf-8');

$file = "../bodem.log";
$act = fopen ($file, "r");
$dem = fread ($act, filesize ($file) );
fclose ($act);
$dem++;
$act = fopen ($file, "w");
fwrite ($act, $dem);
fclose ($act);
echo json_encode($dem);

?>
