#!/usr/bin/env bash

#MINITORING_SERVICE_CONF_PATH="/etc/systemd/system/minitoring.service"
MINITORING_SERVICE_CONF_PATH="/home/chris/projects/minitoring/app/install/test.service"
WEB_SERVER_USER="www-data"
OWNER_USER="$(whoami)"

#   !------------------------!
#   !     END USER CONFIG    !
#   !   Do not edit bellow   !
#   !------------------------!

MINITORING_VERSION="0.1.1"
CURRENT_SCRIPT_PATH=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
APP_BIN_PATH=$(readlink -f "${CURRENT_SCRIPT_PATH}/../bin")
MINITORING_ROOT_PATH=$(readlink -f "${CURRENT_SCRIPT_PATH}/../../")

MINITORING_SERVICE_EXECUTABLE_PATH=$(readlink -f "${CURRENT_SCRIPT_PATH}/../bin/minitoring-server")
SCRIPT_START_DATE=$(date +%s)
COMPOSER_PATH=""

# colors
RESET="\e[0m"
ORANGE="\e[38;5;202m"
WHITE="\e[0;49;97m"
GREEN="\e[0;49;32m"
YELLOW="\e[0;49;93m"
RED="\e[0;49;31m"

function log() {
    #local message="$(date '+%Y-%m-%d %H:%M:%S') $1"
    local message="$1"
    echo -e "$message" 
}

# /!\ TODO check exists

function service_conf_reset() {
    echo "" > "$MINITORING_SERVICE_CONF_PATH"
    log "File ${YELLOW}${MINITORING_SERVICE_CONF_PATH}${RESET} reseted"
}

function service_conf_add() {
    echo "$1" >> "$MINITORING_SERVICE_CONF_PATH"
}

function add_cron_tab() {
    crontab -l | { cat; echo "$1"; } | crontab -
}


function check_composer() {
    log "Checking composer..."
    if command -v composer > /dev/null; then
        COMPOSER_PATH=composer
        log "composer is installed globally"
    elif command -v composer.phar > /dev/null; then
        COMPOSER_PATH=composer.phar
        log "composer.phar is installed globally"
    else
        log "composer executable not found, download lastest version"
        get_composer    
        COMPOSER_PATH=$APP_BIN_PATH/composer
    fi
}

# get latest version of composer and
# store it to bin dir
function get_composer() {
    local ACTUAL_CHECKSUM
    local EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
  
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
    then
        >&2 log 'ERROR: Invalid installer checksum'
        rm composer-setup.php
        exit 1
    fi

    # We want the executable name to be 'composer', not 'composer.phar'
    # and locate the executable in our bon folder 'minitoring/app/bin'
    php composer-setup.php --quiet --install-dir="$APP_BIN_PATH" --filename=composer
    RESULT=$?
    rm composer-setup.php
    if [ "$RESULT" = 0 ]; then
        chmod +x "$APP_BIN_PATH/composer"
        log "Composer successfully deployed to $APP_BIN_PATH/composer"
    fi
    #exit $RESULT
}

function add_service() {
    cat <<EOF > "${MINITORING_SERVICE_CONF_PATH}"
[Unit]
Description=Minitoring WebSocket service
After=network.target
StartLimitIntervalSec=0

[Service]
Type=simple
Restart=always
RestartSec=1
User=root
ExecStart=/usr/bin/env php ${MINITORING_SERVICE_EXECUTABLE_PATH}

[Install]
WantedBy=multi-user.target
EOF

    log "File ${YELLOW}${MINITORING_SERVICE_CONF_PATH}${RESET} successfully created"
}


# *************
# start install
# *************

log "Starting install..."

# check if composer is installed globally
# if not, download latest version and store it in bin dir
check_composer

# install dependencies, build autoloader (optimized)
cd $MINITORING_ROOT_PATH && $COMPOSER_PATH install --no-dev --prefer-dist --optimize-autoloader

# fix permissions
log "Fix permissions..."
sudo chown -R $OWNER_USER:$WEB_SERVER_USER $MINITORING_ROOT_PATH
sudo chmod -R 754 $MINITORING_ROOT_PATH
sudo chmod -R 774 $MINITORING_ROOT_PATH/app/data

# create service, start the service
# and automatically get it to start on boot:
log "Creating systemd.service for Minitoring-server"
add_service

log "Enable Minitoring-server (will start on reboot)"
#systemctl daemon-reload
#systemctl enable minitoring-server

log "Starting Minitoring-server"
#systemctl start minitoring-server

log "Install finished"
