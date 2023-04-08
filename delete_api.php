<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods:DELETE');
header('Access-Control-Allow-Headers:*');
header('Content-type:application/json');

if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $conn       =   mysqli_connect('localhost','root','','api_dev') or die('mysqli not connected');

    // update api url = https://www.example.com/api/update_data.php/1

    $id = trim($_SERVER['PATH_INFO'],'/');

    $query      = "SELECT id FROM users WHERE id = '".$id."'";
    $result     = mysqli_query($conn,$query);
    $count_rows = mysqli_num_rows($result);

    $records_array = array();

    if($count_rows > 0){

        $update_query = "DELETE FROM users WHERE id = $id";
        $result = mysqli_query($conn, $update_query);

        if($result){

            $data = ['msg'=>'Records deleted successfully', 'status'=>200];
        }else{
            $data = ['msg'=>'Records could not updated', 'status'=>400];
        }

    }else{
        $data = ['msg'=>'Error: No Record Found','status'=>400];
    }
}else{
    $data = ['msg'=>'Error: unknown request','status'=>400];
}
echo json_encode($data);