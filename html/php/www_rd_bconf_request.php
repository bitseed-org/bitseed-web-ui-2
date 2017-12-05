<!-----------------------------------------------------------------------------------
Created: Konn Danley 
Company: Bitseed
File;    www_rd_bconf_request.php
Date:    05/15/2016

Purpose: This file (user www-data) is used ot facilitate reads from the bitcoiin 
         and bitseeed configuration files.  It does this by working with Python 
		 scripts located in $HOME through mailboxes.  
		 It was implemented this way due to the fact that the bitcoin and bitseed
		 configurations are located in hidden directories underneath $HOME 
   
		 For more details, refer to the Bitseed server UI documentation under: 

		 "Bitcoin and Bitseed Configuration Files - UI Access"

Special note on Tor Enable and onlynet
 
         3 modes:
             1.  Tor=1, onlynet is blank line - Default - no line.  Tor and ipv4
		     2.  Tor Enable = 1 and onlynet=onion - Tor only
		     3.  Tor Enable = 0 - No Tor

-------------------------------------------------------------------------------------->

<?php
   if(!session_id()) session_start();
   $HOME = trim($_SESSION['HOME']);
   // $HOME = trim($HOME);
   // $HOME = "/home/bitcoin";

// ------------------------------------------------------------------------------------
// On a page load (any page load), this file checks rd_bconf_flag.  If it is a '0',
// it will write a '1' to rd_bconf_flag, signalling a read request to the user.
// ------------------------------------------------------------------------------------
   $fh_flag = fopen ("$HOME/rd_bconf_flag", "r+") or die ("Unable to open XX $HOME/rd_bconf_flag");
   if ($fh_flag) {
       if (($line = fgets($fh_flag)) !== false) {
			   if ($line == 0) {
                   $line = '1'; 
				   rewind ($fh_flag);
                   fputs($fh_flag, $line);
               }
       }
    }
    // ------------------------------------------------------------------
    // Now wait for the user side to fill the read mailbox and write a '2' 
    // to to rd_bconf_flag to indicate receipt and that there is a UI load
    // of the configuration data.
    // Once  complete, this file will write a '0' to rd_bconf_flag to 
    // indicate to the user that the operation is complete.  
    // ------------------------------------------------------------------
    while (1) {
        sleep(1);

	    rewind($fh_flag);
        $line = fgets($fh_flag);
		$line = trim($line);

	    if ($line == '2') {
            break;
		}
    }
    // ------------------------------------------------------------------
    // A '2' has been detected.  Read the read mailbox and place a '0' in 
    // rd_bconf_flag.
    // ------------------------------------------------------------------
    rewind($fh_flag);
    $jsondata = file_get_contents("$HOME/rd_bconf_mbox");
    $array_from_json = json_decode($jsondata, true);

	// ----------------------------------------------------
	// SLIDERS
	// ----------------------------------------------------
    $minrelaytxfee_conf=$array_from_json['minrelaytxfee']; 
	if ($minrelaytxfee_conf) {
        $minrelaytxfee = $minrelaytxfee_conf;
	}  

    $maxuploadtarget_conf=$array_from_json['maxuploadtarget']; 
	if ($maxuploadtarget_conf) {
        $maxuploadtarget = $maxuploadtarget_conf;
	}  

    $maxmempool=$array_from_json['maxmempool']; 
	if ($maxmempool_conf) {
        $maxmempool = $maxmempool_conf;
	}
   
   // ----------------------------------------------------
   // Checkboxes
   // ----------------------------------------------------
   $updateflag_checked = "";
   $updateflag_conf=$array_from_json['autoupdate']; 
   if ($updateflag_conf == 1) {
       $updateflag_checked = "checked";
   }
   $listenonion_checked = "";
   $listenonion_conf=$array_from_json['listenonion']; 
   if ($listenonion_conf == 1) {
       $listenonion_checked = "checked";
   }
   $onlynet_checked = "";
   $onlynet_conf=$array_from_json['onlynet']; 
   if ($onlynet_conf == 'onion') {
       if ($listenonion_conf == 1) {
           $onlynet_checked = "checked";
       }
   }
   $upnp_checked = "";
   $upnp_conf=$array_from_json['upnp']; 
   if ($upnp_conf == 1) {
       $upnp_checked = "checked";
   }
   $backupflag_checked = "";
   $backupflag_conf=$array_from_json['disablebackups']; 

    // Invert the polarity as the UI uses 'Enable' nomenclature
    // and the backend uses 'disable' nomoenclature.
    if ($backupflag_conf == 0) {
       $backupflag_checked = "checked";
   }

   // Write a '0' to rd_bconf_flag
   rewind ($fh_flag);
   $line = 0;
   fputs($fh_flag, $line);
   fclose($fh_flag);

?>
