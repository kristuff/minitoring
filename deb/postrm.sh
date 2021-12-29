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


echo "Minitoring is now uninstalled"

