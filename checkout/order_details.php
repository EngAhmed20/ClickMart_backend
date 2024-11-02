<?php
include "../connect.php";
$userid=filterRequest("userid");
$orderid=filterRequest("orderid");
getAllData("orderdetails_view","cart_orders=$orderid AND cart_usersid=$userid " )

?>