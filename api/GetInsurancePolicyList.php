<?php
include("connection.php");
$data = json_decode(file_get_contents("php://input"));
include("GetInsurancePolicyDataAll.php");
include("checkAgentBalance.php");
include("checkCompanyBalance.php");
$data=[
    "status"=>true,
    "message"=>"Insurace Policy List",
    "Records"=>$getQueryData,
    "total_rows"=>round(@$total_rows[0]["total_rows"]),
    "balance"=>array(
        "opening_balance_agent"=>$opening_balance_agent,
        "closing_balance_agent"=>$closing_balance_agent,
        "finalBalanceagent"=>$finalBalanceagent,
        "opening_balance_company"=>$opening_balance_company,
        "closing_balance_company"=>$closing_balance_company,
        "final_balance_company"=>$final_balance_company,
    )
];

echo json_encode($data);
?>