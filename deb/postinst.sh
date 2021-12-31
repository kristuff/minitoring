#!/bin/sh

# required in maintainer scripts
set -e

# get init program
INIT_PROG=$(ps -p 1 -o comm=)

# ---------------------
# start/enable services
# ---------------------

if [ "$INIT_PROG" = "systemd" ]; then 
    # minitoring.service has been created 
    # enable the service (will start on reboot) en start the service
    echo "Reload system daemons ..."
    systemctl daemon-reload
    echo "Enable minitoring services ..."
    systemctl enable minitoring-server.service
    echo "Starting minitoring services ..."
    systemctl start minitoring-server.service

else
    # not systemd
    echo "[WARNING] Systemd is not the init program, minitoring.service has not been configured. See doc for more infos."
fi;

# Deploy apache conf ?
#if [ -d "/etc/apache2/conf-available" ]; then
#    ln -s /var/www/minitoring/httpd/minitoring.conf /etc/apache2/conf-available
#fi
#if [ -d "/etc/httpd/conf.d" ]; then
#    ln -s /var/www/minitoring/httpd/minitoring.conf /etc/apache2/conf-available
#fi


# client
echo "Deploying minitoring-client ..."
mkdir -p /usr/bin

ln -s /usr/share/minitoring/app/bin/minitoring-client /usr/bin/minitoring
if [ $? -eq 0 ]; then
    echo "Created symlink /usr/bin/minitoring → /var/www/minitoring/app/bin/minitoring-client."
else
    echo "[Error] Unable to create symlink /usr/bin/minitoring."
fi

# ------------------------------------------------------------
# run updater (for db schema changes in already installed app)
# ------------------------------------------------------------
echo "Running minitoring-updater ..."
php /usr/share/minitoring/app/bin/minitoring-updater

echo "Minitoring is ready"

