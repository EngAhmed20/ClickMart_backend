<?php
include ("../connect.php");
$orderid=filterRequest("orderid");
deleteData("orders","orders_id=$orderid")


?>