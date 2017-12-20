#!/bin/bash
echo -n 0 > /home/bitcoin/rd_bconf_flag
echo -n 0 > /home/bitcoin/wr_bconf_flag
/home/bitcoin/lin_rd_bconf_cron.sh &
/home/bitcoin/lin_wr_bconf_cron.sh &
