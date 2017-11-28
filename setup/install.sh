#!/bin/bash
#install Bitseed V3 GUI for Bitcoin Core bitcoind
#Ubuntu 16 supported

#dependencies
sudo apt-get update
sudo apt-get -y install apache2 libapache2-mod-php php-mysql php-curl php-mcrypt dnsutils ntp python

#set serial number
echo "Enter device serial number:"
read serial
echo $serial > $HOME/"deviceid-$serial"

#Apache config
sudo cp $HOME/bitseed-web-ui-2/000-default.conf  /etc/apache2/sites-enabled/
sudo cp  $HOME/bitseed-web-ui-2/ports.conf  /etc/apache2/
sudo cp -r $HOME/bitseed-web-ui-2/html/* /var/www/html
sudo echo $serial > /var/www/html/serial
sudo chmod 666 /var/www/html/*.txt
sudo chown -R www-data:www-data /var/www

#home directory files
cp -r $HOME/bitseed-web-ui-2/.hdd/*  $HOME
touch $HOME/rd_bconf_flag
touch $HOME/wr_bconf_flag
touch $HOME/wr_bconf_mbox
touch $HOME/rd_bconf_mbox
sudo chown $USER:$USER $HOME/*.py
sudo chown $USER:$USER $HOME/*.sh
sudo chown $USER:$USER $HOME/*flag
sudo chown $USER:$USER $HOME/*mbox
sudo chmod 755 $HOME/*.py
sudo chmod 755 $HOME/*.sh
sudo chmod 666 $HOME/rd_bconf_flag
sudo chmod 666 $HOME/wr_bconf_flag
sudo chmod 666 $HOME/bconf
sudo chmod 666 $HOME/wr_bconf_mbox
sudo chmod 666 $HOME/rd_bconf_mbox
sudo chmod 666 $HOME/restartflag
sudo chmod 666 $HOME/.bitcoin/bitcoin.conf
mkdir $HOME/.bitseed
sudo cp $HOME/bitcoin-box/.hdd/bitseed.conf $HOME/.bitseed
sudo echo "211" > $HOME/version
sudo /etc/init.d/apache2 restart
echo "web admin install done" > $HOME/bitcoin-box/setup/setup.log

#Tor setup
sudo apt-get install -y tor
sudo echo "HiddenServiceDir /var/lib/tor/bitseed-service/" >> /etc/tor/torrc
sudo echo "HiddenServicePort 80 127.0.0.1:82" >> /etc/tor/torrc
sudo echo "ControlPort 9051" >> /etc/tor/torrc
sudo echo "CookieAuthentication 1" >> /etc/tor/torrc
sudo usermod -a -G debian-tor $USER 
sudo service tor restart
sleep 5
sudo cat /var/lib/tor/bitseed-service/hostname
echo "setup done.  reboot"
