<?php
include("../connect.php");
$email=filterRequest("email");
$password=sha1($_POST['password']);
getData("users","`users_email`=? AND `users_password`=?",array($email,$password));

?>