<?php
$enterpriseId = "ccd3b1f498be4c21a30a938fe400ce64";
$enterpriseSecret = "c54dad24bffb4881adb2b12c76d7a2e0";

function sendLoginMsg($enterpriseId, $enterpriseSecret) {
    $data = array(
        "data" => 
            array("enterprise_id" => $enterpriseId,
                  "enterprise_secret" =>  $enterpriseSecret,
                  "prefetch_count" => 50),
        "cmd"=> "enterprise_login_req"
    );
    $msg = strval(json_encode($data)."\n");
    return $msg;
}

$msg = sendLoginMsg($enterpriseId, $enterpriseSecret);

$fp = stream_socket_client("ssl://noti.gizwits.com:2015", $errno, $errstr, 30) or die("error!");  
fwrite($fp, $msg);  
$response = "";
while (!feof($fp) ) {  
    $r = fgets($fp, 1024);  
    $response .= $r;  
    //处理这一行  
}  
print_r($response);


$msg = "{\"cmd\": \"enterprise_ping\"}\n";
fwrite($fp, $msg);  
$result = "";
while (!feof($fp) ) {  
    $r = fgets($fp, 1024);  
    $result .= $r;  
}  
print_r($result);

?>