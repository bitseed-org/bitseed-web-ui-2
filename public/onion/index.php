#page displayed via hidden service

<?php 
require_once('config.inc.php'); 
require('php/phpbitadmin.class.php');
// Internal IP, MAC address
// $inet_mac_values = shell_exec('/home/linaro/internal-ip-mac.py 2>&1');
$inet_mac_values = shell_exec('python/internal-ip-mac.py 2>&1');
$inet_mac_addr = json_decode($inet_mac_values, TRUE);
// Disk Usage, RAM Usage, CPU Load and Uptime status
// $device_values = shell_exec('/home/linaro/disk-info.py 2>&1');
$device_values = shell_exec('python/disk-info.py 2>&1');
$device_stats = json_decode($device_values, TRUE);
$extip = file_get_contents('/home/linaro/extip');
$extip = trim($extip);
$concensusblock = file_get_contents('https://blockchain.info/q/getblockcount');
$address = file_get_contents('/home/linaro/reward-addr');
$jsnaddr = "https://getaddr.bitnodes.io/api/v1/nodes/{$extip}-8333";
$bitnodejson = file_get_contents($jsnaddr);
$bitnode = json_decode($bitnodejson, TRUE);
$serial = file_get_contents('/var/www/html/serial');
$bitseedvers = file_get_contents('/home/linaro/version');
$wallet = new PhpBitAdmin_Wallet();
$chaininfo = $wallet->rpc($scheme,$server_ip,$server_port,$rpc_user,$rpc_pass,'getblockchaininfo') ;
$meminfo = $wallet->rpc($scheme,$server_ip,$server_port,$rpc_user,$rpc_pass,'getmempoolinfo') ;
$netinfo = $wallet->rpc($scheme,$server_ip,$server_port,$rpc_user,$rpc_pass,'getnetworkinfo') ;
$intip = $inet_mac_addr['inet_address'];
$sn = (int)$serial;
$status = array ( "sn" => $sn, "ip" => $intip );
$statusjson = json_encode($status);
$stat = 'status.json' ;
file_put_contents($stat, $statusjson) ;
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
	$check_login =  $wallet->rpc($scheme,$server_ip,$server_port,$rpc_user,$rpc_pass,'getinfo') ;
	if ( !is_array($check_login) ) {
		die (' At startup, Bitcoin requires 10-15 minutes to check its database and the web UI can be active. If Bitseed is running a weekly backup, this page will be down for about 1 hour');
	}
}
?>
<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bitcoin Node</title>
<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css" />
<link rel="stylesheet" href="css/m_phpbitadmin.css" />
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.mobile-1.4.5.min.js"></script>
<script type="text/javascript">
// KD - This needs to change to AJAX True    
$(document).bind("pagecreate", function () {
    $.mobile.ajaxEnabled = false;
});
</script>

<!-- AJAX calls for system control at the server -->
<script>
    function myCall(e) {
		var domvalue = $(e).attr('id'); 
        var request = $.ajax({
            url: "php/jquery-ajax.php",
            type: "GET",
            dataType: "html",
			data: { 
                id: domvalue
			},
        });
        request.done(function(msg) {
            $("#bitcoin-status").html(msg);          
        });
        request.fail(function(jqXHR, textStatus) {
            alert( "Request failed: " + textStatus );
        });
    }
</script>

</head>
<body>

