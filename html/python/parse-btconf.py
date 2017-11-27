#!/usr/bin/env python
import os
import subprocess
import json
import re

def parse_conf():

	# Scan bitcoin.conf.  Scan for any of the following parameters: 
    # ---------------------------------------------------------------------
    #    1. Max-connections
    #    2. minrelaytxfee
    #    3. limitfreerelay 
    # ---------------------------------------------------------------------
    param_dict = {}
    fh = open("../php/test.txt", "r")
    lines = fh.readlines()
    fh.close()


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
    # Extract the parameters pf interest and build a Python dictionary 
	# which will be converted into a JSON
    # object to pass back to php to set the variables which will be 
	# used to populate the value fields of the input text boxes  
    dict_params={}
    params_list = ["max-peers", "minrelaytxfee", "limitfreerelay"] 
    for line in keep_lines:
        key, value = line.split("=")	    
        if key in params_list: 
# print "key=", key, "value=", value
            dict_params[key] = value

    fh2 = open("dict_params.txt", "w")
    fh2.write("test")
    fh2.close()
	
    return dict_params


    # Create a dict for all the paramters and encode into json format
#    return_values = {"disk_size": disk_size, "disk_used": disk_used, "disk_avail": disk_avail,
#	                 "ram_used": ram_used, "ram_free": ram_free, "load": load, "uptime": uptime}
#    json_values = json.dumps(return_values)
#    return json_values
# json_values = json.dumps(dict_params2)
# return json_values

s = parse_conf()
# print s 
