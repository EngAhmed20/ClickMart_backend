<?php
include "../connect.php";
$email=filterRequest("email");
//$verifycode =rand(00000,99999);
$verifycode="22222";
$stmt=$con->prepare("SELECT * FROM users WHERE users_email=?");
$stmt->execute(array($email));
$count=$stmt->rowCount();
if($count>0){
    $data=array(
        "users_verifycode"=>$verifycode
    );
    //sendMail($email,"verifycode","code $verifycode");
    //printSuccess();
    updateData("users",$data,"users_email='$email'");
}else{
    printFailure();
}



?>