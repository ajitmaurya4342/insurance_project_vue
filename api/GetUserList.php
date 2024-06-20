<?php

include("connection.php");
$data = json_decode(file_get_contents("php://input"));

$table_name="users";
$column=["username","name","user_id","mobile_number","user_type","password"];
$search_column=["username","name","mobile_number"];
$where = "";
$limit=0;
$current_page=0;
$search="";
$order_column="user_id";
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

if(isset($data->user_id) && $data->user_id){
    $user_id=$data->user_id;
    $where=" user_id='".$user_id."'";
}

@$getQueryData=getQuery($conn,$table_name,$column,$where,$search,$search_column,$order_column,$order_by,$limit,$current_page);

$total_rows=[];
if($limit && $current_page===1 && !isset($data->user_id)){
  $total_rows=getQuery($conn,$table_name,["count(*) as total_rows"],"",$search,$search_column);
}

$data=[
    "status"=>true,
    "message"=>"User List",
    "Records"=>$getQueryData,
    "total_rows"=>round($total_rows[0]["total_rows"])
];

echo json_encode($data);
?>