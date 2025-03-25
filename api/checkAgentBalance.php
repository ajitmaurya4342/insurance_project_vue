<?php
$opening_balance_agent = 0;
$closing_balance_agent = 0;
$finalBalanceagent  = 0;

if($agent_id && $from_date && $to_date){

$agentSql = "select sum(amount) as opening_balance from add_credit_note_agent where Date(payment_date)<'" . $from_date . "' and agent_id='" . $agent_id . "';";
$resultSum = mysqli_query($conn, $agentSql);
$balanceResult = mysqli_fetch_assoc($resultSum);

if ($balanceResult && $balanceResult["opening_balance"]) {
  $opening_balance_agent = (float) number_format((float) $balanceResult["opening_balance"], 2, '.', '');
}

$agentClosingSql = "select sum(amount) as closing_balance from add_credit_note_agent where (Date(payment_date)>='" . $from_date . "' and Date(payment_date)<='" . $to_date . "') and agent_id='" . $agent_id . "';"; 

$resultSumBal = mysqli_query($conn, $agentClosingSql);
$balanceResultBal = mysqli_fetch_assoc($resultSumBal);

if ($balanceResultBal && $balanceResultBal["closing_balance"]) {
  $closing_balance_agent = (float) number_format((float) $balanceResultBal["closing_balance"], 2, '.', '');
}

$finalBalanceagent = $opening_balance_agent + $closing_balance_agent;
}


?>




