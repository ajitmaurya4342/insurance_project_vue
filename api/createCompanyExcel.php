<?php
include("SimpleXLSXGen.php");
include("connection.php");

$books = [
    [
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Company Name</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Mobile Number</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Address</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Balance </style></b></center>',
    ]
];

$data= new stdClass();

include("getCompanyTypeData.php");

$key_name_array=[
    "company_type_name",
    "company_phone",
    "company_address",
    "balance_amount"
];

$number_array=["balance_amount"];
$date_array=[];

$sql="";
foreach($getQueryData as $idx=>$value){
    $simple_array=[];
  foreach($key_name_array as $index2=>$keyName){
    if(in_array($keyName,$number_array)){
        $finalValue=$value[$keyName]? (float) number_format((float) $value[$keyName],2, '.', ''):"-";
    }else if(in_array($keyName,$date_array)){
      echo $keyName;
      $finalValue=$value[$keyName]? date("Y-m-d",strtotime($value[$keyName])):"-";
    }else{
        $finalValue=$value[$keyName]?$value[$keyName]:"-";
    }
    
    array_push($simple_array,$finalValue);
  }
  $books[]=$simple_array;
}


$current_date_time=date("Y-m-d_H:m:s");
$extra_file_name="Company_List_";
$file_name = $extra_file_name.$current_date_time.".xlsx";

$xlsx = Shuchkin\SimpleXLSXGen::fromArray( $books ,$name="MySheet")->setDefaultFontSize(11);
$xlsx->autoFilter('A1:W1');
$xlsx->downloadAs($file_name);

