<!-----------------------------------------------------------------------------------
Mods:    Konn Danley 
Company: Bitseed
File;    dev_status_page.php
Date:    05/15/2016

Purpose:  The Device Status page provides status for the Bitseed device.  It reports
          values for the following parameters
		   - Disk Size
		   - Disk Space Used
		   - Disk Space Available
		   - RAM Used
		   - RAM Free
		   - CPU Load
		   - Uptime
		   - Mac Address
		   - Time of Last Blockchain Backup

Originally forked from https://gitub.com mpatterson99/phpBitAdmin-Bitcoin-HTML5-Wallet 

NOTE:  The Device status is only shown on the internal network.
-------------------------------------------------------------------------------------->

	<div data-role="content" class="content">
	   
		<div style="margin-top:15px;margin-left:5px;">
			<span id="span_WalletHeaderText">Device Status</span>
			<hr class="hr_wallet">
		</div>

        <div class="div_WalletOverview">
		   <div class="ui-grid-a">
               <div class="ui-block-a"><span class="primary">Disk Size:</span></div>
               <div class="ui-block-b"><span class="secondary_light"><?php print $device_stats['disk_size']; ?>&nbsp;</span></div>
           </div>
        </div>

        <div class="div_WalletOverview">
		   <div class="ui-grid-a">
             <div class="ui-block-a"><span class="primary">Disk Space Used:</span></div>
             <div class="ui-block-b"><span class="secondary_light"><?php print $device_stats['disk_used']; ?>&nbsp;</span></div>
           </div>
        </div>

        <div class="div_WalletOverview">
		   <div class="ui-grid-a">
             <div class="ui-block-a"><span class="primary">Disk Space Available:</span></div>
             <div class="ui-block-b"><span class="secondary_light"><?php print $device_stats['disk_avail']; ?>&nbsp;</span></div>
           </div>
        </div>

        <div class="div_WalletOverview">
		   <div class="ui-grid-a">
             <div class="ui-block-a"><span class="primary">RAM Used:</span></div>
             <div class="ui-block-b"><span class="secondary_light"><?php print $device_stats['ram_used']; ?>&nbsp;</span></div>
           </div>
        </div>

        <div class="div_WalletOverview">
		   <div class="ui-grid-a">
             <div class="ui-block-a"><span class="primary">RAM Free:</span></div>
             <div class="ui-block-b"><span class="secondary_light"><?php print $device_stats['ram_free']; ?>&nbsp;</span></div>
           </div>
        </div>

        <div class="div_WalletOverview">
		   <div class="ui-grid-a">
              <div class="ui-block-a"><span class="primary">CPU Load:</span></div>
              <div class="ui-block-b"><span class="secondary_light"><?php print $device_stats['load']; ?>&nbsp;</span></div>
           </div>
        </div>

        <div class="div_WalletOverview">
		   <div class="ui-grid-a">
              <div class="ui-block-a"><span class="primary">Uptime:</span></div>
              <div class="ui-block-b"><span class="secondary_light"><?php print $device_stats['uptime']; ?>&nbsp;</span></div>
           </div>
        </div>
		<br />

 	    <div class="div_WalletOverview">
           <div class="ui-grid-a">
              <div class="ui-block-a"><span class="primary">Mac Address:</span></div>
              <div class="ui-block-b"><span class="secondary_light"><?php print $inet_mac_addr['mac_address']; ?>&nbsp;</span></div>
           </div>
        </div>

<!--        <div class="div_WalletOverview">
           <div class="ui-grid-a">
              <div class="ui-block-a"><span class="primary">Last blockchain Backup:</span></div>
              <div class="ui-block-b"><span class="secondary_light"><?php print $inet_mac_addr['db_date']; ?>&nbsp;</span></div>
           </div>
        </div> -->

		
	 </div><!-- /content  -->

