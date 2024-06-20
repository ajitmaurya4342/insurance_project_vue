<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["username","password","name","mobile_number"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$username=$data->username;
$password=$data->password;
$name=$data->name;
$mobile_number=$data->mobile_number;

$table_name="users";
$whereCheck="";
$whereCheck = " (username = '".$username."' or mobile_number='".$mobile_number."')";
if (isset($data->user_id) && $data->user_id) {
 $whereCheck =$whereCheck. " and user_id!='".$data->user_id."'";
}

$checkExist=getQuery($conn,$table_name,["user_id"],$whereCheck);

if(count($checkExist)>0){
    $data=[
        "status"=>false,
        "message"=>"Username or MobileNumber Already Exists",
    ];
    echo json_encode($data);
    exit;
}

$dataArray = [
    "username" => mysqli_real_escape_string($conn,$username),
    "password" => mysqli_real_escape_string($conn,$password),
    "name" => mysqli_real_escape_string($conn,$name),
    "mobile_number" =>mysqli_real_escape_string($conn,$mobile_number) 
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