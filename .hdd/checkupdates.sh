#!/bin/bash
#downloads an update notification script from bitseed.org
#this script is run by crontab
rm $HOME/v3update.sh
auto=$(awk -F ' *= *' '$1=="autoupdate"{print $2}' $HOME/.bitseed/bitseed.conf)
if (( $auto == 1 )); then
   wget https://www.bitseed.org/device/updater/v3update.sh
   chmod 755 $HOME/v3update.sh
   echo "update check $(date)" >> $HOME/.bitseed/bitseed.log
fi
exit
