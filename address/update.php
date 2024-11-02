<?php
include "../connect.php";
$addressid=filterRequest('addressid');
$city=filterRequest('city');
$street=filterRequest('street');
$lat=filterRequest('lat');
$long=filterRequest('long');
$address_name=filterRequest('address_name');

$data=array(
   'address_city'=>$city,
   'address_street'=>$street,
   'address_lat'=>$lat,
   'address_name'=>$address_name,
   'address_long'=>$long,);
updateData('address',$data,"address_id=$addressid");
?>