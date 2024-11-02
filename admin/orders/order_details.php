<?php
include "../../connect.php";
$orderid=filterRequest("orderid");
getAllData("orderdetails_view","cart_orders=$orderid" )

?>