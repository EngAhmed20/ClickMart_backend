<?php
include ("../../connect.php");
$table="items";
$items_name=filterRequest("items_name");
$items_name_ar=filterRequest("items_name_ar");
$items_desc=filterRequest("items_desc");
$items_desc_ar=filterRequest("items_desc_ar");
$items_count=filterRequest("items_count");
$items_active=filterRequest("items_active");
$items_price=filterRequest("items_price");
$items_discount=filterRequest("items_discount");
$items_date=date("Y-m-d H:i:s");
$items_categories=filterRequest("items_categories");
$items_rating=filterRequest("items_rating");
$itemImg=imageUpload("../../upload/items","files");
$data=array(
    "items_name"=>$items_name,
    "items_name_ar"=>$items_name_ar,
    "items_desc"=>$items_desc,
    "items_desc_ar"=>$items_desc_ar,
    "items_count"=>$items_count,
    "items_active"=>$items_active,
    "items_price"=>$items_price,
    "items_discount"=>$items_discount,
    "items_date"=>$items_date,
    "items_categories"=>$items_categories ,
    "items_rating"=>$items_rating,
    "items_image"=>$itemImg
);
insertData($table,$data);


?>