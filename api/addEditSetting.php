<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["gst"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$current_date=date('Y-m-d H:i:s');
$gst=$data->gst;

$table_name="setting";
$whereCheck="";
$whereCheck = " (gst='".$gst."')";
if (isset($data->setting_id) && $data->setting_id) {
 $whereCheck =$whereCheck. " and setting_id!='".$data->setting_id."'";
}

$checkExist=getQuery($conn,$table_name,["setting_id"],$whereCheck);

if(count($checkExist)>0){
    $data=[
        "status"=>false,
        "message"=>"Type Already Exists",
    ];
    echo json_encode($data);
    exit;
}

$dataArray = [
    "gst" => mysqli_real_escape_string($conn,$gst),
];

$msg="Record Inserted Successfully";

if (isset($data->setting_id) && $data->setting_id) {
    $where = "setting_id='" . $data->setting_id . "'";
    $updateQuery=updateQuery($table_name, $dataArray, $where, $conn);
    $msg="Record Updated Successfully";
} else {
    $insert_id = insertQuery($table_name, $dataArray, $conn);
}

$data=[
    "status"=>true,
    "message"=>$msg,
];

echo json_encode($data);

?>