<?php
include("SimpleXLSXGen.php");
include("connection.php");

$books = [
    [
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Agent Name</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Amount</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Payment Date</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Payment To</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Description</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Created By</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Created User</style></b></center>',
    ]
];


$sqlCompany="SELECT  ms_payment_mode.pm_name,amount,payment_date,description,add_credit_note_agent.created_at,ms_agent.agent_name,users.name as created_user  from add_credit_note_agent
left join ms_agent on ms_agent.agent_id = add_credit_note_agent.agent_id
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_agent.pm_id
left join users on users.user_id = add_credit_note_agent.created_by
where insurance_id is null ";

$result = mysqli_query($conn, $sqlCompany);
$row = mysqli_num_rows($result);


$getQueryData=[];
if($row>0){
    while($row_detail=mysqli_fetch_assoc($result)){
        $getQueryData[] = $row_detail;
      
    }
}

$key_name_array=[
    "agent_name",
    "amount",
    "payment_date",
    "pm_name",
    "description",
    "created_user",
    "created_at",
];

$number_array=["amount"];
$date_array=["payment_date"];

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
$extra_file_name="Agent_";
$file_name = "Credit_Note_".$extra_file_name.$current_date_time.".xlsx";

$xlsx = Shuchkin\SimpleXLSXGen::fromArray( $books ,$name="MySheet")->setDefaultFontSize(11);
$xlsx->autoFilter('A1:W1');
$xlsx->downloadAs($file_name);

