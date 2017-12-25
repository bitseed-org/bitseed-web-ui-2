#run this as sudo on a new cloned V3
#1) new onion address
#2) mount new swap UUID
#3) new serial number

#new tor address
sudo rm /var/lib/tor/bitseed-service/hostname
sudo rm /var/lib/tor/bitseed-service/hostname
/etc/init.d/tor restart

#new serial number
rm $HOME/deviceid*
echo "Enter device serial number:"
read serial
echo $serial > $HOME/"deviceid-$serial"
echo $serial > /var/www/html/serial
echo $serial > /var/www/onion/serial

#Patches
rm $HOME/btcwatch.sh
wget https://raw.githubusercontent.com/bitseed-org/bitseed-web-ui-2/master/.hdd/btcwatch.sh
chown $USER:USER $HOME/btcwatch.sh
chmod 755 $HOME/btcwatch.sh

#finish
sudo cat /var/lib/tor/bitseed-service/hostname
echo /var/www/html/serial
echo "Enter reboot:"
read temp
echo "4" > $HOME/restartflag
sudo reboot
