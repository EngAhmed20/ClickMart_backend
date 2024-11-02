<?php
include"../connect.php";

$userid=filterRequest("userid");
getAllData('orders',"orders_users_id=$userid AND orders_status=4");

//0wait admin accept
//1prepare
//2 delivery 
//3on way
//delivered 

?>