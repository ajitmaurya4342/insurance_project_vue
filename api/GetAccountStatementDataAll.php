<?php

$where = "";
$limit = 0;
$current_page = 0;
$search = "";

$ct_id = "";
$agent_id = "";
$pm_id = "";
$from_date = "";
$to_date = "";
$order_column = "";
$order_by = "";

$search_column_agent = [
    "amount",
    "ms_payment_mode.pm_name",
    "ms_agent.agent_name",
    "description",
];
$search_column_company = [
    "amount",
    "ms_payment_mode.pm_name",
    "ms_company_type.company_type_name",
    "description",
];
$search_column_insurance = [
    "premium",
    "ms_payment_mode.pm_name",
    "ms_insurance_policy.policy_no",
];

if (isset($data->search) && $data->search) {
    $search = $data->search;
}

if (isset($data->limit) && $data->limit) {
    $limit = $data->limit;
}

if (isset($data->currentPage) && $data->currentPage) {
    $current_page = $data->currentPage;
}

$from_date = $data->from_date;
if (isset($data->to_date) && $data->to_date) {
    $to_date = $data->to_date;
} else {
    $to_date = $from_date;
}

$sqlFinal = "";
// Comany Type

$sqlTotal = "";
if (isset($data->ct_id) && $data->ct_id) {
    $ct_id = $data->ct_id;
    $sqlTableJoin = "left join ms_company_type on ms_company_type.ct_id = add_credit_note_company.company_id
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_company.pm_id
left join ms_insurance_policy on ms_insurance_policy.insurance_id = add_credit_note_company.insurance_id where  company_id = '".$ct_id."' ";

    $sqlFinal =
        "SELECT ms_payment_mode.pm_id, ms_company_type.ct_id as id,ms_payment_mode.pm_name,amount,payment_date,description,add_credit_note_company.created_at,'add_credit_note_company' as type,c_ref_id as type_id,ms_company_type.company_type_name,ms_insurance_policy.policy_no  from add_credit_note_company " .
        $sqlTableJoin ;

        $sqlTotal = "select count(*)  as total_rows from add_credit_note_company ".$sqlTableJoin;

    if (count($search_column_company) > 0 && isset($search) && $search) {
        $searchval = " and (";
        foreach ($search_column_company as $key => $val) {
            if ($key == count($search_column_company) - 1) {
                $searchval .= " $val like '%$search%' ) ";
            } else {
                $searchval .= " $val like '%$search%' or ";
            }
        }
        $sqlFinal = $sqlFinal . $searchval;
        $sqlTotal = $sqlTotal . $searchval;
    }

    $sql_date =  " and (Date(add_credit_note_company.payment_date) between '" .
    $from_date .
    "' and '" .
    $to_date .
    "')";

    $sqlFinal = $sqlFinal .$sql_date;
    $sqlTotal = $sqlTotal .$sql_date;


}

if (isset($data->agent_id) && $data->agent_id) {
    $agent_id = $data->agent_id;

    $ct_id = $data->ct_id;
    $sqlTableJoin = "left join ms_agent on ms_agent.agent_id = add_credit_note_agent.agent_id
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_agent.pm_id
left join ms_insurance_policy on ms_insurance_policy.insurance_id = add_credit_note_agent.insurance_id where  add_credit_note_agent.agent_id = '".$agent_id."' ";

    $sqlFinal =
        "SELECT ms_payment_mode.pm_id, ms_agent.agent_id as id,ms_payment_mode.pm_name,amount,payment_date,description,add_credit_note_agent.created_at,a_ref_id as type_id,ms_agent.agent_name,ms_insurance_policy.policy_no from  add_credit_note_agent " .
        $sqlTableJoin ;

        $sqlTotal = "select count(*)  as total_rows from add_credit_note_agent ".$sqlTableJoin;

    if (count($search_column_agent) > 0 && isset($search) && $search) {
        $searchval = " and (";
        foreach ($search_column_agent as $key => $val) {
            if ($key == count($search_column_agent) - 1) {
                $searchval .= " $val like '%$search%' ) ";
            } else {
                $searchval .= " $val like '%$search%' or ";
            }
        }
        $sqlFinal = $sqlFinal . $searchval;
        $sqlTotal = $sqlTotal . $searchval;
    }

    $sql_date =  " and (Date(add_credit_note_agent.payment_date) between '" .
    $from_date .
    "' and '" .
    $to_date .
    "')";

    $sqlFinal = $sqlFinal .$sql_date;
    $sqlTotal = $sqlTotal .$sql_date;

   
}

