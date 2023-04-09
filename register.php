<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods:GET,POST,OPTIONS');
header('Access-Control-Allow-Headers:*');
header('Content-type:application/json');

require('config/database.php');
$data   =   json_decode(file_get_contents("php://input"),true);

// $name   = $_POST['name'];
// $email  = $_POST['email'];
// $phone  = $_POST['phone'];
// $city   = $_POST['city'];



if($data){

    $name   = $data['name'];
    $email  = $data['email'];
    $password  = password_hash($data['password'], PASSWORD_BCRYPT);
    $phone  = $data['phone'];
    $city   = $data['city'];

    $query = "INSERT INTO users(name,email,password,phone,city) VALUES('".$name."','".$email."','".$password."','".$phone."','".$city."')";

    $result = mysqli_query($conn,$query);
    if($result){
        http_response_code(200);
        $data = ['msg'=>'Record inserted successfully'];
    }else{
        http_response_code(401);
        $data = ['msg'=>'Error: Record not inserted'];
    }
}else{
    http_response_code(401);
    $data = ['msg'=>'Error: Record not inserted'];
}

echo json_encode($data);