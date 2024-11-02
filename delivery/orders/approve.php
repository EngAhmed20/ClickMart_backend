<?php
include "../../connect.php";
$orderid=filterRequest("orderid");
$userid=filterRequest("userid");
$delivery_id=filterRequest("deliveryid");
$data=array(
    "orders_status"=>3,
    "orders_delivery"=>$delivery_id
);
updateData("orders",$data,"orders_id=$orderid AND orders_status=2");
//sendFCMNotification("Order Status","your order is being prepared","","refreshorderpending","users$userid");
insertNotification("Order Status","your order is on the way",$userid,"","refreshorderpending","users$userid");


?>
