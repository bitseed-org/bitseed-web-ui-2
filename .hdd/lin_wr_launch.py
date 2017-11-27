#!/usr/bin/env python
# ----------------------------------------------------------------------------
#
#  Created:     Konn Danley
#  File:        lin_wr_launch.py
#  Date:        05/15/2016
#  Purpose:     If this detects that a '1' has been written to wr_bconf_flag.  
#               The flag is sampled once every 10 seconds, controlled by lin_wr_bconf_cron.sh 
#               If a '1' is detected, the lin_wr_bconf_mbox.py script will be run, which
#               which writes the contents of the wr_bconf_mbox mailbox to the 
#               bitcoin and bitseed configuration files.
#
# -----------------------------------------------------------------------------
import os
import subprocess

fh = open("./wr_bconf_flag", "r")
line = fh.readline()
fh.close()
if (line.strip() == '1'):
    fh = open("./wr_bconf_flag", "w")
    fh.write("0")   
    fh.close()
	
    subprocess.call(["python", "./lin_wr_bconf_mbox.py"])
