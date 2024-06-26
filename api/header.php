<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
$headers = apache_request_headers();
$created_user_id="";
if(count($headers)){
    if(isset($headers["authorization"]) && $headers["authorization"]){
        $created_user_id=explode("=====",base64_decode($headers["authorization"]))[0];
    }  
}


function insertQuery($table, $data, $conn)
{
    $key = implode(",", array_keys($data));
    $value = "'" . implode("','", array_values($data)) . "'";
    $sqlQuery = "INSERT INTO $table ($key) VALUES ($value)";
    $result = mysqli_query($conn, $sqlQuery);
    if ($result) {
        return mysqli_insert_id($conn);
    } else {
        return false;
    }
}

function updateQuery($table, $data, $where, $conn)
{
    $cols = [];
    foreach ($data as $key => $val) {
        $cols[] = "$key = '$val'";
    }
    $sql = "UPDATE $table SET " . implode(", ", $cols) . " WHERE $where";
    $result = mysqli_query($conn, $sql);
    return true;
}

function getQuery($conn,$table_name,$column=[],$where,$search="",$search_column=[],$order_column="",$order_by="ASC",$limit="",$current_page=""){

    $finalColumn = "*";
    if(count($column)>0){
        $finalColumn = implode(", ", $column);
    }

    $sql="Select ".$finalColumn." from ".$table_name." where 1=1  ";
 
    if(isset($where) && $where){
        $sql = $sql ." and ".$where;
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
        $sql = $sql .$searchval;
    
    }

    if(isset($order_column) && $order_column){
        $sql = $sql." order by ".$order_column." ".$order_by;
    }
  
    if(isset($limit) && isset($current_page) && $limit && $current_page){
     $start=($current_page-1)* $limit;
     $sql = $sql ." limit ".$start.",".$limit;
    }
 
    $result = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($result);

    $array=[];
  
    if($row>0){
        while($row_detail=mysqli_fetch_assoc($result)){
            $array[] = $row_detail;
          
        }
    }
    
    return $array;
}

function checkValidation($dataArray,$dataValue){
   
    $error=[];
    $dataValueArray= json_decode(json_encode($dataValue),true);

    foreach($dataArray as $val) {

        if(!isset($dataValueArray[$val]) || !$dataValueArray[$val]){
         $error =[
            "status"=>false,
            "message"=>$val . " cannot be empty or undefined"
         ];
        }
    }
    return $error;

}

?>