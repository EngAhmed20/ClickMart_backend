<?php
include ("../../connect.php");
$table="categories";
$name=filterRequest("cat_name");
$nameAr=filterRequest("cat_name_ar");
$id=filterRequest("id");
$oldimg=filterRequest("oldimg");
$img=imageUpload("../../upload/categories","files");
if($img=="empty"){
    $data=array(
        "categories_name"=>$name,
        "categories_name_ar"=>$nameAr,
    );
}else{
    deleteFile("../../upload/categories",$oldimg);
    $data=array(
        "categories_name"=>$name,
        "categories_name_ar"=>$nameAr,
        "categories_image"=>$img,

    );

}
updateData($table,$data,"categories_id=$id");




?>