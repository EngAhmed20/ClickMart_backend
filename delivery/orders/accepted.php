<?php
include"../../connect.php";
$id=filterRequest("id");
getAllData('orders_view',"orders_status=3 AND orders_delivery=$id");
?>