<?php

//$raspiDashStatus = shell_exec("/bin/ps aux | /bin/grep raspiDash | /bin/grep -v grep");
$raspiDashStatus = shell_exec("/bin/ps aux | /bin/grep raspidash | /bin/grep -v grep | /usr/bin/awk {'print $2'}");
if($raspiDashStatus){ $raspiDashStatus = "Running"; }else{ $raspiDashStatus = "Not Running"; }

if($raspiDashStatus	== "Running"){
	$actions = "<button id='statusButton' onclick='toggleService(0)'>Stop</button>";
}else{
	$actions = "<button id='statusButton' onclick='toggleService(1)'>Start</button>";
}

$config = parse_ini_file("/opt/raspidash/config.ini");




?>


<head>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #333; //#4CAF50;
    color: white;
}
</style>
</head>


<table>
        <tr><th colspan='2'><?php echo $CONFIG['software_name']; ?> Service</th></tr>

        <tr><td><?php echo $CONFIG['software_name']; ?> Service</td><td><?php echo $raspiDashStatus . " " . $actions; ?></td></tr>
        <tr><td>Blinkstick Color</td><td>Unknown - <input value='green' id='blinkstick'/> <button onclick='blinkstickToggle()'>Set Color</button></td></tr>
        <tr><td>Target Device</td><td><?php echo $config['target_name']." (".$config['target_mac'].")"; ?></td></tr>

</table>


<script>

function toggleService(option){
	$("#statusButton").html("Loading...");

	if(option == 1){ option = "start"; return_option = "Stop"; }else{ option = "stop"; return_option = "Start"; }

	$.getJSON( "./api/raspidash.json?action="+option, function( json ) {
		$("#refresh").html(return_option);
	 });
}

function blinkstickToggle(){
	color = $("#blinkstick").val();
	$.getJSON( "./api/blinkstick.json?color="+color, function( json ) {
		
	 });
}

</script>
