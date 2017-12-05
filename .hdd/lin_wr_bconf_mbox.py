#!/usr/bin/env python
# --------------------------------------------------------------------
#
#  Created:       Konn Danley
#  File:          lin_wr_bconf_mbox.py
#  Date:          01/07/2016
#
#  Purpose:       This script is used 
#                 to transfer data from wr_bconf_mbox and merge these 
#                 values into .bitcoin/bitcoin.conf and .bitseed/bitseed.conf
#                 files.
#
#  Note:  The Mailbox (wr_bconf_mbox) uses JSON formatted objects. 
# --------------------------------------------------------------------
import os
import subprocess
import json
import re

# Parameters for the .bitcoin/bitcoin.conf configuration file.
btc_params_list = ["minrelaytxfee", "maxuploadtarget", "maxmempool", 
                   "listenonion", "onlynet", "upnp"] 

# Parameters for the .bitseed/bitseed.conf configuration file.
bts_params_list = ["autoupdate", "disablebackups"] 

# The JSON object below has parameters from both bitcoin.conf and bitseed.conf
# Load the JSON object from the wr_bconf_mbox mailbox and put the information
# into a Python dictionary.
json_data=open('wr_bconf_mbox')
wr_mbox_dict_params = json.load(json_data)

# Split wr_mbox_dict_params into btc_mbox_params and bts_mbox_params
btc_mbox_params = {}
bts_mbox_params = {}
for mbox_key in wr_mbox_dict_params:
    if mbox_key in btc_params_list:
        btc_mbox_params[mbox_key] = wr_mbox_dict_params[mbox_key]	
    if mbox_key in bts_params_list:
        bts_mbox_params[mbox_key] = wr_mbox_dict_params[mbox_key]
		
# Processing for key/value pairs taken from bitcoin.conf and bitseed.conf
fh = open(".bitcoin/bitcoin.conf", "r"); 
btc_lines = fh.readlines() 
fh.close()

fh = open("./.bitseed/bitseed.conf", "r")
bts_lines = fh.readlines()
fh.close()

# Create dictionaries from the bitcoin.conf and bitseed.conf
# files.
bitcoin_conf_dict = {}
bitseed_conf_dict = {}

# Replace the line that has 'onlynet' in it and overwrite 
# that line with a commented or uncommented line, dictated
# by the value passed in from the UI
print btc_mbox_params
if (btc_mbox_params['onlynet'] == "") or (btc_mbox_params['listenonion'] == '0'):
    temp_str = "#onlynet=onion\n"
else:
    temp_str = "onlynet=onion"

for i in range(len(btc_lines)):
    if 'onlynet=onion' in btc_lines[i]: 
        btc_lines[i]=temp_str
        break

for line in btc_lines:

    # Skip blank lines
    temp_line = line.strip()
    if temp_line:

	    # Skip comments
        if temp_line[0] == '#':
            pass
        else:
		    # Create dictionary from remaining key, value 
		    # pair, described as key=value.
            line_key, line_value = temp_line.split("=")
            bitcoin_conf_dict[line_key] = line_value

for line in bts_lines:

    # Skip blank lines
    temp_line = line.strip()
    if temp_line:

		# Skip comments
        if temp_line[0] == '#':
            pass
        else:
		    # Create dictionary from remaining key, value 
		    # pair, described as key=value.
            line_key, line_value = temp_line.split("=")
            bitseed_conf_dict[line_key] = line_value
# ----------------------------------------------------------

#  Merge values from UI into bitcoin.conf lines array
for mbox_key in bitcoin_conf_dict:
    if mbox_key in btc_params_list: 
        for i in range(len(btc_lines)):
            line = btc_lines[i]
            if line.strip(): 
                if line[0] == '#': 
                    pass
                else:
                    line_key, line_value = line.split("=") 

                    # replace value in bitcoin.conf
                    if line_key == mbox_key:
                        if line_key in btc_mbox_params:
                            temp_str = mbox_key + "=" + str(btc_mbox_params[mbox_key]) + "\n"
                            btc_lines[i] = temp_str 

#  Merge values from UI into bitseed.conf lines array
for mbox_key in bitseed_conf_dict:
    if mbox_key in bts_params_list: 
        for i in range(len(bts_lines)):
            line = bts_lines[i]
            if line.strip(): 
                if line[0] == '#': 
                    pass
                else:
                    line_key, line_value = line.split("=") 

                    # replace value in bitseed.conf
                    if line_key == mbox_key:
                        if line_key in bts_mbox_params:
                            temp_str = mbox_key + "=" + str(bts_mbox_params[mbox_key]) + "\n"
                            bts_lines[i] = temp_str 

# Make a backup of the PREVIOUS bitcoin.conf file (bitcoin.conf.bak) 
subprocess.call (["cp", "./.bitcoin/bitcoin.conf", 
                  "./.bitcoin/bitcoin.conf.bak"]) 

# Make a backup of the PREVIOUS bitseed.conf (bitseed.conf.bak) 
subprocess.call (["cp", "./.bitseed/bitseed.conf", 
                  "./.bitseed/bitseed.conf.bak"])

# Write out the new bitcoin.conf file.
fh = open("./.bitcoin/bitcoin.conf", "w"); 
for i in range(len(btc_lines)):
    fh.write(btc_lines[i])
fh.close()

# Write out the new bitseed.conf file.
fh = open("./.bitseed/bitseed.conf", "w"); 
for i in range(len(bts_lines)):
    fh.write(bts_lines[i])
fh.close()
