<?php

$HOME = "/home/bitcoin";
$BTC_DIR = "$HOME/.bitcoin";

// Values submitted from client-side form
$max_peers=$_POST['max_peers'];
$minrelaytxfee=$_POST['minrelaytxfee'];
$limitfreerelay=$_POST['limitfreerelay'];

// $params_default = array();
// $params_new = array();

// Create an initial array of default parameters
$params_default = array(
                "max_peers" => 125,
                "minrelaytxfee" => .00001,
                "limitfreerelay" => 15
                );

$params_new = array (
    'max_peers' => $max_peers,
        'minrelaytxfee' => $minrelaytxfee,
        'limitfreerelay' => $limitfreerelay
        );

// ----------------------------------------------------------------
// Read in the bitcoin.conf file into the lines a normal array.
// Remove left and right whitespace as well as blank lines.
// ----------------------------------------------------------------
// $fh = fopen ("bitcoin.conf", "r") or die ("Unable to open file!");
$fh = fopen ("$HOME/bitcoin.conf", "r") or die ("Unable to open file!");
$lines = array();
while (!feof($fh)) {
                $temp_string = trim(fgets($fh));
                if ($temp_string != "") {
            $lines[] = $temp_string; 
            }
}
fclose($fh);

// ------------------------------------------------------
// Split into commented_lines[] and $valid_lines[] 
// respectively.
// ------------------------------------------------------
$commented_lines = array();
$valid_lines = array();
for ($i=0; $i<count($lines);$i++) {
    $line = $lines[$i]; 
    if (preg_match("/^#/", $line)) {
        $commented_lines[] = $line; 
        }
        else { 
       list($key, $val) = explode("=", $line);
           $valid_lines[$key] = $val;
    }
}

// ------------------------------------------------------
//  For the parameters passed by the client,  take into 
//  account that the client may pass no value for any of
//  of the passed-in parameters.  In this case, assign 
//  them to default values.
// ------------------------------------------------------
foreach ($params_new as $key => $val) {
        if ($params_new[$key] !== "") {
            $valid_lines[$key] = $val;
        } else {
            $valid_lines[$key] = $params_default[$key];
    }
}
// ------------------------------------------------------
// Create output lines from the value_lines associatve 
// array.
// ------------------------------------------------------
// Note: PHP was putting the minrelaytxfee in exponential 
// format which was not compatable with the bitcoin software. 
// have explicitly converted the number to a float before 
// storing.
// ------------------------------------------------------
foreach ($valid_lines as $key => $val) {
        if ($key == 'minrelaytxfee') {
                $floatval = number_format ($val, 8);
                echo "$key"."="."$floatval\n";
        } else {
    echo "$key"."="."$val"."\n";
        }
}
// ------------------------------------------------------
//  Commented lines are preserved and print to the output 
//  buffer directly at the end.
// ------------------------------------------------------
for ($i=0; $i<count($commented_lines); $i++) {
                echo "$commented_lines[$i]"."\n";
}

// ------------------------------------------------------
// Before creating the new bitcoin.conf file, copy the 
// original to bitcoin.conf.bak.  Delay display of copy
// message to #bitcoin_status DOM element until after
// the output buffer is flushed.
// ------------------------------------------------------
if (!copy("$HOME/bitcoin.conf", "$HOME/bitcoin.conf.bak")) {
    $cp_msg = "Failed to create $HOME/bitcoin.conf.bak backup file!";
} else {
    $cp_msg = "$HOME/bitcoin.conf has been updated.  Original file is in $HOME/bitcoin.conf.bak";
}
                
// Returns content of the output buffer
$finalStr = ob_get_contents();
ob_end_clean();
file_put_contents("$BTC_DIR/bitcoin.conf", $finalStr);

echo "$cp_msg";

// --------------------------------------------------------------------
// Create a separate file that contains just the parameters of interest 
// of the items that the user will interact with.
// --------------------------------------------------------------------
$file = fopen("$HOME/bconf", "w") or die ("Unable to open $HOME/bconf");
foreach ($params_new as $key => $val) {
        if ($key == 'minrelaytxfee') {
            $valid_lines[$key] = number_format ($val, 8);
        } 
    fwrite ($file, "$key=$valid_lines[$key]\n"); 
}
fclose($file);

return;
?>
