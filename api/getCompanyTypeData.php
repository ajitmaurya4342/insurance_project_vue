<?php


$table_name="ms_company_type";
$column=["company_type_name","seller_type","ct_id","company_address","company_phone","(select IF(sum(amount) is null,0,sum(amount))  from add_credit_note_company where company_id=ct_id) as balance_amount "];
$search_column=["company_type_name","seller_type","company_address","company_phone"];
$where = "";
$limit=0;
$current_page=0;
$search="";
$order_column="ct_id";
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

if(isset($data->ct_id) && $data->ct_id){
    $ct_id=$data->ct_id;
    $where=" ct_id='".$ct_id."'";
}

@$getQueryData=getQuery($conn,$table_name,$column,$where,$search,$search_column,$order_column,$order_by,$limit,$current_page);

?>