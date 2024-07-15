<?php

include("connection.php");
function addEditCreditNote($data,$conn,$created_user_id,$current_date){
    $table_name="add_credit_note_company";
    $column_name="c_ref_id";
    $whereCheck= " insurance_id=".$data["insurance_id"];
    if(@$data["agent_id"] && @$data["agent_id"]>0){
        $whereCheck=$whereCheck." and agent_id=".$data["agent_id"];
       $table_name="add_credit_note_agent";
       $column_name= "a_ref_id";
    }
  
    $checkExist=getQuery($conn,$table_name,["insurance_id"],$whereCheck);
   
   if(count($checkExist)>0){
       $updateQuery=updateQuery($table_name, $data, $whereCheck, $conn);
   }else{
      if($data["amount"]){
        $data["created_at"] = $current_date;
        $data["created_by"] = $created_user_id;
        $insert_id = insertQuery($table_name, $data, $conn);
      }
   }
 }


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
$purchase_rate=$data->purchase_rate;
$company_rate=$data->company_rate;
$agent_rate=$data->agent_rate;
$code_rate=$data->code_rate;
$profit_rate=$data->profit_rate;
$is_gst=$data->is_gst;
$hp_name=$data->hp_name;
$remarks=$data->remarks;

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
    "it_id" => mysqli_real_escape_string($conn,$it_id),
    "is_gst" => mysqli_real_escape_string($conn,$is_gst),
    "purchase_rate" => mysqli_real_escape_string($conn,$purchase_rate),
    "company_rate" => mysqli_real_escape_string($conn,$company_rate),
    "agent_rate" => mysqli_real_escape_string($conn,$agent_rate),
    "code_rate" => mysqli_real_escape_string($conn,$code_rate),
    "profit_rate" => mysqli_real_escape_string($conn,$profit_rate),
    "hp_name" => mysqli_real_escape_string($conn,$hp_name),
    "remarks" => mysqli_real_escape_string($conn,$remarks),
];

$msg="Record Inserted Successfully";
$insurance_id="";
if (isset($data->insurance_id) && $data->insurance_id) {
    $insurance_id=$data->insurance_id;
    $where = "insurance_id='" . $data->insurance_id . "'";
    $dataArray["updated_at"] = $current_date;
    $dataArray["updated_by"] = $created_user_id;
    $updateQuery=updateQuery($table_name, $dataArray, $where, $conn);
    $msg="Record Updated Successfully";
} else {
    $dataArray["created_at"] = $current_date;
    $dataArray["created_by"] = $created_user_id;
    $insert_id = insertQuery($table_name, $dataArray, $conn);
    $insurance_id=$insert_id;
}

///agent id
    $dataNew=[
        "amount"=> $agent_rate,
        "insurance_id"=>$insurance_id,
        "payment_date"=>$policy_date,
        "pm_id"=>$pm_id,
        "agent_id"=>$agent_id
    ];

    $deleteInsurance= "Delete  From add_credit_note_company where insurance_id = '".$insurance_id."'";
    $query_run=mysqli_query($conn, $deleteInsurance);

    $deleteInsurance2= "Delete From add_credit_note_agent where insurance_id = '".$insurance_id."'";
    $query_run=mysqli_query($conn, $deleteInsurance2);

    addEditCreditNote($dataNew,$conn,$created_user_id,$current_date); 

    ///code id
    $dataNew=[
        "amount"=> $code_rate,
        "insurance_id"=>$insurance_id,
        "payment_date"=>$policy_date,
        "pm_id"=>$pm_id,
        "agent_id"=>$code_id
    ];
    
    addEditCreditNote($dataNew,$conn,$created_user_id,$current_date); 

    ///company id
    $dataNew=[
            "amount"=> $company_rate,
            "insurance_id"=>$insurance_id,
            "payment_date"=>$policy_date,
            "pm_id"=>$pm_id,
            "company_id"=>$ct_id
    ];
    addEditCreditNote($dataNew,$conn,$created_user_id,$current_date);

$data=[
    "status"=>true,
    "message"=>$msg,
];

echo json_encode($data);

?>