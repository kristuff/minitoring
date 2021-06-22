#!/bin/sh

# colors
RESET="\e[0m"
ORANGE="\e[38;5;202m"
WHITE="\e[0;49;97m"
GREEN="\e[0;49;32m"
YELLOW="\e[0;49;93m"
RED="\e[0;49;31m"

#echo   "-------------------------------------"
#echo -e  "Thanks for installing ${ORANGE}Minitoring${RESET}"

# minitoring.service has been created 
# enable the service (will start on reboot) en start the service
echo "Reload system daemons"
systemctl daemon-reload

echo -e "Enable ${YELLOW}minitoring.service${RESET} (will start on reboot)"
systemctl enable minitoring.service
echo -e "Starting ${YELLOW}minitoring.service${RESET}"
systemctl start minitoring.service

# client
echo -e "Deploy ${YELLOW}minitoring-client${RESET} to /usr/local/sbin"
mkdir -p /usr/local/sbin
ln -s /var/www/minitoring/app/bin/minitoring-client /usr/local/sbin/minitoring

echo -e "${ORANGE}Minitoring${RESET} is ready"
echo  "-------------------------------------"



#echo -e "${GREEN}# To complete installation you need to configure Apache server and ${RESET}"
#echo -e "${GREEN}# configure the minitoring.service to use https. ${RESET}"
#echo -e "${GREEN}# Check out the documentation.${RESET}"

