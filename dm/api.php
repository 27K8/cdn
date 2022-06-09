<?php
error_reporting(0);
//跨域
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: x-requested-with,content-type');
header('Access-Control-Allow-Methods: GET, POST');

include ('data.php');
    $json = [
       'code' => 200,
       'data' => $lele
    ];
die(json_encode($json));
?>