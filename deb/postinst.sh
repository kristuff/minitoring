#!/bin/sh

# systemd ?
INIT_PROG=$(ps -p 1 -o comm=)

if [ "$INIT_PROG" = "systemd" ]; then 
    # minitoring.service has been created 
    # enable the service (will start on reboot) en start the service
    echo "Reload system daemons ..."
    systemctl daemon-reload
    echo "Enable minitoring.service ..."
    systemctl enable minitoring.service
    echo "Starting minitoring.service ..."
    systemctl start minitoring.service

else
    # not systemd
    echo "[warning] Systemd is not the init program, minitoring.service has not been configured. See doc for more infos."
fi;



# client
echo "Deploying minitoring-client ..."
mkdir -p /usr/local/sbin



ln -s /var/www/minitoring/app/bin/minitoring-client /usr/local/sbin/minitoring
if [ $? -eq 0 ]; then
    echo "Created symlink /usr/local/sbin/minitoring → /var/www/minitoring/app/bin/minitoring-client."
else
    echo "[Error] Unable to create symlink /usr/local/sbin/minitoring."
fi

echo "Minitoring is ready"

#echo -e "${GREEN}# To complete installation you need to configure Apache server and "
#echo -e "${GREEN}# configure the minitoring.service to use https. "
#echo -e "${GREEN}# Check out the documentation."
