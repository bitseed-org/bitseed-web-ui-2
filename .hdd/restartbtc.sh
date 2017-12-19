#!/bin/bash
#stops and starts bitcoind when restartflag file is set to 1
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
  $HOME/bitcoin-cli stop
  echo "Do not shut down the device until notified"
  t=0
  m=300
  x=$(pgrep -f bitcoind)
  while [ "$x" !=  "" -a "$t" -lt "$m" ]
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
  $HOME/bitcoind -daemon
echo "bitcoind restarted (date)" >> $HOME/cron.log
fi
fi
