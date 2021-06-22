#!/bin/sh

# colors
RESET="\e[0m"
ORANGE="\e[38;5;202m"
WHITE="\e[0;49;97m"
GREEN="\e[0;49;32m"
YELLOW="\e[0;49;93m"
RED="\e[0;49;31m"

echo "Reload system daemons"
systemctl daemon-reload
systemctl reset-failed

echo -e  "${ORANGE}Minitoring${RESET} is now uninstalled"

