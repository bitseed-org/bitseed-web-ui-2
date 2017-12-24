#!/usr/bin/env python
# -----------------------------------------------------------------------------------
# Created: Konn Danley 
# Company: Bitseed
# File;    internal-ip-mac.py 
# Date:    05/15/2016
#
# Purpose: The purpose of this file is to extract information from the system 
#          regarding the Mac Address and the last Blockchain backup that will be 
#          listed on the Device Status Page.
#
#          After it has gathered this information, it packs it into a json object 
#          and returns it to the server.
# --------------------------------------------------------------------------------------

import os
import subprocess
import json

def ip_mac():

    homedir = "/home/bitcoin/" 

    command = "ip addr show"
    proc = subprocess.Popen(command, stdout=subprocess.PIPE, shell=True)
    (out, err) = proc.communicate()

    # MAC Address
    s = out.split("\n")
    words = s[7].split()
    mac_address = words[1] 

    # Internal IP
    words = s[8].split()
    temp = words[1].split('/')
    inet_address = temp[0]	

    # Date of last backup
    # command = "cat " + homedir + "bak.log"
   # proc = subprocess.Popen(command, stdout=subprocess.PIPE, shell=True)
   # (out, err) = proc.communicate()
   # s = out.split("\n")
   # s.pop()
   # s = s[-1]
   # if s == 'new':
   #     db_date = "new"
   # else:
   #     db_date = s.split(" ")
   #     db_date = " ".join(db_date[3:])

    #return_values = {"inet_address": inet_address, "mac_address": mac_address,
	#                 "db_date": db_date}

    return_values = {"inet_address": inet_address, "mac_address": mac_address}	
		     
    json_values = json.dumps(return_values) 
    return json_values

s = ip_mac()
print s
