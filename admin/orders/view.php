<?php
include"../../connect.php";
$orderState=filterRequest("orderState");
getAllData('orders',"orders_status=$orderState");


?>