#!/usr/bin/env python
# -------------------------------------------------------------
#  ifconfig provides info for eth0, which is the only ethernet there
#  will be.  HWaddr is on the first line and inet addr is on the 
#  second line.
# -------------------------------------------------------------
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
    command = "cat " + homedir + "bak.log"
    proc = subprocess.Popen(command, stdout=subprocess.PIPE, shell=True)
    (out, err) = proc.communicate()
    s = out.split("\n")
    s.pop()
    s = s[-1]
    if s == 'new':
        db_date = "new"
    else:
        db_date = s.split(" ")
        db_date = " ".join(db_date[3:])

    return_values = {"inet_address": inet_address, "mac_address": mac_address,
                         "db_date": db_date}
    json_values = json.dumps(return_values)
    return json_values

s = ip_mac()
print s
