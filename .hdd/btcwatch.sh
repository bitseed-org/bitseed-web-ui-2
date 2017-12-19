#!/bin/bash
#A watchdog script that keeps bitcoind running
#for ubuntu 16.04 server

#get public IP and write to disk
dig +short myip.opendns.com @resolver1.opendns.com > extip

#check if rsync in pregress"
z=$(pgrep -f rsync)
if [ "$z" != "" ]; then
echo "rsync running - dont start btc"
exit
else
echo "rync not running - ok"
fi

#check system date
d=$(date +%s)
echo "$d"
if [ "$d" -lt "1422748800" ]; then
  echo "system date is incorrect, aborted startup" >> $HOME/cron.log
  exit 0
fi
echo "system date is > 2015-02-01, script will continue"

#check if bitcoind is already running
x=$(pgrep -f bitcoind)
if [ "$x" == "" ]; then
  #if bitcoind not running then start it
  echo "start btc"
  ./bitcoind -daemon
  echo "wait 15 min and check if running"
  sleep 15m
  x=$(pgrep -f bitcoind)
  echo "PID:"$x
  if [ "$x" == "" ]; then
    #if bitcoind did not start properly
    echo "start failed, $(date)" >> $HOME/cron.log
    echo "start failed"
    sleep 1m
    echo "try again to start btc 1m after fail to run"
    ./bitcoind -daemon
    exit
  else
    echo "restart success"
    echo "btc restarted $(date)" >> $HOME/cron.log
  fi
else
 echo "already running PID:"$x
 echo "wait 15 min then check block status"
 fi
fi
