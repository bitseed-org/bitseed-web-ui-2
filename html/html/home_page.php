<!-----------------------------------------------------------------------------------
Mods:    Konn Danley 
Company: Bitseed
File;    home_page.php
Date:    05/15/2016

Purpose: The home_page.php file calculates and displays biycoin node status.  The following 
         The following parameters are reported:

		  - Bitcoin core versiom
		  - Node type (partial or full)
	      - Device at block
		  - Current bitcoin network block
		  - Peer connections
		  - Number of current tranactions in mempool
		  - Minimum relay fee
		  - Public IP address of device
		  - Internal network IP of device
		  - Device S/N 
		  - Device Version 

Originally forked from https://gitub.com mpatterson99/phpBitAdmin-Bitcoin-HTML5-Wallet 
-------------------------------------------------------------------------------------->
<?php
$file_logger = fopen ("address.log", "w");
fwrite ($file_logger, "address=$address\n");
fclose ($file_logger);
?>
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
            <div class="ui-block-a"><span class="primary">Public IP Address:</span></div>
            <div class="ui-block-b"><span class="secondary_light"><?php print $extip; ?>&nbsp;</span></div>
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
            <div class="ui-block-a"><span class="primary">Device S/N:</span></div>
            <div class="ui-block-b"><span class="secondary_light"><?php print $serial; ?></span></div>
        </div>
    </div>

	<?php 
        // Convert the bitseedervs from xxx format to x.x.x format per Jay's request
	    $bitseedvers_ui = substr($bitseedvers, 0, 1).'.'.substr($bitseedvers, 1, 2);
	    $bitseedvers_ui = substr($bitseedvers_ui, 0, 3).'.'.substr($bitseedvers, 2, 3);
	?>

    <div class="div_WalletOverview">
        <div class="ui-grid-a">
            <div class="ui-block-a"><span class="primary">Device Version:</span></div>
            <div class="ui-block-b"><span class="secondary_light"><?php print $bitseedvers_ui; ?></span></div>
        </div>
    </div>

</div><!-- content -->


