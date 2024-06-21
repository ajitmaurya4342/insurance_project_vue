<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["pm_name"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$current_date=date('Y-m-d H:i:s');
$pm_name=$data->pm_name;

$table_name="ms_payment_mode";
$whereCheck="";
$whereCheck = " (pm_name='".$pm_name."')";
if (isset($data->pm_id) && $data->pm_id) {
 $whereCheck =$whereCheck. " and pm_id!='".$data->pm_id."'";
}

$checkExist=getQuery($conn,$table_name,["pm_id"],$whereCheck);

if(count($checkExist)>0){
    $data=[
        "status"=>false,
        "message"=>"Payment Name Already Exists",
    ];
    echo json_encode($data);
    exit;
}

$dataArray = [
    "pm_name" => mysqli_real_escape_string($conn,$pm_name),
];

$msg="Record Inserted Successfully";

if (isset($data->pm_id) && $data->pm_id) {
    $where = "pm_id='" . $data->pm_id . "'";
    $dataArray["updated_at"] = $current_date;
    $updateQuery=updateQuery($table_name, $dataArray, $where, $conn);
    $msg="Record Updated Successfully";
} else {
    $dataArray["created_at"] = $current_date;
    $insert_id = insertQuery($table_name, $dataArray, $conn);
}

$data=[
    "status"=>true,
    "message"=>$msg,
];

echo json_encode($data);

?>