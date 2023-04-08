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

$name   = $data['name'];
$email  = $data['email'];
$phone  = $data['phone'];
$city   = $data['city'];

$query = "INSERT INTO users(name,email,phone,city) VALUES('".$name."','".$email."','".$phone."','".$city."')";

$result = mysqli_query($conn,$query);

if($result){
    $data = ['msg'=>'Record inserted successfully','status'=>200];
}else{
    $data = ['msg'=>'Error: Record not inserted','status'=>400];
}

echo json_encode($data);