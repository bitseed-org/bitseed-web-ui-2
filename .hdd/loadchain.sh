#copy blockchain .bitcoin folder into $HOME/.bitcoin
#run as sudo
mkdir $HOME/temp
mount /dev/sdb1 $HOME/temp
echo "copying blockchain.  allow 1 hour"
rsync -r --info=progress2 $HOME/temp/bitcoin/.bitcoin $HOME
sudo chown -R $USER:$USER $HOME/.bitcoin
sudo umount /dev/sdb1
echo "blockchain copy completed"
