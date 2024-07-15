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


$checkTable_name=["ms_insurance_policy","add_credit_note_company","add_credit_note_agent"];

if(!in_array($table_name, $checkTable_name)){
$sql_check="Select ".$check_key." From ".$table_name." where ".$check_key."='".$id."'";

$result_check = mysqli_query($conn, $sql_check);
$row_count_check = mysqli_num_rows($result_check);

if($row_count_check>0){
    echo json_encode([
        "status"=>false,
        "message"=>"Data Exist in Insurance. Cannot Delete",
    ]);
    exit;
}

}


$sql_count="Delete From ".$table_name." where ".$key."='".$id."'";

$result_count = mysqli_query($conn, $sql_count);

if($table_name =="ms_insurance_policy"){
    $sql_count2="Delete From add_credit_note_company  where ".$key."='".$id."'";
$result_count2 = mysqli_query($conn, $sql_count2);

$sql_count3="Delete From add_credit_note_agent where ".$key."='".$id."'";
$result_count3 = mysqli_query($conn, $sql_count3);
}

$data=[
    "status"=>true,
    "message"=>"Deleted Successfully",
    "checkExist"=>@$row_count_check
];

echo json_encode($data);
?>