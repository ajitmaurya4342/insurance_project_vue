<?php

include("connection.php");
$data = json_decode(file_get_contents("php://input"));

include("getAgentData.php");

$data=[
    "status"=>true,
    "message"=>"User List",
    "Records"=>$getQueryData,
    "total_rows"=>round(@$total_rows[0]["total_rows"])
];

echo json_encode($data);
?>