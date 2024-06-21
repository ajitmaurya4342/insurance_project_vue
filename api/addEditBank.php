<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["bank_dept_name"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$current_date=date('Y-m-d H:i:s');
$bank_dept_name=$data->bank_dept_name;

$table_name="ms_bank_department";
$whereCheck="";
$whereCheck = " (bank_dept_name='".$bank_dept_name."')";
if (isset($data->bd_id) && $data->bd_id) {
 $whereCheck =$whereCheck. " and bd_id!='".$data->bd_id."'";
}

$checkExist=getQuery($conn,$table_name,["bd_id"],$whereCheck);

if(count($checkExist)>0){
    $data=[
        "status"=>false,
        "message"=>"Type Already Exists",
    ];
    echo json_encode($data);
    exit;
}

$dataArray = [
    "bank_dept_name" => mysqli_real_escape_string($conn,$bank_dept_name),
];

$msg="Record Inserted Successfully";

if (isset($data->bd_id) && $data->bd_id) {
    $where = "bd_id='" . $data->bd_id . "'";
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