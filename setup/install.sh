#!/bin/bash
#install Bitseed V3 GUI for Bitcoin Core bitcoind
#Ubuntu 16 supported

#dependencies
sudo apt-get update
sudo apt-get install apache2 libapache2-mod-php php-mysql php-curl php-mcrypt

#Apache config
sudo cp $HOME/bitseed-web-ui-2/000-default.conf  /etc/apache2/sites-enabled/
sudo cp  $HOME/bitseed-web-ui-2/ports.conf  /etc/apache2/
sudo chmod 666 /var/www/html/*.txt



sudo chmod 666 $HOME/.bitcoin/bitcoin.conf

