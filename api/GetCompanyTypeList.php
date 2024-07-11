<?php

include("connection.php");
$data = json_decode(file_get_contents("php://input"));

include("getCompanyTypeData.php");
$total_rows=[];
if($limit && $current_page===1 && !isset($data->ct_id)){
  $total_rows=getQuery($conn,$table_name,["count(*) as total_rows"],"",$search,$search_column);
}

$data=[
    "status"=>true,
    "message"=>"Vehicle Type List",
    "Records"=>$getQueryData,
    "total_rows"=>round(@$total_rows[0]["total_rows"])
];

echo json_encode($data);
?>