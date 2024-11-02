<?php
define('MB',1048576);
date_default_timezone_set("Africa/Cairo");
function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null,$json=true)
{
    global $con;
    $data = array();
    if($where==null){
        $stmt = $con->prepare("SELECT  * FROM $table ");

     }else{
        $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");

    }
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
   if($json==true){
    if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    return $count;
   }else{
    if($count>0){
        return $data;
    }else{
        return json_encode(array("status" => "failure"));

    }
   }
}
function getData($table, $where = null, $values = null,$json=true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if($json==true)
    {
    if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
}else{
    return $count;

}

}
function getDatawithoutPrint($table, $where = null, $values = null,$json=true)
{
    global $con;
    $data = array();
    if($where==null){
        $stmt = $con->prepare("SELECT  * FROM $table ");

     }else{
        $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");

    }
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
   if($json==true){
    if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    return $count;
   }else{
    if($count>0){
        return $data;
    }else{
        return json_encode(array("status" => "failure"));

    }
   }
}


function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
    return $count;
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($dir,$imageRequest)
{
  global $msgError;
  if(isset(($_FILES[$imageRequest])))
  {
    $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
    $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
    $imagesize  = $_FILES[$imageRequest]['size'];
    $allowExt   = array("jpg", "png", "gif", "mp3", "pdf","svg","jpeg");
    $strToArray = explode(".", $imagename);
    $ext        = end($strToArray);
    $ext        = strtolower($ext);
  
    if (!empty($imagename) && !in_array($ext, $allowExt)) {
      $msgError = "EXT";
    }
    if ($imagesize > 2 * MB) {
      $msgError = "size";
    }
    if (empty($msgError)) {
      move_uploaded_file($imagetmp,$dir."/".$imagename);
      return $imagename;
    } else {
      return "fail";
    }

  }
  else {
    return "empty";
  }

}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir."/".$imagename)) {
        unlink($dir."/".$imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

    // End 

}
function printFailure($message="none"){
   echo json_encode(array('status'=> 'failure','message'=>$message));
 }
 function printSuccess($data="none"){
    echo json_encode(array('status'=> 'success','data'=>$data));
  }
/*function sendMail($to,$title,$body)
{
    $header="From: Ahmed12@gmail.com"."\n"."CC:engahmed@gmail.com";
    mail($to,$title,$body,$header);
}*/
function sendGCM($title, $message,$topic, $pageid, $pagename,$token)
{


    $url = 'https://fcm.googleapis.com/v1/projects/ecommerce-php-96f36/messages:send';

    $fields = array(
        "to" => '/topics/' . $topic,
        'priority' => 'high',
        'content_available' => true,

        'notification' => array(
            "body" =>  $message,
            "title" =>  $title,
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "sound" => "default"

        ),
        'data' => array(
            "pageid" => $pageid,
            "pagename" => $pagename
        )

    );


    $fields = json_encode($fields);
    $headers = array(
        'Authorization: Bearer '."ya29.c.c0ASRK0GYjbQp5s-jTa3VBWE5FbMTFL4M2WLKI3Elri7NYcVksCWmTnS9Gz4SNuGMfjH01cdgWShOUevwaOI-n0auiQfRk3CW2QDSm7IXS5_Cg_G57Z5y7dYMvpLXrXs0W7smt_PnhPotyssvADVLFg89YbhCsYj606OoLcW1jV6zI38Ui_k3l7hWEeOJGb5IqFrhO6d2MBo_HOIsyyV7pIo-jGDjQw03J0AQKRud3X25HsNxRDkH5zeZw1mTnawwJSDvF1NzojYeE9-rNrN4OBfHG3k_pCaBpwNRtlMHS1BdEyfqoevs-LzN0-o6jduiv6Ke6WCe6s1Myww07Ukq0ssW_RHYvCZ7peDsHM381IwvAYf0-r23uO8nz4LRvE389CpcgJV-JQIMV79I3M8ZUz4oROpJWat-j57trIdO_Muux3k1-grIUIYvZB6XI0lwF3rIaO7_VUnb_SS5YWYVuYtsW4ScYqof2p1U2j32Yb0wqgWq9dq4iwSl5qIYmSrxm2kiqBonFbQ7c_0lUwWV_3Xpa81ev-2jYi6ygmY9-UXi8YWRWa0tt5uyS7aa7-bVX9XzduinRRpsjSmn2xzMR-Wl7cIryamV_QlbUXzkso4Y8jIXYJF08yU7mt334fx24atyFFuaqbkfQ3teI0F8ryBIf2cU3u43aYhnBsr9SyxSkRic_seBYaUyutiRw6f-3B-9c8Bec9VX6iz1g_BI5Fa7RlXj72tww8M-fsB6b3XWkJqxjVQ57yYei8qqlXJl8I2nzs-zQ6yQJBfkjOjF18qhp0faOzYvehfJXe3V6Us5p63g5-5Zmebkp95JuichZj21Y1rYmte-Vi9Xftsvucq_O60s0mQr4geJ1x4xJhwdqnoWQjVqZXoq8jQVhZOJXvJw6jSer0apgZqIsQ7Q6WqS_fJ0h2nfOdf85o2aee1vBXu5bg3_5w0X",
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    return $result;
    curl_close($ch);

}
function sendFCMNotification($title, $body, $pageid, $pagename,$topic,) {
    // FCM API URL
    $url = 'https://fcm.googleapis.com/v1/projects/ecommerce-php-96f36/messages:send';
    
    //$serverKey = 'YOUR_SERVER_KEY'; // Replace with your actual server key from Firebase
    
    // Prepare the payload
    $payload = json_encode([
        "message" => [
            "topic" => $topic,
            
            "notification" => [
                "title" => $title,
                "body" => $body
            ],
            "android" => [
                "notification" => [
                    "notification_priority" => "PRIORITY_MAX",
                    "sound" => "default"
                ]
            ],
            "apns" => [
                "payload" => [
                    "aps" => [
                        "content_available" => true
                    ]
                ]
            ],
            "data" => [
                "pageid" => $pageid,
                "pagename" => $pagename,
                "click_action" => "FLUTTER_NOTIFICATION_CLICK"
            ]
        ]
    ]);

    // Initialize cURL
    $ch = curl_init();
    
    // Set the headers
    $headers = [
        'Authorization: Bearer ' . "ya29.c.c0ASRK0GaxXvMDSRZB-EZw-GIARbGjI5-7oH1VWn9G3g9WxWM05RKpYe3FkzxPgH6YQNZbcHdWBD1ciRkld8-HyWIT1Mzv3O6yhJD8a_D8EkzQJWdqUJjTuKp-DQ6iG3-8uUdumYG9RDsq8TRzq1krE5UgLElrQUndUZVLAve0H2IW0sIq0yQQ4nmWDvoXTFNE8sDSt0A1T_O2YFjLUnO3mtL1gEn3F-sI7Td57P7jjJDRE7oPBKQ13dak7R_nqZG3tCVHsV44ZctknNVy0mqHPVhMe1_C8yZ0H86NaLRx8iUcDDvrNLfgaY9StcB85fQHcAezXCrgUH9rVBmvm6WXR4e_T_d7Ta4q0eeXDq5GpY33FpXL1W7q44scyNciH389KJYkIiSdXbO98YJwxYpymm91SX3_Xwxssxvfjg55jQ6yI3JV53Iq_t-SRXyQW4YmZY7jU88_6BxZlpyO4lFQ6je5iUr9FdBdkU-9fB0ws3_0n0fh14Sfc74SOfizmrmjZRr19ieJQi81Xdz2uWYejOVimclOUzZ0jsR0shM7e-Vsiz-M2wSenlwFscFIMVz0tf7OJfUe4x4jJ-a-Obwsh1WhgQnF6UMhxWocnSirW37tdSZlBtMzbUm6geXOOc5Q40tVwe9sOuu-uyhYXa8UdUJtUO6-JJz-asuwnvXvnB-fYSkUkyf4eeXMerdjF1ysRSdUwm4BB2yQc5iwQsghYVsXig0zveJshJ4ybiMz4bJjbwO9hS07Z_O0RORagu59Wil5ha46ybIr7MeRSfxUImbro2WeVb-qYvu1UcQmZlbnjwe9wadYjeOyOIR6RZ9j3e3MewqqsuJw1q3QhofMUghvrZh5FRddZYqkl7cuqSv2XfaSQOpXmZkIOahy5aJ9gvSbQI0JcY2a5Qnoqy6pQ0WeO7hz6rk6wwRVtzpOJYpWYYXfcI_4Ff2djaybbhaukVMdQy-__cJeuSapRIMfy_m9fyBuQzJ8nxOBbJMq",
        'Content-Type: application/json',
    ];
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if ($response === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }

    // Close the connection
    curl_close($ch);

    // Return the response
    return $response;
}
////insert notification into database and send notification to app
function insertNotification($title,$body,$userid,$pageid,$pagename,$topic){
    global $con;
    $stmt=$con->prepare("INSERT INTO `notification`(`notification_title`, `notification_body`, `notification_userid`) VALUES (?,?,?)");
    $stmt->execute(array($title,$body,$userid));
    $count=$stmt->rowCount();
    sendFCMNotification($title,$body,$pageid,$pagename,$topic);
    return $count;

}
?>