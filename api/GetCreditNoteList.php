<?php

include("connection.php");
$data = json_decode(file_get_contents("php://input"));


$where = "";
$limit=0;
$current_page=0;
$type_id="";
$type="";


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




$sqlAgent="SELECT ms_payment_mode.pm_id, ms_agent.agent_id as id,ms_payment_mode.pm_name,amount,payment_date,description,add_credit_note_agent.created_at,'add_credit_note_agent' as type,a_ref_id as type_id,'By Agent' as type_name,ms_agent.agent_name as name  FROM add_credit_note_agent 
left join ms_agent on ms_agent.agent_id = add_credit_note_agent.agent_id
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_agent.pm_id
where insurance_id is null ";

$sqlCompany="SELECT ms_payment_mode.pm_id, ms_company_type.ct_id as id,ms_payment_mode.pm_name,amount,payment_date,description,add_credit_note_company.created_at,'add_credit_note_company' as type,c_ref_id as type_id,'By Company' as type_name,ms_company_type.company_type_name as name  from add_credit_note_company
left join ms_company_type on ms_company_type.ct_id = add_credit_note_company.company_id
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_company.pm_id
where insurance_id is null ";


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
        $getQueryData[] = $row_detail;
      
    }
}



$data=[
    "status"=>true,
    "message"=>"Vehicle Type List",
    "Records"=>$getQueryData,
    "total_rows"=>round(@$total_rows[0]["total_rows"])
];

echo json_encode($data);
?>