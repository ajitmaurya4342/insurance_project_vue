<?php
include("connection.php");
$data = json_decode(file_get_contents("php://input"));
$select_all_payment="SELECT pm_id FROM ms_payment_mode where pm_id>3";
$result = mysqli_query($conn, $select_all_payment);
$array=[];
  
if(mysqli_num_rows($result)>0){
    while($row_detail=mysqli_fetch_assoc($result)){
        $balance=0;

        //Agent
        $sql_agent = "SELECT sum(-1 * amount) as agent_amount FROM add_credit_note_agent where pm_id='".$row_detail['pm_id']."' and insurance_id is null";

        $result_agent = mysqli_query($conn, $sql_agent);
        $row_agen=mysqli_fetch_assoc( $result_agent);
      
        if($row_agen["agent_amount"]){
            $balance = $balance + $row_agen["agent_amount"];
        }
        $row_detail["agent"] = $row_agen["agent_amount"]?$row_agen["agent_amount"]:0;

        //Company
        $sql_company = "SELECT sum(IF(company_id>0,-1 * amount,amount)) as company_amount FROM add_credit_note_company where pm_id='".$row_detail['pm_id']."' and insurance_id is null";
        $result_company= mysqli_query($conn, query: $sql_company);
        $row_company=mysqli_fetch_assoc( $result_company);
        
        if($row_company["company_amount"]){
            $balance = $balance + $row_company["company_amount"];
        }
        $row_detail["company"] = $row_company["company_amount"]?$row_company["company_amount"]:0;

        //Insurance
        $sql_premium = "SELECT sum(-1 * premium) as premium_amount FROM ms_insurance_policy where pm_id='".$row_detail['pm_id']."'";
        $result_premium= mysqli_query($conn, query: $sql_premium);
        $row_premium=mysqli_fetch_assoc( $result_premium);
        
        if($row_premium["premium_amount"]){
            $balance = $balance + $row_premium["premium_amount"];
        }
        $row_detail["insurance"] = $row_premium["premium_amount"]?$row_premium["premium_amount"]:0;
        $row_detail["balance"] = $balance;

        $editpayment= "update ms_payment_mode set balance='".$balance."' where pm_id='".$row_detail['pm_id']."'";
        $result_premium= mysqli_query($conn, query: $editpayment);
        
        $array[] = $row_detail;
     
    }
}



$data=[
    "status"=>true,
    "message"=>"Payment Balance Sync Successfully",
    "Records"=>$array,
];

echo json_encode($data);
?>