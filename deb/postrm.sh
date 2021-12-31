#!/bin/sh

# required in maintainer scripts
set -e

# systemd ?
INIT_PROG=$(ps -p 1 -o comm=)

if [ "$INIT_PROG" = "systemd" ]; then 

    echo "Reload system daemons ..."
    systemctl daemon-reload
    systemctl reset-failed

#else
# not systemd
fi;


#if [ "$1" = purge ] && [ -e /usr/share/debconf/confmodule ]; then
#    . /usr/share/debconf/confmodule db_purge
#fi


echo "Minitoring is now uninstalled"

