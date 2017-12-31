#prepare a device
#assumes ubuntu server 16.04  with oem as user
#run as root

#ssh access
sudo apt-get install openssh-server

#new user
sudo adduser --quiet --disabled-password --shell /bin/bash --home /home/bitcoin --gecos "User" bitcoin
echo 'bitcoin:bitcoin' | sudo chpasswd
sudo usermod -aG sudo bitcoin
sudo su bitcoin
cd $HOME
sudo userdel -r oem

#copy blockchain
sudo mkdir /home/bitcoin/temp
sudo mount /dev/sdc1 /home/bitcoin/temp
sudo chown -R bitcoin:bitcoin /home/bitcoin/temp
bash /home/bitcoin/temp/importchain.sh

#change host name
sudo hostname bitseed3
sudo rm /etc/hostname
sudo echo "bitseed3" >> /etc/hostname
sudo sed -i "s/ubuntu/bitseed3/g" /etc/hosts
