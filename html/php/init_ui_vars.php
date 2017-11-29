<!-----------------------------------------------------------------------------------
Mods:    Konn Danley 
Company: Bitseed
Date:    05/15/2016

Purpose: This filee calculates values for the Bitcoin Node Status and device status 
         pages.  It is run on any page load.

Originally forked from https://gitub.com mpatterson99/phpBitAdmin-Bitcoin-HTML5-Wallet 
-------------------------------------------------------------------------------------->

<?php

$handle = fopen("test1.txt", 'w');
    
$HOME = "/home/bitcoin";
// public IP
$extwebport_default=80; 

// Internal IP, MAC address
$inet_mac_values = shell_exec('python/internal-ip-mac.py 2>&1');
# fwrite($handle, $inet_mac_values);
$inet_mac_addr = json_decode($inet_mac_values, TRUE);

// Disk Usage, RAM Usage, CPU Load and Uptime status
$device_values = shell_exec('python/disk-info.py 2>&1');
$device_stats = json_decode($device_values, TRUE);
$extip = file_get_contents('http://ipecho.net/plain');
$extipport = $extip . "-8333";
$concensusblock = file_get_contents('https://blockchain.info/q/getblockcount');
// $address = trim(file_get_contents('/home/linaro/reward-addr'));
$address = trim(file_get_contents("$HOME/reward-addr"));
# fwrite($handle, "$address\n");
# fwrite($handle, "$HOME/reward-addr\n");

$serial = file_get_contents('/var/www/html/serial');
$bitseedvers = file_get_contents("$HOME/version");
$wallet = new PhpBitAdmin_Wallet();
$chaininfo = $wallet->rpc($scheme,$server_ip,$server_port,$rpc_user,$rpc_pass,'getblockchaininfo') ;
$meminfo = $wallet->rpc($scheme,$server_ip,$server_port,$rpc_user,$rpc_pass,'getmempoolinfo') ;
$netinfo = $wallet->rpc($scheme,$server_ip,$server_port,$rpc_user,$rpc_pass,'getnetworkinfo') ;
if ( (empty($_SESSION['PHPBITADMIN'])) || ($_SESSION['PHPBITADMIN'] === null) ) { // check if $_SESSION is set.
$session = $wallet->setSession($scheme, $server_ip, $server_port, $rpc_user, $rpc_pass, $btc_addr, $p_phrase);
} else {
$session = true;
}
if( $session ) {
$check_server = $wallet->ping($scheme, $server_ip, $server_port);
if ( $check_server == '' || empty($check_server) ) {
die (' The bitcoind server located at '. $scheme.'://'.$server_port.' on Port:['.$server_port.'] appears to be unresponsive.');
}
$check_login = $wallet->rpc($scheme,$server_ip,$server_port,$rpc_user,$rpc_pass,'getinfo') ;
if ( !is_array($check_login) ) {
die (' At startup, Bitcoin requires 10-15 minutes to check its database and the web UI can be active. Please wait 10-15 minutes. If the web UI never responds, check that the RPC Username and Password are tha same in ~.bitcoin/bitcoin.conf and /var/www/html/config.inc.php are the same');
}
}
?>

