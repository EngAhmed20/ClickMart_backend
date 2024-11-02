<?php
include ("../connect.php");
$orderid=filterRequest("orderid");
$orderrating=filterRequest("orderrating");
$ratingnote=filterRequest("ratingnote");

$data=array(
    'orders_rating'=>$orderrating,
    'orders_noterating'=>$ratingnote,
);
updateData("orders",$data,"orders_id=$orderid");


?>