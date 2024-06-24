<?php

include("connection.php");

$data = json_decode(file_get_contents("php://input"));

$data_check=["ct_id","cust_id","reg_name","policy_no","agent_no"];

$resultError = checkValidation($data_check,$data);

if(count($resultError)>0){
    echo json_encode($resultError);
    exit;
}

$current_date=date('Y-m-d H:i:s');
$rid=$data->rid;
$ct_id=$data->ct_id;
$cust_id=$data->cust_id;
$reg_name=$data->reg_name;
$policy_no=$data->policy_no;
$agent_id=$data->agent_id;
$bd_id=$data->bd_id;
$agent_no=$data->agent_no;
$policy_date=$data->policy_date;
$fuel_id=$data->fuel_id;
$code_id=$data->code_id;
$premium=$data->premium;
$gst=$data->gst;
$net_premium=$data->net_premium;
$idv=$data->idv;
$gvw=$data->gvw;
$pm_id=$data->pm_id;
$vehicle_id=$data->vehicle_id;
$fp_id=$data->fp_id;
$it_id=$data->it_id;

$table_name="ms_insurance_policy";
$whereCheck="";
$whereCheck = " (policy_no='".$policy_no."')";
if (isset($data->insurance_id) && $data->insurance_id) {
 $whereCheck =$whereCheck. " and insurance_id!='".$data->insurance_id."'";
}

$checkExist=getQuery($conn,$table_name,["insurance_id"],$whereCheck);

if(count($checkExist)>0){
    $data=[
        "status"=>false,
        "message"=>"Policy No Already Exists",
    ];
    echo json_encode($data);
    exit;
}

$dataArray = [
    "rid" => mysqli_real_escape_string($conn,$rid),
    "ct_id" => mysqli_real_escape_string($conn,$ct_id),
    "cust_id" => mysqli_real_escape_string($conn,$cust_id),
    "reg_name" => mysqli_real_escape_string($conn,$reg_name),
    "policy_no" => mysqli_real_escape_string($conn,$policy_no),
    "bd_id" => mysqli_real_escape_string($conn,$bd_id),
    "agent_id" => mysqli_real_escape_string($conn,$agent_id),
    "agent_no" => mysqli_real_escape_string($conn,$agent_no),
    "policy_date" => mysqli_real_escape_string($conn,$policy_date),
    "fuel_id" => mysqli_real_escape_string($conn,$fuel_id),
    "code_id" => mysqli_real_escape_string($conn,$code_id),
    "premium" => mysqli_real_escape_string($conn,$premium),
    "gst" => mysqli_real_escape_string($conn,$gst),
    "net_premium" => mysqli_real_escape_string($conn,$net_premium),
    "idv" => mysqli_real_escape_string($conn,$idv),
    "gvw" => mysqli_real_escape_string($conn,$gvw),
    "pm_id" => mysqli_real_escape_string($conn,$pm_id),
    "vehicle_id" => mysqli_real_escape_string($conn,$vehicle_id),
    "fp_id" => mysqli_real_escape_string($conn,$fp_id),
    "it_id" => mysqli_real_escape_string($conn,$it_id)
];

$msg="Record Inserted Successfully";

if (isset($data->insurance_id) && $data->insurance_id) {
    $where = "insurance_id='" . $data->insurance_id . "'";
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