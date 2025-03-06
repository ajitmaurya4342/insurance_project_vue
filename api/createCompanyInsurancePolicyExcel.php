<?php
include ("SimpleXLSXGen.php");
include ("connection.php");

$books = [
  [
    '<center><b><style bgcolor="#6fa8dc" color="#000000">RID</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">Company Name</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">REGISTRATION NO.</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">NAME</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">POLICY NO</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">DATE</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">PREMIUM</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">GST</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">NET PREMIUM</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">IDV</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">TOTAL</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">PAYMENT MODE</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">TYPES OF VEHICLS</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">FP/TP</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">PRIVATE/COMMERCIAL</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">Fuel Type</style></b></center>'
  ],
];

$data = (object) ($_REQUEST);

$number_array = ["premium", "gst", "net_premium", "idv", "total"];
$date_array = ["policy_date_new", "rid_new"];

include ("GetInsurancePolicyDataAll.php");

$opening_balance = 0;
$agentSql = "select sum(amount) as opening_balance from add_credit_note_company where Date(payment_date)<'" . $from_date . "' and company_id='" . $ct_id . "';";
$resultSum = mysqli_query($conn, $agentSql);
$balanceResult = mysqli_fetch_assoc($resultSum);

if ($balanceResult && $balanceResult["opening_balance"]) {
  $opening_balance = (float) number_format((float) $balanceResult["opening_balance"], 2, '.', '');
}

$key_name_array = [
  "rid_new",
  "company_type_name",
  "vehicle_no",
  "reg_name",
  "policy_no",
  "policy_date_new",
  "premium",
  "gst",
  "net_premium",
  "idv",
  "total",
  "pm_name",
  "vehicle_type",
  "fp_type",
  "insurance_type_name",
  "fuel_type_name",
];

$books[] = [
  null,
  null,
  null,
  null,
  null,
  '<style color="'. $color.'"><b>'. date("Y-m-d",strtotime($from_date . " -1 day")).'</b></style>',
  null,
  null,
  null,
  '<right><style color="#6fa8dc" font-size="12"><b>OLD BALANCE</b></style></right>',
  '<right><style color="#6fa8dc"><b>'. $opening_balance . '</b></style></right>',
  null,
  null,
  null,
  null,
  null,
];


$agentCredit = "select amount,description,payment_date,ms_payment_mode.pm_name from add_credit_note_company
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_company.pm_id
 where insurance_id is null and  (Date(payment_date) between '" . $from_date . "' and '" . $to_date . "') and company_id='" . $ct_id . "';";
$resultCredit = mysqli_query($conn, $agentCredit);

$count=2;
$total=$opening_balance;
if(mysqli_num_rows($resultCredit)> 0){
while($rowdetail=mysqli_fetch_assoc($resultCredit)) {
  $color= $rowdetail["amount"]>0?"#006400":"#FF0000";
  $totalA= $rowdetail["amount"]?(float) number_format((float)  $rowdetail["amount"], 2, '.', ''):0;
  $books[] = [
    null,
    null,
    null,
    null,
    null,
   '<style color="'. $color.'"><b>'. date("Y-m-d",strtotime($rowdetail["payment_date"])).'</b></style>',
    null,
    null,
    null,
    '<style color="'. $color.'"><b>'. $rowdetail["description"] .'</b></style>',
    '<right><style color="'.$color.'"><b>'. $totalA . '</b></style></right>',
    $rowdetail["pm_name"],
    null,
    null,
    null,
    null,
  ];

  $count=$count+1;
  $total=$total+$totalA;
}
}

foreach ($getQueryData as $idx => $value) {
  $value["total"] = $value["company_rate"];
 
  $value["total"]= $value["total"]?(float) number_format((float)  $value["total"], 2, '.', ''):0;
  $simple_array = [];
  foreach ($key_name_array as $index2 => $keyName) {
    if (in_array($keyName, $number_array)) {
      $finalValue = $value[$keyName] ? (float) number_format((float) $value[$keyName], 2, '.', '') : 0;
    } else if (in_array($keyName, $date_array)) {
      $finalValue = $value[$keyName] ? date("Y-m-d", strtotime($value[$keyName])) : "-";
    } else if ($keyName == "total") {
     $color= $value[$keyName]>0?"#000000":"#FF0000";
     $finalValue = '<right><style color="'.$color.'">' . $value[$keyName] . '</style></right>';
    } else {
      $finalValue = $value[$keyName] ? $value[$keyName] : "-";
    }

    array_push($simple_array, $finalValue);
  }
  $books[] = $simple_array;
  $total=$value["total"] + $total;
  $count=$count+1;
}

$count=$count+1;

$books[] = [
 null,
  null,
  null,
  null,
  null,
  '<style color="'. $color.'"><b>'. date("Y-m-d",strtotime($to_date . " +1 day")).'</b></style>',
  null,
  null,
  '<right><style color="#000000" font-size="12"><b>TOTAL</b></style></right>',
  '<right><style color="#000000" font-size="12"><b>TOTAL</b></style></right>',
  '<right><style color="#000000"><b>'. $total . '</b></style></right>',
  null,
  null,
  null,
  null,
  null,
];


$current_date_time = "_" . $from_date . "_to_" . $to_date . "_" . strtotime("now");
$extra_file_name = "";
if ($ct_id) {
 $extra_file_name = str_replace(".", "_", $getQueryData[0]["company_type_name"]);
 $extra_file_name = str_replace(" ", "_", $extra_file_name);
}
$file_name = $extra_file_name . $current_date_time . ".xlsx";

$xlsx = Shuchkin\SimpleXLSXGen::fromArray($books, $name = "MySheet")->setDefaultFontSize(11);
// $xlsx->mergeCells('A2:J2');
// $xlsx->mergeCells('A'.$count.':J'.$count);
$xlsx->autoFilter('A1:P1');
$xlsx->downloadAs($file_name);

