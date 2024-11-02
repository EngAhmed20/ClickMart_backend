<?php
include("../connect.php");
$notificationid=filterRequest("notificationid");
deleteData("notification","notification_id= '$notificationid'");

?>