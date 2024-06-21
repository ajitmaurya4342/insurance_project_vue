<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["agent_name","agent_mobile_number"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$current_date=date('Y-m-d H:i:s');
$agent_name=$data->agent_name;
$agent_mobile_number=$data->agent_mobile_number;
$agent_address=$data->agent_address;

$table_name="ms_agent";
$whereCheck="";
$whereCheck = " (agent_mobile_number='".$agent_mobile_number."')";
if (isset($data->agent_id) && $data->agent_id) {
 $whereCheck =$whereCheck. " and agent_id!='".$data->agent_id."'";
}

$checkExist=getQuery($conn,$table_name,["agent_id"],$whereCheck);

if(count($checkExist)>0){
    $data=[
        "status"=>false,
        "message"=>"MobileNumber Already Exists",
    ];
    echo json_encode($data);
    exit;
}

$dataArray = [
    "agent_name" => mysqli_real_escape_string($conn,$agent_name),
    "agent_mobile_number" => mysqli_real_escape_string($conn,$agent_mobile_number),
    "agent_address" => mysqli_real_escape_string($conn,$agent_address),
];

$msg="Record Inserted Successfully";

if (isset($data->agent_id) && $data->agent_id) {
    $where = "agent_id='" . $data->agent_id . "'";
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