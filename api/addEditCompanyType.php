<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["company_type_name"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$current_date=date('Y-m-d H:i:s');
$company_type_name=$data->company_type_name;

$table_name="ms_company_type";
$whereCheck="";
$whereCheck = " (company_type_name='".$company_type_name."')";
if (isset($data->ct_id) && $data->ct_id) {
 $whereCheck =$whereCheck. " and ct_id!='".$data->ct_id."'";
}

$checkExist=getQuery($conn,$table_name,["ct_id"],$whereCheck);

if(count($checkExist)>0){
    $data=[
        "status"=>false,
        "message"=>"Company Type Already Exists",
    ];
    echo json_encode($data);
    exit;
}

$dataArray = [
    "company_type_name" => mysqli_real_escape_string($conn,$company_type_name),
];

$msg="Record Inserted Successfully";

if (isset($data->ct_id) && $data->ct_id) {
    $where = "ct_id='" . $data->ct_id . "'";
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