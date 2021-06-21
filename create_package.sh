#!/bin/sh

# our dist directory
mkdir -p dist

# create a clean debian package directory
rm -rf debian
mkdir -p debian/DEBIAN
mkdir -p debian/var/www/minitoring
mkdir -p debian/etc/systemd/system

# populate the debian directory
cp control              debian/DEBIAN
cp postinst.sh          debian/DEBIAN/postinst
cp postrm.sh            debian/DEBIAN/postrm
cp prerm.sh             debian/DEBIAN/prerm

cp LICENSE              debian/var/www/minitoring
cp composer.lock        debian/var/www/minitoring
cp composer.json        debian/var/www/minitoring
cp -R app               debian/var/www/minitoring
cp -R public            debian/var/www/minitoring

cp minitoring.service   debian/etc/systemd/system

# make sure data directory does not contain unwanted files
rm -rf debian/var/www/minitoring/app/assets
rm -f debian/var/www/minitoring/app/config/minitoring.conf.local.php
find  debian/var/www/minitoring/app/data/config -type f -not -name '*.keep' -delete
find  debian/var/www/minitoring/app/data/config -type f -not -name '*.keep' -delete
find  debian/var/www/minitoring/app/data/db -type f -not -name '*.keep' -delete
find  debian/var/www/minitoring/app/data/avatar -type f -not -name 'default.jpg' -delete
find  debian/var/www/minitoring/app/data/log -type f -not -name '*.keep' -delete

# finish through fakeroot so we can adjust ownerships without needing to be root    
# fakeroot ./finish_package.sh debian .
# fakeroot ./finish_package.sh debian dist

# adjust ownerships
chown -R root:root debian
chown -R root:www-data debian/var/www/minitoring
chmod -R 0750 debian/var/www/minitoring
chmod -R 0770 debian/var/www/minitoring/app/data
chmod -R 0644 debian/etc 

# minimal permissions required for scripts
chmod 755 debian/DEBIAN/postinst
chmod 755 debian/DEBIAN/prerm
chmod 755 debian/DEBIAN/postrm

# finally build the package
dpkg-deb --build debian dist