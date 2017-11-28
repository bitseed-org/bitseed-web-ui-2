<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
ob_start();
//**************************************************//
// 	  Please enter required bitcoind parameters  	//
//**************************************************//
$server_ip 	 = '127.0.0.1'; // target bitcoind server ip. [ex.] 10.0.0.15
$server_port = '8332'; // port bitcoind is running on. [ex.] 18332
$rpc_user 	 = 'bitcoinrpc'; // rpc username [must match one in bitcoin.conf]
$rpc_pass 	 = 'bitseed'; // rpc password [must match one in bitcoin.conf]
$btc_address = ''; // your default address for receiving payments. [required]
$passphrase  = 'Passphrase'; // passphrase required to unlock encrypted wallet to send bitcoins. [required if wallet is encrypted]
$scheme		 = 'http' // tcp protocol to access json on bitcoind. [default]
//*************************************************//
?>
