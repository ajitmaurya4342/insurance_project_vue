<?php
include("SimpleXLSXGen.php");
include("connection.php");
$where="company_id>0 ";
$company_title='Company Name';
$current_date_time=date(format: "Y-m-d_H:m:s");

$extra_file_name="Company_";
$file_name = "Credit_Note_".$extra_file_name.$current_date_time.".xlsx";

if(isset($_GET['type'])){
  if($_GET['type'] == 'other'){
    $where = "company_id=0 ";
    $company_title='Name';
    $extra_file_name="Miscellenaous_";
    $file_name = "Credit_Note_".$extra_file_name.$current_date_time.".xlsx";
  }
}

$books = [
    [
      '<center><b><style bgcolor="#6fa8dc" color="#000000">'.$company_title.'</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Amount</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Payment Date</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Payment To</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Description</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Created By</style></b></center>',
      '<center><b><style bgcolor="#6fa8dc" color="#000000">Created User</style></b></center>',
    ]
];




$sqlCompany="SELECT  ms_payment_mode.pm_name,amount,payment_date,description,add_credit_note_company.created_at,ms_company_type.company_type_name,users.name as created_user,ms_insurance_policy.policy_no  from add_credit_note_company
left join ms_company_type on ms_company_type.ct_id = add_credit_note_company.company_id
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_company.pm_id
left join users on users.user_id = add_credit_note_company.created_by
left join ms_insurance_policy on ms_insurance_policy.insurance_id = add_credit_note_company.insurance_id WHERE ".$where." order by add_credit_note_company.c_ref_id DESC";

$result = mysqli_query($conn, $sqlCompany);
$row = mysqli_num_rows($result);


$getQueryData=[];
if($row>0){
    while($row_detail=mysqli_fetch_assoc($result)){
      if($row_detail["policy_no"]){
        $row_detail["description"] = "Created By Insurance (Policy No: ".$row_detail["policy_no"].")";
        }
        if($row_detail["company_type_name"]==""){
          $row_detail["company_type_name"]="Miscellaneous";
      }
        $getQueryData[] = $row_detail;
      
    }
}

$key_name_array=[
    "company_type_name",
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
      $finalValue=$value[$keyName]? date("Y-m-d",strtotime($value[$keyName])):"-";
    }else{
        $finalValue=$value[$keyName]?$value[$keyName]:"-";
    }
    
    array_push($simple_array,$finalValue);
  }
  $books[]=$simple_array;
}





$xlsx = Shuchkin\SimpleXLSXGen::fromArray( $books ,$name="MySheet")->setDefaultFontSize(11);
$xlsx->autoFilter('A1:W1');
$xlsx->downloadAs($file_name);

