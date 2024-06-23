<?php

include("connection.php");
$data = json_decode(file_get_contents("php://input"));

$data_check=["table_name","key","id"];
$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$table_name=$data->table_name;
$id=$data->id;
$key=$data->key;
$check_key=$data->key;

if($check_key=="user_id"){
    $check_key="created_by";
}


$chek_more="";
if($check_key=="agent_id"){
    $chek_more = " or code_id='".$id."'"; 
}


$checkTable_name="ms_insurance_policy";
$sql_check="Select ".$check_key." From ".$checkTable_name." where ".$check_key."='".$id."'" . $chek_more;

$result_check = mysqli_query($conn, $sql_check);
$row_count_check = mysqli_num_rows($result_check);

if($row_count_check>0){
    echo json_encode([
        "status"=>false,
        "message"=>"Data Exist in Insurance. Cannot Delete",
    ]);
    exit;
}

$sql_count="Delete From ".$table_name." where ".$key."='".$id."'";
$result_count = mysqli_query($conn, $sql_count);

$data=[
    "status"=>true,
    "message"=>"Deleted Successfully",
    "checkExist"=>$row_count_check
];

echo json_encode($data);
?>