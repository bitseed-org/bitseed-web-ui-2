<!-----------------------------------------------------------------------------------
Mods:    Konn Danley 
Company: Bitseed
File;    www_wr_bonf_mbox.php
Date:    05/15/2016

Purpose: This file handles writes to the bitcaoiin and bitseed configuration
         files. It does this by communication with user linaro Python scripts
		 through a mailox mechanism.   
		 It was implemented this way due to the fact that the bitcoin and 
		 bitseed configuration files are located in hidden directories 
		 underneath /home/linaro.

		 For more details, refer to the Bitseed Server UI documentation under:

		 "Bitcoin and Bitseed Configuration Filees - UI Access"

Originally forked from https://gitub.com mpatterson99/phpBitAdmin-Bitcoin-HTML5-Wallet 
-------------------------------------------------------------------------------------->

<?php
// include 'php/init_ui_vars.php';
// $fh_log = fopen ("/home/linaro/test_log", "w+");
// $HOME = "/home/bitcoin";
// $HOME = $GLOBALS['HOME'];
if(!session_id()) session_start();
$HOME = $_SESSION['HOME'];

$fh_log = fopen ("$HOME/test_log", "w+");
fwrite ($fh_log, "*** hello *** \n");
fclose ($fh_log);

$full_chkbox_array = ['autoupdate', 'listenonion', 
		              'onlynet', 'upnp', 'disablebackups'];

// ----------------------------------------------------------
// Process checkboxes
// ----------------------------------------------------------
//  Checkbox array
$bitcoin_conf_chkbox = count($_POST['bitcoin_conf_chkbox']) ? $_POST['bitcoin_conf_chkbox'] : array();

//  Grab current slider values
$minrelaytxfee=$_POST['minrelaytxfee'];
$maxuploadtarget=$_POST['maxuploadtarget'];
$maxmempool=$_POST['maxmempool'];


// ----------------------------------------------------------
// The checkbox arrays come in the form of indexed arrays.
// To remain consistent with the way numeric boxes are handled,
// swap the value and the key.
// Update:  Numeric boxes were done away with, but this code 
//          still works for the checkbox array.
// ----------------------------------------------------------
$chkbox_values = array();
for ($i = 0; $i < count($full_chkbox_array); $i++) { 
	$cbox_item = $full_chkbox_array[$i];
	if (in_array($cbox_item, $bitcoin_conf_chkbox)) {
        $chkbox_values[$cbox_item] = "1";
    } else {
	    $chkbox_values[$cbox_item] = "0";
    }
}

// Add sliders to $params_new
$slider_array = array(
				'minrelaytxfee' => $minrelaytxfee,
				'maxuploadtarget' => $maxuploadtarget, 'maxmempool' => $maxmempool
				);

$params_new = array_merge($chkbox_values, $slider_array);

// -----------------------------------------------------
// Create a php array and then convert to a json object
// before writing to the mailbox.  minrelaytxfee, which 
// requires a floating point, 8 significant digit format,
// needs to be handled special.  'onlynet' does as well
// as its values take on either a blank line or the 
// value 'onion' in the bitcoin configuration file.  Finally,
// an inversion is needed on the UI 'enable backups' passed 
// to the backend due to a difference in nomenclature.
// -----------------------------------------------------
$valid_lines = array();
foreach ($params_new as $key => $val) {
    $valid_lines[$key] = $val;
    if ($key == 'minrelaytxfee') {
        // ----------------------------------------------------
		// Convert from Satoshi to BTC 
        // BTC = m * 1e-8; m = number of satoshis; format:float
        $temp_val = floatval($val) * .00000001;
        $valid_lines[$key] = number_format($temp_val, 8); 
        // ----------------------------------------------------
    }	
	if ($key == 'onlynet') {
        if ($valid_lines[$key] == 1) {
            $valid_lines[$key] = 'onion';
	    } else {
            $valid_lines[$key] = "";
        }
	}
	// Invert the value for disable backups
	if ($key == 'disablebackups') {
        if($valid_lines[$key] == 0) {  
            $valid_lines[$key] = 1; 
        } else {
            $valid_lines[$key] = 0;
        }
    }
}
$json_object = json_encode($valid_lines);

// Write the json object to the mailbox.
$fh = fopen ("$HOME/wr_bconf_mbox", "w");
fwrite ($fh, $json_object); 
fclose ($fh);

$fh = fopen ("$HOME/wr_bconf_flag", "w+");
   if ($fh) {
                fwrite ($fh, "1");
   }
fclose ($fh);

?>
