<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["fp_type"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$current_date=date('Y-m-d H:i:s');
$fp_type=$data->fp_type;

$table_name="ms_fp_tp_type";
$whereCheck="";
$whereCheck = " (fp_type='".$fp_type."')";
if (isset($data->fp_id) && $data->fp_id) {
 $whereCheck =$whereCheck. " and fp_id!='".$data->fp_id."'";
}

$checkExist=getQuery($conn,$table_name,["fp_id"],$whereCheck);

if(count($checkExist)>0){
    $data=[
        "status"=>false,
        "message"=>"Type Already Exists",
    ];
    echo json_encode($data);
    exit;
}

$dataArray = [
    "fp_type" => mysqli_real_escape_string($conn,$fp_type),
];

$msg="Record Inserted Successfully";

if (isset($data->fp_id) && $data->fp_id) {
    $where = "fp_id='" . $data->fp_id . "'";
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