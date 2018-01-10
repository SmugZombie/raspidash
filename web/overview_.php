<!--  Simple Status Page  github.com/smugzombie -->

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


<?php
$uptime = shell_exec("/usr/bin/uptime");

$ossec_status = shell_exec("/usr/sbin/service ossec status | /bin/grep Active");
$openvpn_status = shell_exec("/usr/sbin/service openvpn status | /bin/grep Active");
$salt_status = shell_exec("/usr/sbin/service salt-minion status | /bin/grep Active");
$syslog_status = shell_exec("/usr/sbin/service syslog status | /bin/grep Active");
$dns_status = str_replace("\n","<br>",shell_exec("/bin/cat /etc/resolv.conf | /bin/grep nameserver | /usr/bin/awk {'print $2   '}"));

$top_status = str_replace("\n","<br>",shell_exec('/usr/bin/top -b -n 1 | head -n 4'));

$disk = shell_exec("/bin/df -h | /bin/grep /dev/root");

$current_ips = str_replace("\n","<br>",shell_exec("/sbin/ifconfig | /bin/grep addr: | /usr/bin/awk {'print $2'} | /usr/bin/awk -F \":\" {'print $2   '}"));

$tun_status = shell_exec("/sbin/ifconfig | grep tun");
$tun_ip = shell_exec("/sbin/ifconfig | grep 10.8.0 | /usr/bin/awk {'print $2'} | /usr/bin/awk -F \":\" {'print $2'}");
?>

<table>
        <tr><th colspan='2'>Host Config</th></tr>

        <tr><td>Hostname</td><td><?php echo shell_exec("/bin/hostname"); ?></td></tr>
        <tr><td>Uptime</td><td><?php echo $uptime; ?></td></tr>
        <tr><td>Disk</td><td><?php echo $disk; ?></td></tr>
    <tr><td>Processes</td><td><?php echo $top_status; ?></td></tr>
        <tr><th colspan='2'>Services</th></tr>
        <tr><td>Ossec</td><td><?php echo $ossec_status; ?></td></tr>
        <tr><td>Syslog</td><td><?php echo $syslog_status; ?></td></tr>
        <tr><td>OpenVPN</td><td><?php echo $openvpn_status; ?></td></tr>
        <tr><td>Salt</td><td><?php echo $salt_status; ?></td></tr>
        <tr><th colspan='2'>Network</th></tr>
        <tr><td>IPs</td><td><?php echo $current_ips; ?></td></tr>
        <tr><td>DNS Servers</td><td><?php echo $dns_status; ?></td></tr>
        <tr><td>TUN Status</td><td><?php if($tun_status){echo "Connected"; }else{echo "Not Connected";} ?></td></tr>
        <tr><td>TUN IP</td><td><?php echo $tun_ip; ?></td></tr>

</table>