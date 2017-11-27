#!/usr/bin/env python
# -----------------------------------------------------------------------------------
# Created  Konn Danley 
# Company: Bitseed
# File;    lin_rd_bconf_mbox.py 
# Date:    05/15/2016
# 
# Purpose: This file is responsible for initiating reads of the bitcoin and bitseed 
#          configuration files.  These required key, value pairs are packed into a JSON
#          object which gets stored in rd_bconf_mbox to await processing from the UI.
# ------------------------------------------------------------------------------------
import os
import subprocess
import json
import re

def parse_conf():

    btc_dict_val_defaults = { "minrelaytxfee" : .00001000, "maxuploadtarget" : 1000, "maxmempool" : 300,
                        "listenonion" : 1,  "upnp" : 1 }

	# Bitseed configuration defaults
    bts_dict_val_defaults = { "autoupdate" : 1, "disablebackups" : 0 }

    #  Read the required values out of .bitcoin/bitcoin.conf
    fh = open("./.bitcoin/bitcoin.conf", "r")
    lines = fh.readlines()
    fh.close()

    #  Read the required values out of .bitseed/bitseed.conf
    fh = open("./.bitseed/bitseed.conf", "r")
    bts_extend_lines = fh.readlines()
    fh.close()

	# This contains the superset of both bitcoin.conf as well as bitseed.conf
    lines.extend(bts_extend_lines)

    # Remove comments
    temp_lines = []
    for line in lines:
        line = line.partition('#')[0]
        line = line.rstrip()
        temp_lines.append(line)
		
    # Remove blank lines
    keep_lines = []
    for line in temp_lines:
        if line.strip():
            keep_lines.append(line)

    # At this point, you have a list of key, value pairs through '='.
    # Extract the parameters of interest and build a Python dictionary 
	# which will be converted into a JSON object which gets passed into 
    # the rd_bconf_mbox file.	
    dict_params={}
    params_list = ["minrelaytxfee", "maxuploadtarget", "maxmempool", 
	               "autoupdate", "listenonion", 
                   "upnp", "disablebackups"] 

    for line in keep_lines:
        key, value = line.split("=")	    
        if key in params_list: 
            dict_params[key] = value
        if key == "onlynet":
            dict_params[key] = value
        if key == "minrelaytxfee":

            # Convert the bitcoin value to Satoshis. 
            dict_params[key] = int(float(value) * 100000000.0)

    # If the parameters of interest hare not in the bitcoin or bitseed 
    # configurations files, then write the default value corresponding 
    # to that parameter into rd_bconf_mbox. 	
    # Make a list of the keys in both.
    for param in params_list:
        if param not in dict_params:
            dict_params[param] = btc_dict_val_defaults[param]
    json_params_object = json.dumps(dict_params)
    return json_params_object

#  Write the json object to the read mailbox and then write 
#  the value '2'.  
json_params = parse_conf()
fh = open("./rd_bconf_mbox", "w") 
fh.write(json_params)
fh.close()

fh = open ("./rd_bconf_flag", "w")
fh.write ("2")
fh.close()


