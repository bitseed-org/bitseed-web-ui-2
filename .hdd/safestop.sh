#!/bin/bash
#stops bitcoind and shuts down device when /home/bitcoin/retartflag is set to 2
#intended to be run by sudo crontab -e  (root crontab) every minute
rsflag=$( < /home/bitcoin/restartflag)
#echo "Flag= $rsflag"
if (( rsflag == 2 )); then
 echo "stopiing bitcoind, please wait"
echo 0 > /home/bitcoin/restartflag
bitcoin-cli stop
echo "Do not shut down the device until notified"
x=$(pgrep -f bitcoind)
while [ "$x" !=  "" ]
do
  echo -n "."
  sleep 1s
  x=$(pgrep -f bitcoind)
done
echo "bitcoin has stopped. shutdown in 5 seconds"
echo "$(date) bitcoind stopped via safestop.sh" >> /home/bitcoin/.bitseed/bitseed.log
sleep 10s
echo 4 > /home/bitcoin/restartflag
sudo shutdown -h now
fi
