<?php
include "../../connect.php";
$orderid=filterRequest("orderid");
$userid=filterRequest("userid");
$delivery_id=filterRequest("delivery_id");
$data=array(
    "orders_status"=>4
);
updateData("orders",$data,"orders_id=$orderid AND orders_status=3 AND orders_delivery=$delivery_id");
//sendFCMNotification("Order Status","your order is being prepared","","refreshorderpending","users$userid");
insertNotification("Order Status","your order has been delivered",$userid,"","refreshorderpending","users$userid");


?>