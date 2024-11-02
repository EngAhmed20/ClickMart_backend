<?php
include("../connect.php");

$username=filterRequest("username");
$password=sha1($_POST['password']);
$email=filterRequest("email");
$phone=filterRequest("phone");
$verifycode="11111";
$stmt= $con->prepare("SELECT * FROM users WHERE users_email=? OR users_phone=?");
$stmt->execute(array($email,$phone));
$count=$stmt->rowCount();
if($count>0){
    printFailure("phone or email exist");
}
else{
    $data=array(
        "users_name"=>"$username",
        "users_email"=> "$email",
        "users_phone"=> "$phone",
        "users_verifycode"=>"$verifycode",
        "users_password"=>"$password",
    );
    //sendMail($email,"verify code","verify code $verifycode");
    insertData("users",$data);
}
?>