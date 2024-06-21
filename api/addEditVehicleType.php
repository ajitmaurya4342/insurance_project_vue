<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["vehicle_type"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$current_date=date('Y-m-d H:i:s');
$vehicle_type=$data->vehicle_type;

$table_name="ms_vehicle";
$whereCheck="";
$whereCheck = " (vehicle_type='".$vehicle_type."')";
if (isset($data->vehicle_id) && $data->vehicle_id) {
 $whereCheck =$whereCheck. " and vehicle_id!='".$data->vehicle_id."'";
}

$checkExist=getQuery($conn,$table_name,["vehicle_id"],$whereCheck);

if(count($checkExist)>0){
    $data=[
        "status"=>false,
        "message"=>"Vehicle Type Already Exists",
    ];
    echo json_encode($data);
    exit;
}

$dataArray = [
    "vehicle_type" => mysqli_real_escape_string($conn,$vehicle_type),
];

$msg="Record Inserted Successfully";

if (isset($data->vehicle_id) && $data->vehicle_id) {
    $where = "vehicle_id='" . $data->vehicle_id . "'";
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