<?php

$action = $_GET['action'];


if($action == "snapshot"){
//	$output = shell_exec("/usr/bin/raspistill -o /opt/raspidash/web/images/preview.jpg");

	$output = shell_exec("/usr/bin/python /opt/raspidash/scripts/take_still.py");
}


$response['code'] = 1;
$response['status'] = $api_response_code[ $response['code'] ]['HTTP Response'];
$response['data']['message'] = $output;
