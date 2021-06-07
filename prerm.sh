#!/bin/sh

# colors
RESET="\e[0m"
ORANGE="\e[38;5;202m"
WHITE="\e[0;49;97m"
GREEN="\e[0;49;32m"
YELLOW="\e[0;49;93m"
RED="\e[0;49;31m"

# disable and remove minitoring.service
echo -e "Stopping ${YELLOW}minitoring.service${RESET}"
systemctl stop minitoring
echo -e "Disable ${YELLOW}minitoring.service${RESET}"
systemctl disable minitoring.service
