<?php
include("connection.php");

$data = json_decode(file_get_contents("php://input"));

include("GetAccountStatementDataAll.php");

include("checkAgentBalance.php");
include("checkCompanyBalance.php");
include("checkPaymentBalance.php");

$data=[
    "status"=>true,
    "message"=>"Account Statement  List",
    "Records"=>$getQueryData,
    "total_rows"=>round(@$total_rows[0]["total_rows"]),
    "balance"=>array(
        "opening_balance_agent"=>$opening_balance_agent,
        "closing_balance_agent"=>$closing_balance_agent,
        "finalBalanceagent"=>$finalBalanceagent,
        "opening_balance_company"=>$opening_balance_company,
        "closing_balance_company"=>$closing_balance_company,
        "final_balance_company"=>$final_balance_company,
        "opening_balance_payment"=>$opening_balance_payment,
        "closing_balance_payment"=>$closing_balance_payment,
        "final_balance_payment"=>$final_balance_payment
    )
];
echo json_encode($data);

?>
