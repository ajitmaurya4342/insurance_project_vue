<?php
$opening_balance_company = 0;
$closing_balance_company = 0;
$final_balance_company  = 0;

if($ct_id && $from_date && $to_date){

$companySql = "select sum(amount) as opening_balance from add_credit_note_company where Date(payment_date)<'" . $from_date . "' and company_id='" . $ct_id . "';";
$resultSum = mysqli_query($conn, $companySql);
$balanceResult = mysqli_fetch_assoc($resultSum);

if ($balanceResult && $balanceResult["opening_balance"]) {
  $opening_balance_company = (float) number_format((float) $balanceResult["opening_balance"], 2, '.', '');
}

$companyClosingSql = "select sum(amount) as closing_balance from add_credit_note_company where (Date(payment_date)>='" . $from_date . "' and Date(payment_date)<='" . $to_date . "') and company_id='" . $ct_id . "';"; 

$resultSumBal = mysqli_query($conn, $companyClosingSql);
$balanceResultBal = mysqli_fetch_assoc($resultSumBal);

if ($balanceResultBal && $balanceResultBal["closing_balance"]) {
  $closing_balance_company = (float) number_format((float) $balanceResultBal["closing_balance"], 2, '.', '');
}

$final_balance_company = $opening_balance_company + $closing_balance_company;

}


?>




