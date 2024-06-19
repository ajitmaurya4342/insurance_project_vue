<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["user_name","password","name","mobile_number"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)){
   echo json_encode($resultError);
   exit;
}

$dataArray = [
    "username" => mysqli_real_escape_string($conn,$data->user_name),
    "password" => mysqli_real_escape_string($conn,$data->password),
    "name" => mysqli_real_escape_string($conn,$data->name),
    "mobile_number" =>mysqli_real_escape_string($conn,$data->mobile_number) 
];

$msg="Record Inserted Successfully";

if (isset($data->user_id) && $data->user_id) {
    $where = "user_id='" . $data->user_id . "'";
    $updateQuery=updateQuery("users", $dataArray, $where, $conn);
    $msg="Record Updated Successfully";
} else {
    $dataArray["user_type"] = "user";
    $insert_id = insertQuery("users", $dataArray, $conn);
}

$data=[
    "status"=>true,
    "message"=>$msg,
];

echo json_encode($data);

?>