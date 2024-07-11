<?php

$table_name="ms_agent";
$column=["agent_name","agent_mobile_number","agent_id","agent_address","(select IF(sum(amount) is null,0,sum(amount))  from add_credit_note_agent where agent_id=ms_agent.agent_id) as balance_amount "];
$search_column=["agent_name","agent_mobile_number","agent_address"];
$where = "";
$limit=0;
$current_page=0;
$search="";
$order_column="agent_id";
$order_by="DESC";
if(isset($data->search) && $data->search){
    $search=$data->search;
}

if(isset($data->limit) && $data->limit){
    $limit=$data->limit;
}

if(isset($data->currentPage) && $data->currentPage){
    $current_page=$data->currentPage;
}

if(isset($data->agent_id) && $data->agent_id){
    $agent_id=$data->agent_id;
    $where=" agent_id='".$agent_id."'";
}

@$getQueryData=getQuery($conn,$table_name,$column,$where,$search,$search_column,$order_column,$order_by,$limit,$current_page);

$total_rows=[];
if($limit && $current_page===1 && !isset($data->agent_id)){
  $total_rows=getQuery($conn,$table_name,["count(*) as total_rows"],"",$search,$search_column);
}

?>