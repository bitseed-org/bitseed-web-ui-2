#!/bin/bash
# -----------------------------------------------------------------------------------
# Created: Konn Danley 
# Company: Bitseed
# File;    lin_wr_bconf_cron.sh
# Date:    05/15/2016
#
# Purpose: System cron only has 1 minute resolution.  A finer resolution was required,
#          so custom cron scripts were created to provide this feature. in this case,
#          lin_wr_launch is launched every 10 seconds.
# --------------------------------------------------------------------------------------
while (sleep 10 && ./lin_wr_launch.py) &
do
 wait $!
done
