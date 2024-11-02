<?php
include "../connect.php";
$usersid=filterRequest('usersid');
$city=filterRequest('city');
$address_name=filterRequest('address_name');
$street=filterRequest('street');
$lat=filterRequest('lat');
$long=filterRequest('long');
$data=array(
   'address_usersid'=>$usersid,
   'address_city'=>$city,
   'address_street'=>$street,
   'address_lat'=>$lat,
   'address_name'=>$address_name,
   'address_long'=>$long,);
insertData('address',$data);



?>