<?php

include("connection.php");
$data = json_decode(file_get_contents("php://input"));

$table_name="ms_company_type";
$column=["company_type_name","ct_id"];
$search_column=["company_type_name"];
$where = "";
$limit=0;
$current_page=0;
$search="";
$order_column="ct_id";
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

if(isset($data->ct_id) && $data->ct_id){
    $ct_id=$data->ct_id;
    $where=" ct_id='".$ct_id."'";
}

@$getQueryData=getQuery($conn,$table_name,$column,$where,$search,$search_column,$order_column,$order_by,$limit,$current_page);

$total_rows=[];
if($limit && $current_page===1 && !isset($data->ct_id)){
  $total_rows=getQuery($conn,$table_name,["count(*) as total_rows"],"",$search,$search_column);
}

$data=[
    "status"=>true,
    "message"=>"Vehicle Type List",
    "Records"=>$getQueryData,
    "total_rows"=>round($total_rows[0]["total_rows"])
];

echo json_encode($data);
?>