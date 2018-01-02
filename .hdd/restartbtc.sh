#!/bin/bash
#stops and starts bitcoind when restartflag file is set to 1
# flag=4 starts bitcoind
# flag=1 stops bitcoind and then restarts it after it has stopped.   if bitcoind will not stop within 300s, kill it
# flag=2 is watched by /root/safestop.sh which is same as flag=1 and then executes a shutown 
#does nothing in all other cases
#intended to be run every minute by cronttab:
#* * * * * bash $HOME/restartbtc.sh
rsflag=$( < $HOME/restartflag)
#echo "Flag= $rsflag"
if (( rsflag == 4 )); then
  echo "power-up sequence, please wait"
  echo 0 > $HOME/restartflag
  sleep 1m
  ./ui_init.sh
  ./btcwatch.sh
 else
 if (( rsflag == 1 )); then
  echo "restarting bitcoind, please wait"
  echo 0 > $HOME/restartflag
  bitcoin-cli stop
  echo "Do not shut down the device until notified"
  t=0
  m=300
  x=$(pgrep -f bitcoind)
  while [ "$x" !=  "" -a t -lt m ]
  do
   echo -n "."
   sleep 1s
   t=t+1
   x=$(pgrep -f bitcoind)
  done
  kill -9 "$x"
  echo "bitcoin has stopped. restart in 5 seconds"
  sleep 10s
  echo "starting bitcoind, pleese wait 15 min"
  bitcoind -daemon
echo "bitcoind restarted $(date)" >> $HOME/.bitseed/bitseed.log
fi
fi
