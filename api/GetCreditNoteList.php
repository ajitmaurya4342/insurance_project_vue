<?php

include("connection.php");
$data = json_decode(file_get_contents("php://input"));

$search_column_agent = ["amount","ms_payment_mode.pm_name","ms_agent.agent_name","ms_insurance_policy.policy_no","description"];
$search_column_company = ["amount","ms_payment_mode.pm_name","ms_company_type.company_type_name","ms_insurance_policy.policy_no","description"];
$where = "";
$limit=0;
$current_page=0;
$type_id="";
$type="";
$search="";

if(isset($data->limit) && $data->limit){
    $limit=$data->limit;
}

if(isset($data->currentPage) && $data->currentPage){
    $current_page=$data->currentPage;
}

if(isset($data->type_id) && $data->type_id){
    $type_id=$data->type_id;
}


if(isset($data->type) && $data->type){
    $type=$data->type;
}


if(isset($data->search) && $data->search){
    $search=$data->search;
}


$sqlAgent="SELECT ms_payment_mode.pm_id, ms_agent.agent_id as id,ms_payment_mode.pm_name,amount,payment_date,description,add_credit_note_agent.created_at,'add_credit_note_agent' as type,a_ref_id as type_id,'By Agent' as type_name,ms_agent.agent_name as name,ms_insurance_policy.policy_no  FROM add_credit_note_agent 
left join ms_agent on ms_agent.agent_id = add_credit_note_agent.agent_id
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_agent.pm_id
left join ms_insurance_policy on ms_insurance_policy.insurance_id = add_credit_note_agent.insurance_id where 1=1 ";

if(count($search_column_agent)>0 && isset($search) && $search){
    $searchval=" and (";
    foreach ($search_column_agent as $key => $val) {
        if($key==(count($search_column_agent)-1)){
            $searchval.= " $val like '%$search%' ) ";
        }else{
            $searchval.= " $val like '%$search%' or ";
        }
       
    }
    $sqlAgent = $sqlAgent.$searchval;

}

$sqlCompany="SELECT ms_payment_mode.pm_id, ms_company_type.ct_id as id,ms_payment_mode.pm_name,amount,payment_date,description,add_credit_note_company.created_at,'add_credit_note_company' as type,c_ref_id as type_id,'By Company' as type_name,ms_company_type.company_type_name as name,ms_insurance_policy.policy_no  from add_credit_note_company
left join ms_company_type on ms_company_type.ct_id = add_credit_note_company.company_id
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_company.pm_id
left join ms_insurance_policy on ms_insurance_policy.insurance_id = add_credit_note_company.insurance_id  where 1=1 ";

if(count($search_column_company)>0 && isset($search) && $search){
    $searchval=" and (";
    foreach ($search_column_company as $key => $val) {
        if($key==(count($search_column_company)-1)){
            $searchval.= " $val like '%$search%' ) ";
        }else{
            $searchval.= " $val like '%$search%' or ";
        }
       
    }
    $sqlCompany = $sqlCompany.$searchval;

}

$sqlUnion="UNION ALL ";

$sqlOrder=" order  by created_at DESC";


$column_name="company_id";
$total_rows=[];
if($type==="add_credit_note_agent"){
  $where=" and add_credit_note_agent.a_ref_id='".$data->type_id."'";
  $finalSql=$sqlAgent. $where;
}else if($type==="add_credit_note_company"){
   $where=" and add_credit_note_company.c_ref_id='".$data->type_id."'";
   $finalSql=$sqlCompany. $where;

}else{
    $finalSql=$sqlAgent. $sqlUnion.$sqlCompany.$sqlOrder;

    if(isset($limit) && isset($current_page) && $limit && $current_page){
    $start=($current_page-1)* $limit;
    $finalSql = $finalSql ." limit ".$start.",".$limit;
   }
    if($limit){
      $sqlUnionCount="SELECT  COUNT(*) as total_rows From ( ";
      $countFinal= $sqlUnionCount. $sqlAgent. $sqlUnion.$sqlCompany." ) total_rows";
      $result22 = mysqli_query($conn, $countFinal);
      $rowTotal = mysqli_num_rows($result22);
      if($rowTotal>0){
        while($row_detail222=mysqli_fetch_assoc($result22)){
            $total_rows[] = $row_detail222;
        }
       }
    }
};

$result = mysqli_query($conn, $finalSql);
$row = mysqli_num_rows($result);


$getQueryData=[];
if($row>0){
    while($row_detail=mysqli_fetch_assoc($result)){
        if($row_detail["policy_no"]){
            $row_detail["description"] = "Created By Insurance (Policy No: ".$row_detail["policy_no"].")";
        }
        $getQueryData[] = $row_detail;
      
    }
}

$data=[
    "status"=>true,
    "message"=>"Credit Note List",
    "Records"=>$getQueryData,
    "total_rows"=>round(@$total_rows[0]["total_rows"])
];

echo json_encode($data);
?>