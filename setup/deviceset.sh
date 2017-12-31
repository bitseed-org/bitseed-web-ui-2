#prepare a device
#assumes ubuntu server 16.04  with oem as user
#run as root

#ssh access
sudo apt-get install openssh-server

#new user
sudo adduser --quiet --disabled-password --shell /bin/bash --home /home/bitcoin --gecos "User" bitcoin
echo 'bitcoin:bitcoin' | sudo chpasswd
sudo usermod -aG sudo bitcoin

