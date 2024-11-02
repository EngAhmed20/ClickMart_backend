<?php
include ("../connect.php");
$userid=filterRequest("userid");
getAllData("notification","notification_userid=$userid ORDER BY notification_id DESC");


?>
