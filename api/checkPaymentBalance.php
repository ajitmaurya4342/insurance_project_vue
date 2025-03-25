<?php
$opening_balance_payment = 0;
$closing_balance_payment = 0;
$final_balance_payment  = 0;

if($pm_id && $from_date && $to_date){

$opening1 = "select sum(If(company_id>0,-1*amount,amount)) as opening_balance from add_credit_note_company where Date(payment_date)<'" . $from_date . "' and pm_id='" . $pm_id . "' and insurance_id is null;";
$resultSum = mysqli_query($conn, $opening1);
$balanceResult = mysqli_fetch_assoc($resultSum);

if ($balanceResult && $balanceResult["opening_balance"]) {
  $opening_balance_payment = (float) number_format((float) $balanceResult["opening_balance"], 2, '.', '') +  $opening_balance_payment;
}


$opening2 = "select sum(-1*amount) as opening_balance from add_credit_note_agent where Date(payment_date)<'" . $from_date . "' and pm_id='" . $pm_id . "' and insurance_id is null;";
$resultSum = mysqli_query($conn, $opening2);
$balanceResult = mysqli_fetch_assoc($resultSum);

if ($balanceResult && $balanceResult["opening_balance"]) {
  $opening_balance_payment = (float) number_format((float) $balanceResult["opening_balance"], 2, '.', '') +  $opening_balance_payment;
}


$opening3 = "select sum(-1*premium) as opening_balance from ms_insurance_policy where Date(policy_date)<'" . $from_date . "' and pm_id='" . $pm_id . "';";
$resultSum = mysqli_query($conn, $opening3);
$balanceResult = mysqli_fetch_assoc($resultSum);

if ($balanceResult && $balanceResult["opening_balance"]) {
  $opening_balance_payment = (float) number_format((float) $balanceResult["opening_balance"], 2, '.', '') +  $opening_balance_payment;
}


$closing1 = "select sum(If(company_id>0,-1*amount,amount))  as closing_balance from add_credit_note_company where (Date(payment_date)>='" . $from_date . "' and Date(payment_date)<='" . $to_date . "') and pm_id='" . $pm_id . "' and insurance_id is null;"; 

$resultSumBal = mysqli_query($conn, $closing1);
$balanceResultBal = mysqli_fetch_assoc($resultSumBal);

if ($balanceResultBal && $balanceResultBal["closing_balance"]) {
  $closing_balance_payment = (float) number_format((float) $balanceResultBal["closing_balance"], 2, '.', '') + $closing_balance_payment;
}

$closing2 = "select sum(-1 * amount) as closing_balance from add_credit_note_agent where (Date(payment_date)>='" . $from_date . "' and Date(payment_date)<='" . $to_date . "') and pm_id='" . $pm_id . "' and insurance_id is null;"; 

$resultSumBal = mysqli_query($conn, $closing2);
$balanceResultBal = mysqli_fetch_assoc($resultSumBal);

if ($balanceResultBal && $balanceResultBal["closing_balance"]) {
  $closing_balance_payment = (float) number_format((float) $balanceResultBal["closing_balance"], 2, '.', '') + $closing_balance_payment;
}

$closing3 = "select sum(-1 * premium) as closing_balance from ms_insurance_policy where (Date(policy_date)>='" . $from_date . "' and Date(policy_date)<='" . $to_date . "') and pm_id='" . $pm_id . "' ;"; 

$resultSumBal = mysqli_query($conn, $closing3);
$balanceResultBal = mysqli_fetch_assoc($resultSumBal);

if ($balanceResultBal && $balanceResultBal["closing_balance"]) {
  $closing_balance_payment = (float) number_format((float) $balanceResultBal["closing_balance"], 2, '.', '') + $closing_balance_payment;
}

$final_balance_payment = $opening_balance_payment + $closing_balance_payment;

}


?>




