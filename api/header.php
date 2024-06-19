<?php
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