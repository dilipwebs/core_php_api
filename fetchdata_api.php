<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods:GET,POST,OPTIONS');
header('Access-Control-Allow-Headers:*');
header('Content-type:application/json');

require('config/database.php');
$query      = "SELECT * FROM users";
$result     = mysqli_query($conn,$query);
$count_rows = mysqli_num_rows($result);

$records_array = array();
if($count_rows > 0){
 
    while($row = mysqli_fetch_array($result)){
       $records = array(
                        "id"=>$row['id'],
                        "name"=>$row['name'],
                        "email"=>$row['email'],
                        "phone"=>$row['phone'],
                    );

               array_push($records_array,$records);
    }
    
    $data = ['msg'=>'Records fetched successfully', 'data'=>$records_array,'status'=>200];
}else{
    $data = ['msg'=>'Error: No Record Found','status'=>400];
}

echo json_encode($data);