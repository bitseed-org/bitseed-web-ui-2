

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
        
<!--     <div class="div_WalletOverview">
        <div class="ui-grid-a">
            <div class="ui-block-a"><span class="primary">Internal IP Address:</span></div>
            <div class="ui-block-b"><span class="secondary_light"><?php // print $inet_mac_addr['inet_address']; ?>&nbsp;</span></div>
        </div>
    </div> -->

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

<!--    <div class="div_WalletOverview">
        <div class="ui-grid-a">
            <span class="primary">Donate Bitcoin:</span>
            <span class="secondary_light_donate"><?php // print $address; ?>&nbsp;</span>
        </div>
    </div> -->

</div><!-- content -->


