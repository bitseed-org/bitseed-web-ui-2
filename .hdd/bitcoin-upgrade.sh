#downloads latest bitcoin binaries from bitseed.org and installes on bitseed
echo "upgrading bitcoin core"
sh $HOME/btcstop.sh
sleep 5s
wget https://bitseed.org/device/currentv3/bitcoin-core.tar.gz
rm bitcoind
rm bitcoin-cli
rm bitcoin-tx
rm bitcoin-qt
tar -xvf bitcoin-core.tar.gz
rm bitcoin-core.tar.gz
cp bitcoin-*/bin/bitcoind ~
cp bitcoin-*/bin/bitcoin-cli ~
rm bitcoin-core.tar.gx
chmod 755 $HOME/bitcoind
chmod 755 $HOME/bitcoin-cli

echo "bitcoin core upgraded"
echo "restarting bitcoind.  Allow 15 minutes for bitcoin to startup"
sleep 5s
echo 4 > restartflag
sh $HOME/btcwatch.sh
