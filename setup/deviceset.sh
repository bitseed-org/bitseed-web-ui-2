#prepare a device
#assumes ubuntu server 16.04  with oem as user
#run as root

#ssh access
#sudo apt-get install openssh-server

#change host name
sudo hostname bitseed3
sudo rm /etc/hostname
sudo echo "bitseed3" >> /etc/hostname
sudo sed -i "s/ubuntu/bitseed3/g" /etc/hosts

#new user
sudo adduser --quiet --disabled-password --shell /bin/bash --home /home/bitcoin --gecos "User" bitcoin
echo 'bitcoin:bitcoin' | sudo chpasswd
sudo usermod -aG sudo bitcoin
#sudo su bitcoin
#sudo cd /home/bitcoin
#sudo pkill -KILL -u oem
#sudo userdel -r oem


#copy blockchain
#sudo mkdir /home/bitcoin/temp
#sudo mount /dev/sdc1 /home/bitcoin/temp
#sudo chown -R bitcoin:bitcoin /home/bitcoin/temp
#bash /home/bitcoin/temp/importchain.sh


#Finish
#https://github.com/bitseed-org/bitseed-web-ui-2.git
#sudo umount /home/bitcoin/temp

echo "device setup complete"
