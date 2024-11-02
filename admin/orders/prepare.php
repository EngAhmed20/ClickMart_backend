<?php
include "../../connect.php";
$orderid=filterRequest("orderid");
$userid=filterRequest("userid");
$ordertype=filterRequest('ordertype');
if($ordertype=='home delivery')
{
    $data=array(
        "orders_status"=>2
    );
}else{
    $data=array(
        "orders_status"=>4
    );

}

updateData("orders",$data,"orders_id=$orderid AND orders_status=1");
//sendFCMNotification("Order Status","your order is being prepared","","refreshorderpending","users$userid");
insertNotification("Order Status","your order is being prepared",$userid,"","refreshorderpending","users$userid");


?>