if (isset($data->pm_id) && $data->pm_id) {
    $pm_id = $data->pm_id;
    $wherepayment =" where (Date(payment_date) between '" .
    $from_date .
    "' and '" .
    $to_date .
    "')  ";

    $whereAgent =  $wherepayment . " and add_credit_note_agent.insurance_id is null and add_credit_note_agent.pm_id = '".$pm_id."'";
    $whereCompany =  $wherepayment. " and add_credit_note_company.insurance_id is null and add_credit_note_company.pm_id = '".$pm_id."'";
    $whereInsurance =  " where (Date(policy_date) between '" .
    $from_date .
    "' and '" .
    $to_date .
    "')  and ms_insurance_policy.pm_id = '".$pm_id."'";

    if (count($search_column_agent) > 0 && isset($search) && $search) {
        $searchval = " and (";
        foreach ($search_column_agent as $key => $val) {
            if ($key == count($search_column_agent) - 1) {
                $searchval .= " $val like '%$search%' ) ";
            } else {
                $searchval .= " $val like '%$search%' or ";
            }
        }
        $whereAgent = $whereAgent . $searchval;
    }

    if (count($search_column_company) > 0 && isset($search) && $search) {
        $searchval = " and (";
        foreach ($search_column_company as $key => $val) {
            if ($key == count($search_column_company) - 1) {
                $searchval .= " $val like '%$search%' ) ";
            } else {
                $searchval .= " $val like '%$search%' or ";
            }
        }
        $whereCompany = $whereCompany . $searchval;
    }

    if (count($search_column_insurance) > 0 && isset($search) && $search) {
        $searchval = " and (";
        foreach ($search_column_insurance as $key => $val) {
            if ($key == count($search_column_insurance) - 1) {
                $searchval .= " $val like '%$search%' ) ";
            } else {
                $searchval .= " $val like '%$search%' or ";
            }
        }
        $whereInsurance = $whereInsurance . $searchval;
    }


    $sqlFinal="
    SELECT pm_name,policy_date as payment_date,-1*premium as amount,NULL as description,policy_no,'Insurance' as name,insurance_id as main_id,'Premium' as type_name from ms_insurance_policy
left join ms_payment_mode on ms_payment_mode.pm_id=ms_insurance_policy.pm_id ".$whereInsurance."
UNION ALL
    SELECT pm_name,payment_date,-1*amount as amount,description,NULL as policy_no,ms_agent.agent_name as name,ms_agent.agent_id as main_id,'Agent' as type_name FROM `add_credit_note_agent` 
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_agent.pm_id
left join ms_agent on ms_agent.agent_id = add_credit_note_agent.agent_id ".$whereAgent."
UNION ALL
SELECT pm_name,payment_date,IF(add_credit_note_company.company_id > 0,-1*amount,amount) as amount,description,NULL as policy_no,IF(add_credit_note_company.company_id >0, ms_company_type.company_type_name,'Miscellenaous') as name,ms_company_type.ct_id as main_id,
IF(add_credit_note_company.company_id >0, 'Company','Other') as type_name FROM `add_credit_note_company` 
left join ms_payment_mode on ms_payment_mode.pm_id = add_credit_note_company.pm_id
left join ms_company_type on ms_company_type.ct_id = add_credit_note_company.company_id ".$whereCompany;

$sqlTotal="SELECT  COUNT(*) as total_rows From ( ";
$sqlTotal= $sqlTotal. $sqlFinal." ) as total_rows";


}

$order_column = "payment_date";
$order_by = "ASC";

if (isset($order_column) && $order_column) {
    $sqlFinal = $sqlFinal . " order by " . $order_column . " " . $order_by;
}

if (isset($limit) && isset($current_page) && $limit && $current_page) {
    $start = ($current_page - 1) * $limit;
    $sqlFinal = $sqlFinal . " limit " . $start . "," . $limit;
}

$result = mysqli_query($conn, $sqlFinal);
$row = mysqli_num_rows($result);

$total_rows=[];

if($limit && $current_page===1 && !isset($data->insurance_id)){
  
    $result_count = mysqli_query($conn, $sqlTotal);
    $row_count = mysqli_num_rows($result_count);

    while($row_detail_count=mysqli_fetch_assoc($result_count)){
        $total_rows[] = $row_detail_count;
    }
}

$getQueryData = [];

if ($row > 0) {
    while ($row_detail = mysqli_fetch_assoc($result)) {
        if($row_detail["policy_no"]){
            $row_detail["description"] = "Created By Insurance (Policy No: ".$row_detail["policy_no"].")";
        }
        $getQueryData[] = $row_detail;
    }
}

?>
