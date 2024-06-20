<?php

include("connection.php");
$data = json_decode(file_get_contents("php://input"));
$data_check=["user_name","password"];
$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
  echo json_encode($resultError);
  exit;
}

$table_name="users";
$column=["username","name","user_id","mobile_number","user_type"];

$username=$data->user_name;
$password=$data->password;


$where=" username='".$username."' and password='".$password."'";

$status=false;

$getQueryData=getQuery($conn,$table_name,$column,$where);
$token="";
if(count($getQueryData)>0){
    $msg="Login Successfully";
    $status=true;
    $token=base64_encode($getQueryData[0]["user_id"]."=".$getQueryData[0]["username"]."=access_token_created");
}else{
    $msg="Invalid Credential";
}

$data=[
    "status"=>$status,
    "message"=>$msg,
    "Records"=>$getQueryData,
    "access_token"=>$token
    
];

echo json_encode($data);

?>