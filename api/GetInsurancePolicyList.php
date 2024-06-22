<?php
include("connection.php");
$data = json_decode(file_get_contents("php://input"));

$table_name="ms_insurance_policy";
$search_column=["reg_name","policy_no","vehicle_no"];
$where = "";
$limit=0;
$current_page=0;
$search="";
$order_column="insurance_id";
$order_by="DESC";


if(isset($data->search) && $data->search){
    $search=$data->search;
}

if(isset($data->limit) && $data->limit){
    $limit=$data->limit;
}

if(isset($data->currentPage) && $data->currentPage){
    $current_page=$data->currentPage;
}

if(isset($data->insurance_id) && $data->insurance_id){
    $insurance_id=$data->insurance_id;
    $where=" insurance_id='".$insurance_id."'";
}


$finalColumn = "*";

$leftSql="left join ms_agent on ms_agent.agent_id=ms_insurance_policy.agent_id
left join ms_agent code_agent on code_agent.agent_id=ms_insurance_policy.code_id
left join ms_bank_department  on ms_bank_department.bd_id=ms_insurance_policy.bd_id
left join ms_company_type on ms_company_type.ct_id=ms_insurance_policy.ct_id
left join ms_customer on ms_customer.cust_id=ms_insurance_policy.cust_id
left join ms_fp_tp_type on ms_fp_tp_type.fp_id=ms_insurance_policy.fp_id
left join ms_fuel_type on ms_fuel_type.fuel_id=ms_insurance_policy.fuel_id
left join ms_insurance_type on ms_insurance_type.it_id=ms_insurance_policy.it_id
left join ms_payment_mode on ms_payment_mode.pm_id=ms_insurance_policy.pm_id
left join ms_vehicle on ms_vehicle.vehicle_id=ms_insurance_policy.vehicle_id where 1=1 ";

$sql="SELECT ms_insurance_policy.*,ms_agent.agent_name,code_agent.agent_name as code_agent,
ms_bank_department.bank_dept_name,ms_company_type.company_type_name,ms_customer.vehicle_no,ms_fp_tp_type.fp_type,ms_fuel_type.fuel_type_name,ms_insurance_type.insurance_type_name,ms_payment_mode.pm_name,ms_vehicle.vehicle_type FROM `ms_insurance_policy`
 ".$leftSql;

$sql_count="select count(*)  as total_rows from ms_insurance_policy ".$leftSql;

if(isset($where) && $where){
    $sql = $sql ." and ".$where;
    $sql_count = $sql_count ." and ".$sql_count;
}

if(count($search_column)>0 && isset($search) && $search){
    $searchval=" and (";
    foreach ($search_column as $key => $val) {
        if($key==(count($search_column)-1)){
            $searchval.= " $val like '%$search%' ) ";
        }else{
            $searchval.= " $val like '%$search%' or ";
        }
       
    }
    $sql = $sql.$searchval;
    $sql_count = $sql_count.$searchval;

}

if(isset($order_column) && $order_column){
    $sql = $sql." order by ".$order_column." ".$order_by;
    $sql_count = $sql_count." order by ".$order_column." ".$order_by;
}



if(isset($limit) && isset($current_page) && $limit && $current_page){
 $start=($current_page-1)* $limit;
 $sql = $sql ." limit ".$start.",".$limit;

}

$result = mysqli_query($conn, $sql);
$row = mysqli_num_rows($result);

$total_rows=[];

if($limit && $current_page===1 && !isset($data->insurance_id)){
  
    $result_count = mysqli_query($conn, $sql_count);
    $row_count = mysqli_num_rows($result_count);

    while($row_detail_count=mysqli_fetch_assoc($result_count)){
        $total_rows[] = $row_detail_count;
    }
}


$getQueryData=[];

if($row>0){
    while($row_detail=mysqli_fetch_assoc($result)){
        $row_detail["created_date_time"]= date("d M,Y h:ia", strtotime($row_detail["created_at"]));
        $row_detail["rid"]= date("d M,Y", strtotime($row_detail["rid"]));
        $row_detail["policy_date"]= date("d M,Y", strtotime($row_detail["policy_date"]));
        $getQueryData[] = $row_detail;
    }
}

$data=[
    "status"=>true,
    "message"=>"Insurace Policy  List",
    "Records"=>$getQueryData,
    "total_rows"=>round($total_rows[0]["total_rows"])
];

echo json_encode($data);
?>