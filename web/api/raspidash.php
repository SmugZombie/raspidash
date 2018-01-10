<?php

$action = $_GET['action'];

if($action == "start"){
	$output = shell_exec("/usr/bin/nohup /usr/bin/python /opt/raspidash/raspidash.py &");
}elseif($action == "stop"){
	$output = shell_exec("/bin/bash /opt/raspidash/scripts/stop_raspidash.sh");
}elseif($action == "status"){
	$service = shell_exec("/bin/ps aux | /bin/grep raspiDash | /bin/grep -v grep");
	if($service){ $output = "Running"; }else{ $output = "Not Running"; }
}else{
	return_error("Invalid Action Specified!",1);
}


$response['code'] = 1;
$response['status'] = $api_response_code[ $response['code'] ]['HTTP Response'];
$response['data']['message'] = $output;
