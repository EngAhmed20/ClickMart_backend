<?php
include ("../../connect.php");
$table="categories";
$name=filterRequest("cat_name");
$nameAr=filterRequest("cat_name_ar");
$catImg=imageUpload("../../upload/categories","files");
$data=array(
    "categories_name"=>$name,
    "categories_name_ar"=>$nameAr,
    "categories_image"=>$catImg

);
insertData($table,$data);


?>