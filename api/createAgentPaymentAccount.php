<?php
include ("SimpleXLSXGen.php");
include ("connection.php");

$books = [
  [
    '<center><b><style bgcolor="#6fa8dc" color="#000000">Agent Name</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">Payment Mode</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">Payment Date</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">Remarks</style></b></center>',
    '<center><b><style bgcolor="#6fa8dc" color="#000000">Amount</style></b></center>',
  ],
];

$data = (object) ($_REQUEST);


$date_array = ["payment_date"];
$number_array = ["amount"];

include("GetAccountStatementDataAll.php");

include("checkAgentBalance.php");

$key_name_array = [
  "agent_name",
  "pm_name",
  "payment_date",
  "description",
  "amount",
];

$color= $opening_balance_agent>0?"#006400":"#FF0000";

$books[] = [
  null,
  null,
  '<style color="'. $color.'"><b>'. date("Y-m-d",strtotime($from_date . " -1 day")).'</b></style>',
  '<right><style color="#6fa8dc" font-size="12"><b>OLD BALANCE</b></style></right>',
  '<right><style color="#6fa8dc"><b>'. $opening_balance_agent . '</b></style></right>'
];

$count=2;

foreach ($getQueryData as $idx => $value) {
  $simple_array = [];
  foreach ($key_name_array as $index2 => $keyName) {
    if (in_array($keyName, $number_array)) {
      $finalValue = $value[$keyName] ? (float) number_format((float) $value[$keyName], 2, '.', '') : 0;
    } else if (in_array($keyName, $date_array)) {
      $finalValue = $value[$keyName] ? date("Y-m-d", strtotime(datetime: $value[$keyName])) : "-";
    } else if ($keyName == "total") {
     $color= $value[$keyName]>0?"#000000":"#FF0000";
     $finalValue = '<right><style color="'.$color.'">' . $value[$keyName] . '</style></right>';
    } else {
      $finalValue = $value[$keyName] ? $value[$keyName] : "-";
    }

    array_push($simple_array, $finalValue);
  }
  $books[] = $simple_array;

  $count=$count+1;
}

$color= $finalBalanceagent>0?"#006400":"#FF0000";

$count=$count+1;
$books[] = [
  null,
  null,
  '<style color="'. $color.'"><b>'. date("Y-m-d",strtotime($to_date . " +1 day")).'</b></style>',
  '<right><style color="#6fa8dc" font-size="12"><b>TOTAL</b></style></right>',
  '<right><style color="#6fa8dc"><b>'. $finalBalanceagent . '</b></style></right>'
];



$current_date_time = "_" . $from_date . "_to_" . $to_date . "_" . strtotime("now");
$extra_file_name = "";
if ($agent_id) {
 $extra_file_name = str_replace(".", "_", $getQueryData[0]["agent_name"]);
  $extra_file_name = str_replace(" ", "_", $extra_file_name);
}
$file_name = $extra_file_name . $current_date_time . ".xlsx";

$xlsx = Shuchkin\SimpleXLSXGen::fromArray($books, $name = "MySheet")->setDefaultFontSize(11);
// $xlsx->mergeCells('A2:J2');
// $xlsx->mergeCells('A'.$count.':J'.$count);
$xlsx->autoFilter('A1:E1');
$xlsx->downloadAs($file_name);

