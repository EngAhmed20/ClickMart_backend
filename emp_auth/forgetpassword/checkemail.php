<?php
include "../../connect.php";
$email=filterRequest("email");
//$verifycode =rand(00000,99999);
$verifycode="22222";
$stmt=$con->prepare("SELECT * FROM delivery WHERE delivery_email=?");
$stmt->execute(array($email));
$count=$stmt->rowCount();
if($count>0){
    $data=array(
        "delivery_verifycode"=>$verifycode
    );
    //sendMail($email,"verifycode","code $verifycode");
    //printSuccess();
    updateData("delivery",$data,"delivery_email='$email'");
}else{
    printFailure();
}





















?>