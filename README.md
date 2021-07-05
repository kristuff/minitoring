# ![logo](/public/assets/img/favicon-32x32.png) minitoring

> *Mini* monitoring web-based app and CLI tool for Gnu/linux server. 

## Main features

*Monitoring*
- Get **system** infos: O/S, kernel version, uptime/last boot date, 
- Get **CPU** infos: model, frequency, cores number, bogomips, temperature
- Get **Network** usage: displaying the IP address of each network interface with the data transmitted and received 
- Check **memory**/**swap** usage
- Check **disks**/**inodes** usage
- Check **packages**: installed, upgradable, error (*.deb packages only*) 
- Check **Fail2ban** status and get jails stats
- Check **Iptables**/**Ip6tables** content
- List all **cron jobs** (user/system crons, system timers) 
- **Logs reader**: support for configurable logs list, including `syslog`, `Apache` access/error, `Fail2ban` logs
- **Services** status check (check tcp/udp port) for configurable services list.
- List system **users**/**groups**, last/currently connected users

*Web app*
- Lightweight and smooth javascript navigation system
- Responsive design
- Dark/Light theme
- Localization (EN, FR) ***in progress***
- Web installer


## Requirements
- A Linux[^1] web server[^2] with root privileges
- PHP >=7.3
- pdo_sqlite extension

[^1]: *for now tested only on Debian.* 
[^2]: *for now tested only with Apache.*

## How it works ?
Minitoring is inspired from [ezservermonitor-web](https://github.com/shevabam/ezservermonitor-web). 

Basic monitoring commands can be made by web server process without admin permissions. Such data are available via a *standard* web API (protected by a login system). 

For some features (logs reader, packages, fail2ban stats...), app must be run with root privileges: Minitoring comes with a WebSocket server wich is run as service and completes the web API (protected by a token). 


## Install
For now Minitoring is only available as `.deb` packages. 

See [Install minitoring on debian buster with Apache](/doc/install.md).

For others systems, you will have to build the package:
- run `composer` to install dependencies and build autoloader.
- Compile css/js (requires `NodeJS`)


## Config
Most config tasks are done by web installer or can be changed from web interface (only admin user can change monitoring settings). For advanced config changes, like using a custom port or secure WebSocket server, see [config](/doc/config.md). 


## Limitations/known issues/TODO
- You cannot be logged in with the same account on multiple devices at the same time (won't fix). 
- Web installer does not honor Mysql and PostgreSQL, for now Sqlite only (**TODO** but for now no periodic monitoring so marge database not needed)
- Packages: deb only, support for other systems?
- Suppose Fail2ban installed (**TODO** option)
- Translation in progress
- **In progress...** 
