#!/bin/bash
bitcoin-cli -datadir=$HOME/.bitcoin stop
echo "Do not shut down the device until notified"
x=$(pgrep -f bitcoind)
while [ "$x" !=  "" ]
do
  echo -n "."
  sleep 1s
  x=$(pgrep -f bitcoind)
done
echo "bitcoind shut down $(date)" >> $HOME/.bitseed/bitseed.log
echo "bitcoin has stopped.  OK to shutdown"
