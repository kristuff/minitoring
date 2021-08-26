#!/bin/sh

# systemd ?
INIT_PROG=$(ps -p 1 -o comm=)

if [ "$INIT_PROG" = "systemd" ]; then 

    # disable and remove minitoring.service
    echo "Stopping minitoring.service ..."
    systemctl stop minitoring
    echo "Disable minitoring.service ..."
    systemctl disable minitoring.service

#else
    # not systemd
fi;


echo "Remove minitoring-client from /usr/local/sbin ..."
\rm -f /usr/local/sbin/minitoring
