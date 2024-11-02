<?php
include("../connect.php");

$username=filterRequest("username");
$password=sha1($_POST['password']);
$email=filterRequest("email");
$phone=filterRequest("phone");
$verifycode="11111";
$stmt= $con->prepare("SELECT * FROM delivery WHERE delivery_email=? OR delivery_phone=?");
$stmt->execute(array($email,$phone));
$count=$stmt->rowCount();
if($count>0){
    printFailure("phone or email exist");
}
else{
    $data=array(
        "delivery_name"=>"$username",
        "delivery_email"=> "$email",
        "delivery_phone"=> "$phone",
        "delivery_verifycode"=>"$verifycode",
        "delivery_password"=>"$password",
    );
    //sendMail($email,"verify code","verify code $verifycode");
    insertData("delivery",$data);
}
?>