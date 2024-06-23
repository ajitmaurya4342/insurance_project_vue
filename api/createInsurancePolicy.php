<?php
include("SimpleXLSXGen.php");
include("connection.php");

$books = [
    ['<center><b><style bgcolor="#6fa8dc" color="#000000">SR. No</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">Company Name</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">RID</style></b></center>', '<center><b><style bgcolor="#6fa8dc" color="#000000">REGISTRATION NO.</style></b></center>', '<center><b><style bgcolor="#6fa8dc" color="#000000">NAME</style></b></center>', '<center><b><style bgcolor="#6fa8dc" color="#000000">POLICY NO</style></b></center>', '<center><b><style bgcolor="#6fa8dc" color="#000000">HP</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">AGENT</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">SELF CONTACT</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">DATE</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">PREMIUM</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">GST</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">NET PREMIUM</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">IDV</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">FUEL TYPE</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">CODE ID</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">PAYMENT MODE</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">TYPES OF VEHICLS</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">FP/TP</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">PRIVATE/COMMERCIAL</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">Created By</style></b></center>','<center><b><style bgcolor="#6fa8dc" color="#000000">Created Time</style></b></center>'],
];

$data = (object) ($_REQUEST);

$key_name_array=[
    "sr_no",
    "company_type_name",
    "rid",
    "vehicle_no",
    "reg_name",
    "policy_no",
    "bank_dept_name",
    "agent_name",
    "agent_no",
    "policy_date",
    "premium",
    "gst",
    "net_premium",
    "idv",
    "fuel_type_name",
    "code_agent",
    "pm_name",
    "vehicle_type",
    "fp_type",
    "insurance_type_name",
    "created_user",
    "created_at",
];

$number_array=["premium","gst","net_premium","idv"];

include("GetInsurancePolicyDataAll.php");

foreach($getQueryData as $idx=>$value){
    $simple_array=[];
  foreach($key_name_array as $index2=>$keyName){
    if($index2==0){
        $finalValue=$idx+1;
    }else if(in_array($keyName,$number_array)){
        $finalValue=$value[$keyName]? (float) number_format((float) $value[$keyName],2, '.', ''):"-";
    }else{
        $finalValue=$value[$keyName]?$value[$keyName]:"-";
    }
    
    array_push($simple_array,$finalValue);
  }
  $books[]=$simple_array;
}

$current_date_time=date("Y-m-d_H:m:s");
$extra_file_name="";
if($ct_id){
  $extra_file_name=str_replace(".","_",$simple_array[1]);
  $extra_file_name=str_replace(" ","_",$extra_file_name);
}
$file_name = "Insurance_".$extra_file_name.$current_date_time.".xlsx";

$xlsx = Shuchkin\SimpleXLSXGen::fromArray( $books ,$name="MySheet")->setDefaultFontSize(12);
$xlsx->autoFilter('A1:V1');
$xlsx->downloadAs($file_name);

