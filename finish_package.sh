#!/bin/sh

# $1 is the debian directory, $2 is the output directory

# adjust ownerships
chown -R root:root $1
chown -R root:www-data $1/var/www/minitoring
chmod -R 0750 $1/var/www/minitoring
chmod -R 0770 $1/var/www/minitoring/app/data
chmod -R 0644 $1/etc 

# minimal permissions required for scripts
chmod 755 $1/DEBIAN/postinst
chmod 755 $1/DEBIAN/prerm
chmod 755 $1/DEBIAN/postrm

# finally build the package
dpkg-deb --build $1 $2