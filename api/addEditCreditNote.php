<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["amount","payment_date","type"];

$resultError = checkValidation($data_check,$data);


if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$current_date=date('Y-m-d H:i:s');
$amount=$data->amount;
$payment_date=$data->payment_date;
$pm_id=$data->pm_id;
@$company_id=$data->company_id;
@$agent_id=$data->agent_id;
@$description=$data->description;
@$type_id=$data->type_id;
@$parent_c_ref_id=$data->parent_c_ref_id;

$table_name=$data->type;
$column_name="c_ref_id";


$dataArray = [
    "amount" => mysqli_real_escape_string($conn,$amount),
    "payment_date" => mysqli_real_escape_string($conn,$payment_date),
    "pm_id" => mysqli_real_escape_string($conn,$pm_id),
    "description" => mysqli_real_escape_string($conn,$description),
];

if($table_name==="add_credit_note_agent"){
    $column_name="a_ref_id";
    $dataArray["agent_id"]=mysqli_real_escape_string($conn,$agent_id);
}else{
    
    $dataArray["parent_c_ref_id"]=mysqli_real_escape_string($conn,$parent_c_ref_id);
    $dataArray["company_id"]=mysqli_real_escape_string($conn,$company_id);
}

$msg="Record Inserted Successfully";
$insert_id = 0;
if (isset($data->type_id) && $data->type_id) {
    $where =" ".$column_name."='" . $data->type_id . "'";
    $updateQuery=updateQuery($table_name, $dataArray, $where, $conn);
    $msg="Record Updated Successfully";
} else {
    $dataArray["created_at"] = $current_date;
    $dataArray["created_by"] = $created_user_id;
    
    $insert_id = insertQuery($table_name, $dataArray, $conn);
}

if(isset($parent_c_ref_id) && $parent_c_ref_id){
   $sql2="update add_credit_note_company set parent_c_ref_id = '".$parent_c_ref_id."' where c_ref_id = '".$parent_c_ref_id."'";
   $result2 = mysqli_query($conn, $sql2);
}

$data=[
    "status"=>true,
    "message"=>$msg,
    "parent_c_ref_id"=>$insert_id
];

echo json_encode($data);

?>