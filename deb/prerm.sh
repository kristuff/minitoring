#!/bin/sh

# systemd ?
INIT_PROG=$(ps -p 1 -o comm=)

if [ "$INIT_PROG" = "systemd" ]; then 

    # disable and remove minitoring.service
    echo "Stopping minitoring services ..."
    systemctl stop minitoring-ws
    systemctl list-timers | grep "minitoring-hourly-script" >/dev/null && systemctl stop minitoring-hourly-script.timer
    echo "Disable minitoring services ..."
    systemctl disable minitoring-ws.service
    systemctl list-timers | grep "minitoring-hourly-script" >/dev/null && systemctl disable minitoring-hourly-script.timer

#else
    # not systemd
fi;


echo "Remove minitoring-client from /usr/local/sbin ..."
\rm -f /usr/local/sbin/minitoring
