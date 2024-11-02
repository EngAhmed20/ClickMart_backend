<?php
include"../connect.php";

$userid=filterRequest("userid");
getAllData('orders',"orders_users_id=$userid AND orders_status!=4");


?>