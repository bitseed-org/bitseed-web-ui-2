<!-----------------------------------------------------------------------------------
Mods:    Konn Danley 
Company: Bitseed
File;    dev_control_page.php
Date:    05/15/2016

Purpose: This is the Power page that allows the user to restart the Bitseed Device
         from the web application.  This feature is only available on the internal 
		 network
-------------------------------------------------------------------------------------->
<div data-role="content" class="content">

	    <div style="margin-top:15px;margin-left:5px;">
		  <span id="span_WalletHeaderText">Power</span>
	   	  <hr class="hr_wallet">
	    </div>
	   
        <div data-role="controlgroup" data-type="horizontal" style="text-align: center;">
            <input type="button" value="Powerdown Bitseed Device" id="device_shutdown" onClick="bitcoinControl(this);" />
	    </div>
  </div> 
