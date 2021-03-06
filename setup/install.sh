#!/bin/bash
#install Bitseed V3 GUI for Bitcoin Core bitcoind
#Ubuntu 16 supported
COIN="bitcoin"

#set serial number
echo "Enter device serial number:"
read serial
echo $serial > $HOME/"deviceid-$serial"

#import blockchain from network
echo "importing blockchain.  wait aboutn 1 hour"
#rsync -r --info=progress2 storage@10.1.10.121:/home/storage/disk3/.bitcoin /home/bitcoin
rsync -r --info=progress2 storage@10.1.10.121:/home/storage/.bitcoin /home/bitcoin
#rsync -r --info=progress2 bitcoin@10.1.10.169:/home/bitcoin/usbdisk/.bitcoin /home/bitcoin

#remove default user
sudo pkill -KILL -u oem
sudo userdel -r oem
sudo passwd -l root

#dependencies
#bitcoind is installed from Ubuntu Launchpad reso
sudo cp /home/$COIN/bitseed-web-ui-2/setup/bitcoinubuntu-bitcoin-xenial.list /etc/apt/sources.list.d
sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys D46F45428842CE5E
sudo apt-get update
sudo apt-get -y install apache2 libapache2-mod-php php-mysql php-curl php-mcrypt dnsutils ntp python rsync
sudo apt-get install -y unattended-upgrades
sudo apt-get install -y bitcoind


#OS settings
sudo hostname bitseed3
sudo rm /etc/hostname
sudo echo "bitseed3" >> /etc/hostname
#sudo rm /etc/hosts
#sudo cp $HOME/bitseed-web-ui-2/setup/hosts /etc/

#Apache config
sudo cp $HOME/bitseed-web-ui-2/setup/000-default.conf  /etc/apache2/sites-enabled/
sudo cp $HOME/bitseed-web-ui-2/setup/ports.conf  /etc/apache2/
#private control panel
sudo rm -rf /var/www/html
sudo mkdir /var/www/html
sudo cp -r $HOME/bitseed-web-ui-2/html/* /var/www/html
sudo echo $serial > /var/www/html/serial
#sudo chmod 666 /var/www/html/*.txt
sudo chown -R www-data:www-data /var/www/html
#public page
sudo mkdir /var/www/public
sudo cp -r $HOME/bitseed-web-ui-2/public/* /var/www/public
sudo echo $serial > /var/www/public/serial
#sudo chmod 666 /var/www/public/*.txt
sudo chown -R www-data:www-data /var/www/public
#onion page
sudo mkdir /var/www/onion
sudo cp -r $HOME/bitseed-web-ui-2/onion/* /var/www/onion
sudo echo $serial > /var/www/onion/serial
#sudo chmod 666 /var/www/onion/*.txt
sudo chown -R www-data:www-data /var/www/onion

#home directory files
cp -r $HOME/bitseed-web-ui-2/.hdd/*  $HOME
touch $HOME/rd_bconf_flag
touch $HOME/wr_bconf_flag
touch $HOME/wr_bconf_mbox
touch $HOME/rd_bconf_mbox
sudo chown $COIN:$COIN $HOME/*.py
sudo chown $COIN:$COIN $HOME/*.sh
sudo chown $COIN:$USER $HOME/*flag
sudo chown $COIN:$COIN $HOME/*mbox
sudo chmod 755 $HOME/*.py
sudo chmod 755 $HOME/*.sh
sudo chmod 666 $HOME/rd_bconf_flag
sudo chmod 666 $HOME/wr_bconf_flag
sudo chmod 666 $HOME/bconf
sudo chmod 666 $HOME/wr_bconf_mbox
sudo chmod 666 $HOME/rd_bconf_mbox
sudo chmod 666 $HOME/restartflag
sudo mkdir $HOME/.bitseed
sudo cp $HOME/bitseed-web-ui-2/.hdd/.bitseed/bitseed.conf $HOME/.bitseed
sudo chown -R $COIN:$COIN $HOME/.bitseed
sudo chmod 766 $HOME/.bitseed
echo "installed" > $HOME/.bitseed/bitseed.log
sudo cp $HOME/bitseed-web-ui-2/setup/bitcoin.conf $HOME/.bitcoin
sudo chown -R $USER:$USER $HOME/.bitcoin
sudo chmod 766 $HOME/.bitcoin
sudo echo "302" > $HOME/version
sudo chown $USER:$USER *
sudo /etc/init.d/apache2 restart
echo "web admin install done" > $HOME/bitseed-web-ui-2/setup/setup.log

#bitcoin core
#wget https://bitcoincore.org/bin/bitcoin-core-0.15.1/bitcoin-0.15.1-x86_64-linux-gnu.tar.gz
#tar -xvf bitcoin-0.15.1-x86_64-linux-gnu.tar.gz
#cp bitcoin-0.15.1/bin/bitcoind ~
#cp bitcoin-0.15.1/bin/bitcoin-cli ~
#rm bitcoin-0.15.1-x86_64-linux-gnu.tar.gz
#chmod 755 $HOME/bitcoind
#chmod 755 $HOME/bitcoin-cli


#cron setup
sudo mv /home/$COIN/safestop.sh /root
sudo -u $COIN crontab /home/$COIN/bitseed-web-ui-2/setup/cron
sudo crontab /home/$COIN/bitseed-web-ui-2/setup/rootcron
#sudo cp /home/$COIN/bitseed-web-ui-2/rc.local /etc/rc.local

#sed -i '1s/^/ bash /home/bitcoin/ui_init.sh/' /etc/rc.local

#Tor setup
sudo apt-get install -y tor
rm $HOME/.bitcoin/onion_private_key
sudo echo "HiddenServiceDir /var/lib/tor/bitseed-service/" >> /etc/tor/torrc
sudo echo "HiddenServicePort 80 127.0.0.1:82" >> /etc/tor/torrc
sudo echo "ControlPort 9051" >> /etc/tor/torrc
sudo echo "CookieAuthentication 1" >> /etc/tor/torrc
sudo usermod -a -G debian-tor $COIN
sudo service tor restart
sleep 5
sudo cat /var/lib/tor/bitseed-service/hostname
sudo cat /var/lib/tor/bitseed-service/hostname > $HOME/onion

#finish
sudo chown -R $COIN:$COIN $HOME
echo "4" > $HOME/restartflag
cat $HOME/deviceid*
echo "setup done"

