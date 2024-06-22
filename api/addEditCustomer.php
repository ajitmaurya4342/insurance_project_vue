<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["vehicle_no","cust_name"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$current_date=date('Y-m-d H:i:s');
$vehicle_no=$data->vehicle_no;
$cust_name=$data->cust_name;
$cust_phone=$data->cust_phone;
$cust_address=$data->cust_address;

$table_name="ms_customer";
$whereCheck="";
$whereCheck = " (vehicle_no='".$vehicle_no."')";
if (isset($data->cust_id) && $data->cust_id) {
 $whereCheck =$whereCheck. " and cust_id!='".$data->cust_id."'";
}

$checkExist=getQuery($conn,$table_name,["cust_id"],$whereCheck);

if(count($checkExist)>0){
    $data=[
        "status"=>false,
        "message"=>"Vehicle No Already Exists",
    ];
    echo json_encode($data);
    exit;
}

$dataArray = [
    "vehicle_no" => mysqli_real_escape_string($conn,$vehicle_no),
    "cust_name" => mysqli_real_escape_string($conn,$cust_name),
    "cust_phone" => mysqli_real_escape_string($conn,$cust_phone),
    "cust_address" => mysqli_real_escape_string($conn,$cust_address),
];

$msg="Record Inserted Successfully";

if (isset($data->cust_id) && $data->cust_id) {
    $where = "cust_id='" . $data->cust_id . "'";
    $dataArray["updated_at"] = $current_date;
    $dataArray["updated_by"] = $created_user_id;
    $updateQuery=updateQuery($table_name, $dataArray, $where, $conn);
    $msg="Record Updated Successfully";
} else {
    $dataArray["created_at"] = $current_date;
    $dataArray["created_by"] = $created_user_id;
    $insert_id = insertQuery($table_name, $dataArray, $conn);
}

$data=[
    "status"=>true,
    "message"=>$msg,
];

echo json_encode($data);

?>