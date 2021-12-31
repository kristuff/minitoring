#!/bin/sh

set -e

# our dist directory
mkdir -p dist

# create a clean debian package directory
rm -rf debian
mkdir -p debian/DEBIAN
mkdir -p debian/usr/share/minitoring
mkdir -p debian/var/lib/minitoring
mkdir -p debian/usr/share/doc/minitoring
mkdir -p debian/usr/share/man/man1
mkdir -p debian/usr/lib/systemd/system
mkdir -p debian/etc/minitoring
#mkdir -p debian/etc/systemd/system
#mkdir -p debian/etc/apache2/conf-available

# populate the debian directory
cp deb/control          debian/DEBIAN
cp deb/conffiles        debian/DEBIAN
cp deb/postinst.sh      debian/DEBIAN/postinst
cp deb/postrm.sh        debian/DEBIAN/postrm
cp deb/prerm.sh         debian/DEBIAN/prerm
cp deb/changelog        debian/usr/share/doc/minitoring/changelog.Debian
gzip -9 -n              debian/usr/share/doc/minitoring/changelog.Debian  
cp deb/changelog        debian/usr/share/doc/minitoring/changelog
gzip -9 -n              debian/usr/share/doc/minitoring/changelog  
cp deb/copyright        debian/usr/share/doc/minitoring


cp LICENSE              debian/usr/share/minitoring
cp composer.lock        debian/usr/share/minitoring
cp composer.json        debian/usr/share/minitoring
cp -R app               debian/usr/share/minitoring
cp -R httpd             debian/usr/share/minitoring
cp -R public            debian/usr/share/minitoring
cp -R data/avatar       debian/var/lib/minitoring
cp -R data/config       debian/var/lib/minitoring
cp -R data/db           debian/var/lib/minitoring
cp -R data/log          debian/var/lib/minitoring
cp etc/minitoring.ini   debian/etc/minitoring

# convert and deploy man page
/usr/bin/pandoc --standalone --to man deb/man1.md -o debian/usr/share/man/man1/minitoring.1  
gzip -9 -n debian/usr/share/man/man1/minitoring.1  

#cp minitoring.apache.conf               debian/etc/apache2/conf-available/minitoring.conf
cp systemd/minitoring-server.service            debian/usr/lib/systemd/system
cp systemd/minitoring-hourly-script.service     debian/usr/lib/systemd/system
cp systemd/minitoring-hourly-script.timer       debian/usr/lib/systemd/system

# make sure data directory does not contain unwanted files
rm -rf debian/usr/share/minitoring/app/assets
rm -f debian/usr/share/minitoring/app/config/minitoring.conf.local.php
rm -f debian/etc/minitoring/minitoring.local

#find  debian/var/lib/minitoring/app/data/config -type f -not -name '*.keep' -delete
find  debian/var/lib/minitoring/config -type f -delete
find  debian/var/lib/minitoring/db -type f -delete
find  debian/var/lib/minitoring/avatar -type f -not -name 'default.jpg' -delete
find  debian/var/lib/minitoring/log -type f -delete

# adjust ownerships
chown -R root:root debian
chown -R root:www-data debian/var/lib/minitoring
find debian -type d -exec chmod 0755 {} \;                               #set directory attributes
find debian -type f -exec chmod 0644 {} \;                               #set data file attributes
find debian/var/lib/minitoring            -type f -exec chmod 0774 {} \; #set writable data file attributes
find debian/usr/share/minitoring/app/bin  -type f -exec chmod 0755 {} \; #set executable attributes

# minimal permissions required for scripts
chmod 755 debian/DEBIAN/postinst
chmod 755 debian/DEBIAN/prerm
chmod 755 debian/DEBIAN/postrm

# finally build the package
dpkg-deb --build debian dist