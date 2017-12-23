#!/bin/bash
# -----------------------------------------------------------------------------------
# Created: Konn Danley 
# Company: Bitseed
# File;    lin_rd_bconf_cron.sh
# Date:    05/15/2016
#
# Purpose: System cron only has 1 minute resolution.  A finer resolution was required,
#          so custom cron scripts were created to provide this feature. In this case,
#          lin_rd_launch.py is launched every 5 seconds. 
# -------------------------------------------------------------------------------------

while (sleep 10 && ./lin_rd_launch.py) &
do
 wait $!
done


