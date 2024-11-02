<?php
include("connect.php");
$alldata=array();
$categories=getAllData("categories",null,null,false);
$alldata['status']='success';

$alldata['categories']=$categories;
$stmt =$con->prepare("SELECT top_sell.* , (items_price-(items_price*items_discount /100)) AS items_price_discount FROM top_sell
 WHERE 1=1 ORDER BY count_items DESC");
$stmt->execute();
$data=$stmt->fetchAll(PDO::FETCH_ASSOC);
$alldata['items']=$data;
$settings=getDatawithoutPrint("text_settings","text_id !=0",null,false);
$alldata['text']=$settings;

echo json_encode($alldata);

?>