<div data-role="page" id="home" data-theme="a">

    <div class="panel left" data-role="panel" data-position="left" data-display="push" id="mypanel">
        <div id = "menu">
	            <ul>
   		            <li><a href="#home" title="title">Home</a></li><br />
		            <li><a href="#device-status" title="Device Status">Device Status</a></li><br /> 
		            <li><a href="#bitnodes">Bitnodes</a></li><br />
		            <li><a href="#controls">Controls</a></li>
		       </ul>
	    </div>
	 </div>

     <div data-role="header"> 
		<span class="open left"><a href="#mypanel" data-role="navbar"><img src="images/nav-icon-blue.png" height="20" width="20" alt=""/></a></span>
		<span id="span_TitleHeader">&nbsp; &nbsp; <img src="images/bitcoind.png" height="32" width="32" alt=""/>&nbsp;Bitseed Bitcoin Node</span>
	</div><!-- /header -->

	<div data-role="content" class="content">

		<div style="margin-top:15px;margin-left:5px;">
			<span id="span_WalletHeaderText">Bitcoin Node Status</span>
			<hr class="hr_wallet">
		</div>
	
		<div class="div_WalletOverview">
                   <div class="ui-grid-a">
                        <div class="ui-block-a"><span class="primary">Bitcoin Core Version:</span></div>
                        <div class="ui-block-b"><span class="secondary_light"><?php print $netinfo['subversion']; ?></span></div>
                   </div>
                </div>

		 <div class="div_WalletOverview">
                   <div class="ui-grid-a">
                        <div class="ui-block-a"><span class="primary">Node Type:</span></div>
                        <div class="ui-block-b"><span class="secondary_light"><?php if ($chaininfo['pruned'] === false) {print "Full Node";} else {print "Pruned";} ?></span></div>
                   </div>
                </div>		

		<div class="div_WalletOverview">
		   <div class="ui-grid-a">
		       	<div class="ui-block-a"><span class="primary">Device at Block:</span></div>
			<div class="ui-block-b"><span class="secondary_light"><?php print $check_login['blocks']; ?>&nbsp;</span></div>
		   </div>
		</div>
		
		 <div class="div_WalletOverview">
		   <div class="ui-grid-a">
			<div class="ui-block-a"><span class="primary">Network Block:</span></div>
			<div class="ui-block-b"><span class="secondary_light"><?php print_r ($concensusblock); ?></span></div>
		   </div>
		</div>
		
		<div class="div_WalletOverview">
		   <div class="ui-grid-a">
			<div class="ui-block-a"><span class="primary">Peer Connections:</span></div>
			<div class="ui-block-b"><span class="secondary_light"><?php print $check_login['connections']; ?></span></div>
		   </div>
		</div>

		 <div class="div_WalletOverview">
                   <div class="ui-grid-a">
                        <div class="ui-block-a"><span class="primary">Tx in Mempool:</span></div>
                        <div class="ui-block-b"><span class="secondary_light"><?php print $meminfo['size']; ?></span></div>
                   </div>
                </div>

		 <div class="div_WalletOverview">
                   <div class="ui-grid-a">
                        <div class="ui-block-a"><span class="primary">Minimum Relay Fee:</span></div>
                        <div class="ui-block-b"><span class="secondary_light"><?php printf ('%.08lf', $check_login['relayfee']); ?></span></div>
                   </div>
                </div>	
        	
        	<div class="div_WalletOverview">
		   <div class="ui-grid-a">
             		<div class="ui-block-a"><span class="primary">Internal IP Address:</span></div>
             		<div class="ui-block-b"><span class="secondary_light"><?php print $inet_mac_addr['inet_address']; ?>&nbsp;</span></div>
		   </div>
	        </div>
	        
	        <div class="div_WalletOverview">
                   <div class="ui-grid-a">
             		<div class="ui-block-a"><span class="primary">Admin Panel Link:</span></div>
             		<div class="ui-block-b"><span class="secondary_light"><?php echo ''.$inet_mac_addr['inet_address'].':81 </a>'; ?>&nbsp;</span></div>
        	   </div>
        	</div>

		<div class="div_WalletOverview">
                   <div class="ui-grid-a">
                        <div class="ui-block-a"><span class="primary">Device ID:</span></div>
                        <div class="ui-block-b"><span class="secondary_light"><?php print $serial; ?></span></div>
                   </div>
                </div>
                
                <div class="div_WalletOverview">
                   <div class="ui-grid-a">
                        <div class="ui-block-a"><span class="primary">Device Version:</span></div>
                        <div class="ui-block-b"><span class="secondary_light"><?php print $bitseedvers; ?></span></div>
                   </div>
                </div>
                
        	<div class="div_WalletOverview">
                    <div class="ui-grid-a">
            <span class="primary">Donate Bitcoin:</span>
            <span class="secondary_light_donate"><?php print $address; ?>&nbsp;</span>
                   </div>
        	</div>

    </div><!-- content -->

</div>  <!-- page -->
</body>
</html>
<?php ob_flush(); ?>
