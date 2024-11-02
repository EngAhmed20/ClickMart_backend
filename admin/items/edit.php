<?php
include ("../../connect.php");
$id=filterRequest("id");
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
$oldimg=filterRequest("oldimg");
$img=imageUpload("../../upload/items","files");
if($img=="empty"){
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
    );
}else{
    deleteFile("../../upload/categories",$oldimg);
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
        "items_image"=>$img,

    );

}
updateData($table,$data,"items_id=$id");




?>