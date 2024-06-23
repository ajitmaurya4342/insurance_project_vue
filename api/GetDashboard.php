<?php

include("connection.php");


$agent_array=array(
 "key"=>"ms_agent",
 "path"=>"agent-user",
 "heading"=>"Total Agent",
 "icon"=>"SmileIcon"
);

$vehicle_array=array(
    "key"=>"ms_customer",
    "path"=>"customer-list",
    "heading"=>"Total Vehicle",
    "icon"=>"TruckIcon"
);

$insurance_array=array(
    "key"=>"ms_insurance_policy",
    "path"=>"insurance-list",
    "heading"=>"Total Insurance",
    "icon"=>"FileTextIcon"
);

$data=[];

$data[]=$agent_array;
$data[]=$vehicle_array;
$data[]=$insurance_array;

$total_rows=[];
foreach ($data as $key => $val){
    $total_rows=getQuery($conn,$val["key"],["count(*) as total_rows"],"");
    $data[$key]["total_count"] = round($total_rows[0]["total_rows"]);
}

$data=[
    "status"=>true,
    "message"=>"Dashboard List",
    "Records"=>$data
];

echo json_encode($data);
?>