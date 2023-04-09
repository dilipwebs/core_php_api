<?php
require('config/api_headers.php');
// echo "<pre>";
// print_r($_SERVER);die;

require('config/database.php');

include 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$headers = getallheaders();
$auth_code = trim($headers['Authorization']);
$token = substr($auth_code,7);
$key = 'example_123';

try {
    $decoded = JWT::decode($token, new Key($key, 'HS256'));
    $data = ['msg'=>'Access allowed ', 'data'=>$decoded,'status'=>200];
} catch (\Throwable $th) {
    $data = ['msg'=>'Access denied', 'data'=>$th->getMessage(),'status'=>400];
}

echo json_encode($data);