#pull blockchain over local network
#sudo mkdir /home/bitcoin/temp
#sudo mount /dev/sdc1 /home/bitcoin/temp
#sudo chown -R bitcoin:bitcoin /home/bitcoin/temp
#bash /home/bitcoin/temp/importchain.sh

rsync -r --info=progress2 storage@10.1.10.121:/home/storage/disk3/.bitcoin /home/bitcoin
