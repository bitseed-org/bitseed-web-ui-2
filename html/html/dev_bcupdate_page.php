<!-----------------------------------------------------------------------------------
Mods:    Konn Danley 
Company: Bitseed
File;    dev_bcupdate_page.php
Date:    05/15/2016

Purpose: The Bitcoin Configuration page allows the user to read and write values from/to 
         the bitcoin and bitseed configuration files,  $HOME/.bitcoin/bitcoin.conf and 
		 $HOME/.bitseed/bitseed.conf files.  

		 The values are modified by means of checkboxes and sliders. Bitcoin needs to restart 
		 anytime the configuration values change for the new values to take effect.  
		 Two buttons are provided on this page: “Update Settings” and “Restart Bitcoin”.

         The following parameters in the bitcoin.conf file can be modified:

		 - Tor Enable
             * Bitcoin will relay block and transactions over the Tor network in addition 
			   to the IPv4 network
         - Tor Only
             * When enabled, bitcoin core will operate exclusively on the Tor network. 
			   This is the most private option.
         - UPnP Enable
		     * UPnP lets Bitcoin open port 8333 on your router to allow incoming 
               connections from other nodes.
         - Min Relay Tx Fee
             * Transactions with a fee below this amount will not be relayed by this node.
         - Daily Upload Limit
             * Limits how much blockchain data this node will upload t other nodes each day.
         - Mempool Size Limit
             * Sets the amount of RAM memory to be used for storing unconfirmed 
               transactions (the mempool)

Originally forked from https://gitub.com mpatterson99/phpBitAdmin-Bitcoin-HTML5-Wallet 
-------------------------------------------------------------------------------------->

    <!-- Special note on Tor Enable and onlynet in the bitcoin configuration files

         3 modes:
	             1.  Tor=1, onlynet is blank line - Default - no line.  Tor and ipv4
			     2.  Tor Enable = 1 and onlynet=onion - Tor only
			     3.  Tor Enable = 0 - No Tor
    -->	 

	<div data-role="content" class="content">

	    <div style="margin-top:15px;margin-left:5px;">
		  <span id="span_WalletHeaderText">Settings</span>
	   	  <hr class="hr_wallet">
	    </div>
	   
        <div class="ui-content">
		   <span class="status_text" id="bitcoin_status"></span> 
             <form name="bitcoinconf_form" id="bitcoinconf_form" method="post">
		        <fieldset class="ui-field-contain">
					<div>
					    <!-- Auto Updates checkbox -->
					    <input type="checkbox" name="bitcoin_conf_chkbox[]" id="autoupdate_id" value="autoupdate" <?php echo $updateflag_checked; ?>/>
					    <label rel="tootip" title=<?php echo $autoupdate_tt_content; ?> for="autoupdate_id">Auto Update</label>

					    <!-- Tor On/Off checkbox -->
					    <input type="checkbox" name="bitcoin_conf_chkbox[]" id="listenonion_id" value="listenonion" <?php echo $listenonion_checked; ?> />
					    <label rel="tootip" title=<?php echo $listenonion_tt_content; ?> for="listenonion_id">Tor Enable</label>
						
					    <!-- Tor Only checkbox -->
					    <input type="checkbox" name="bitcoin_conf_chkbox[]" id="onlynet_id" value="onlynet" <?php echo $onlynet_checked; ?> />
					    <label rel="tootip" title=<?php echo $onlynet_tt_content; ?> for="onlynet_id">Tor Only</label>
						
					    <!-- Universal Plug and Play checkbox -->
					    <input type="checkbox" name="bitcoin_conf_chkbox[]" id="upnp_id" value="upnp" <?php echo $upnp_checked; ?> />
					    <label rel="tootip" title=<?php echo $upnp_tt_content; ?> for="upnp_id">UPnP Enable</label>

					    <!-- Disable Blockchain Backups checkbox -->
                                            <!--  REMOVED 12/20/2017 -->
					    <!-- <input type="checkbox" name="bitcoin_conf_chkbox[]" id="disablebackups_id" value="disablebackups" <?php // echo $backupflag_checked; ?> /> -->
					    <!-- <label rel="tootip" title=<?php // echo $disablebackups_tt_content; ?> for="disablebackups_id">Blockchain Backup Enable</label> -->

				    </div>

					<!-- Min Relay Tx Fee Slider Control -->
                    <div class="ui-field-contain">
                            <label rel="tootip" title=<?php echo $minrelaytxfee_tt_content; ?> for="minrelaytxfee_id" style="width: 200px !important; 
							       border-width: 0px; display: inline-block;"><strong>Min Relay Tx Fee (satoshis) (1000 - 50000):</strong></label><br />
                            <input type="range" name="minrelaytxfee" id="minrelaytxfee_id" value=<?php echo $minrelaytxfee; ?> min="1000" max="50000" 
							       step="1" data-highlight = "true" style="border-width: 0px; display: inline-block;">
                    </div>

					<!-- Daily Upload Limit Slider Control -->
                    <div class="ui-field-contain">
                            <label rel="tootip" title=<?php echo $maxuploadtarget_tt_content; ?> for="maxuploadtarget_id" style="width: 200px !important; 
							       border-width: 0px; display: inline-block;"><strong>Daily Upload Limit (MB) (144-5000):</strong></label><br />
                            <input type="range" name="maxuploadtarget" id="maxuploadtarget_id" value=<?php echo $maxuploadtarget; ?> min="144" max="5000" 
							       data-highlight = "true" style="border-width: 0px; display: inline-block;">
                    </div>

					<!-- Mempool Size Limit Slider Control -->
                    <div class="ui-field-contain">
                            <label rel="tootip" title=<?php echo $maxmempool_tt_content; ?> for="maxmempool_id" style="width: 200px !important; 
							      border-width: 0px; display: inline-block;"><strong>Mempool Size Limit (MB) (100-500):</strong></label><br />
                            <input type="range" name="maxmempool" id="maxmempool_id" value=<?php echo $maxmempool; ?> min="100" max="500" 
							      data-highlight = "true" style="border-width: 0px; display: inline-block;">
                    </div>
					<br />
					After you have finished adjusting the settings, click the "Update" button below then click "Restart." Then wait approximately 15 minutes before using the Bitcoin node or updating your settings again. You will experience errors if you try to use the Bitcoin node or update the settings before Bitcoin has finished restarting.
					<br />
					<br />

                    <div data-role="controlgroup" data-type="horizontal" style="text-align: center;">
                        <input type="submit" name="submit" value="Update Settings" id="update-bitcoin-config" />
	                </div>	
			   </fieldset>
		    </form>
			<br />         
           <div data-role="controlgroup" data-type="horizontal" style="text-align: center;">
                <input type="button" value=" Restart Bitcoin " id="bitcoin_restart_conf" onClick="bitcoinControl(this);" />
		    </div>

	</div>
</div> 


