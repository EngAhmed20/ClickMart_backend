<?php
include "../../connect.php";
$orderid=filterRequest("orderid");
$userid=filterRequest("userid");
$data=array(
    "orders_status"=>1
);
updateData("orders",$data,"orders_id=$orderid AND orders_status=0");
//sendFCMNotification("Order Status","your order is being prepared","","refreshorderpending","users$userid");
insertNotification("Order Status","your order is being prepared",$userid,"","refreshorderpending","users$userid");


?>