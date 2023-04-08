<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods:PUT');
header('Access-Control-Allow-Headers:*');
header('Content-type:application/json');


$conn       =   mysqli_connect('localhost','root','','api_dev') or die('mysqli not connected');

// update api url = https://www.example.com/api/update_data.php/1

$id = trim($_SERVER['PATH_INFO'],'/');

$query      = "SELECT id FROM users WHERE id = '".$id."'";
$result     = mysqli_query($conn,$query);
$count_rows = mysqli_num_rows($result);

$records_array = array();

if($count_rows > 0){

    $set        = "";
    $data       = json_decode(file_get_contents("php://input"),true);
    $data_count = count($data);
    $i = 1;
    foreach ($data as $key => $value) {
        $set .= $key."='".$value."'";

        if ($i < $data_count) {
            $set .= ", ";
        }
        $i++;
    }

    $update_query = "UPDATE users SET $set WHERE id = $id";
    $result = mysqli_query($conn, $update_query);

    if($result){

        $data = ['msg'=>'Records updated successfully', 'status'=>200];
    }else{
        $data = ['msg'=>'Records could not updated', 'status'=>400];
    }

}else{
    $data = ['msg'=>'Error: No Record Found','status'=>400];
}

echo json_encode($data);