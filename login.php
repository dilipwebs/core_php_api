<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods:GET,POST,OPTIONS');
header('Access-Control-Allow-Headers:*');
header('Content-type:application/json');

require('config/database.php');

include 'vendor/autoload.php';

use Firebase\JWT\JWT;

$data   =   json_decode(file_get_contents("php://input"),true);

$query      = "SELECT * FROM users WHERE email = '".$data['email']."'";
$result     = mysqli_query($conn,$query);
$count_rows = mysqli_num_rows($result);

$records_array = array();

if($count_rows > 0){

    $row    = mysqli_fetch_array($result);
    $payload = array(
                        "id"    =>  $row['id'],
                        "name"  =>  $row['name'],
                        "email" =>  $row['email'],
                        "phone" =>  $row['phone'],
                    );

    $verify = password_verify($data['password'], $row['password']);
    $key = 'example_123';

    if($verify){
       $jwt = JWT::encode($payload,$key,'HS256');
       
       $userData['id'] = $row['id'];
       $userData['name'] = $row['name'];
       $userData['email'] = $row['email'];
       $userData['jwt'] = $jwt;
    
       $data = ['msg'=>'Login successfully', 'data'=>$userData,'status'=>200];

    }else{
        $data = ['msg'=>'Invalid login', 'status'=>400, 'data'=>null];
    }

    
   
   
    
   
}else{
    $data = ['msg'=>'Error: No Record Found','status'=>400];
}

echo json_encode($data);