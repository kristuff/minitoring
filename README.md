# ![logo](/public/assets/img/favicon-32x32.png) minitoring

> *Mini* monitoring web-based app and CLI tool for Gnu/linux server. 

**/!\ In progress...** 

![preview_dark](/doc/img/overview_dark.png)

![preview_logs](/doc/img/log_apache_access.png)

![preview_packages](/doc/img/packages.png)

## Main features

*Monitoring*

Feature | Web   | CLI
----    |---    |---
Get **system** infos: O/S, kernel version, uptime/last boot date | ✔️| ✔️ |
Get **CPU** infos: model, frequency, cores number, bogomips, temperature | ✔️| ✔️ |
Get **Network** usage: displaying the IP address of each network interface with the data transmitted and received | ✔️| ✔️ |
Check **memory**/**swap** usage | ✔️| ✔️ |
Check **disks**/**inodes** usage  | ✔️| ✔️ |
Check **packages**: installed, upgradable, error (*.deb packages only*) | ✔️| - |
Check **Fail2ban** status and get jails stats | ✔️ (*stats based on db*)| -|
Check **Iptables**/**Ip6tables** content | ✔️| - |
Check **ping** stats for a configurable host list  | ✔️ | ✔️ |
List all **cron jobs** (user/system crons, system timers) | ✔️| - |
**Logs reader**: support for configurable logs list, including `syslog`, `Apache` access/error, `Fail2ban` logs | ✔️| - |
**Services** status check (check tcp/udp port) for configurable services list | ✔️| - |
List system **users**/**groups**, last/currently connected users | ✔️| - |

*Web app*
- Lightweight and smooth javascript navigation system
- Responsive design
- Dark/Light theme
- Localization (EN, FR)
- Web installer


## Requirements
- A Linux<sup>1</sup> web server<sup>2</sup> with root privileges
- A dedicated subdomain OR a server with graphical interface to run app in local <sup>3</sup>
- PHP >=7.3
- pdo_sqlite extension

<sup>1</sup> For now tested only on Debian 10, Ubuntu 21.04, Linux Mint 20.1 

<sup>2</sup> For now tested only with Apache.

<sup>3</sup> For now Alias is not supported.

## How it works ?
Minitoring is inspired from [ezservermonitor-web](https://github.com/shevabam/ezservermonitor-web) and comes with additional features.

Basic monitoring commands can be executed by web server process without admin permissions. Such data are available via a *standard* web API (protected by a login system). 

For some features (logs reader, packages, fail2ban stats...), app must be run with root privileges: Minitoring comes with a WebSocket server wich is run as service and completes the web API (protected by a token). 


## Install
For now Minitoring is only available as `.deb` package. 

See [Install minitoring on debian bullseye with Apache](/doc/install.md).

For others systems, you will have to build the package:
- Install dependencies and build autoloader using `composer`.
- \[Install dev dependencies and compile scss/js (requires `npm`)] *I try to keep the assets directory up to date*
- Run and manage minitoring-server


## Config
Most config tasks are done by web installer or can be changed from web interface (only admin user can change monitoring settings). For advanced config changes, like using a custom port or secure WebSocket server, see [config](/doc/config.md). 


## Limitations/known issues/TODO
- You cannot be logged in with the same account on multiple devices at the same time (**won't fix**). 
- Message when login with cookie is not localized (?)
- Web installer does not honor Mysql and PostgreSQL, for now Sqlite only (**TODO** but for now, no periodic monitoring so large database not needed)
- Packages: deb only, support for `rpm` packages should come soon (**TODO** -> config)
- Supposes iptables/ip6tables used (**TODO** -> option).
- Supposes Fail2ban used (**TODO** -> option).
- Supposes systemd is init program: maintainer scripts take care to check that systemd is the init program before running scripts but there is for now no alternative. 
- Translation in progress
- Logreader: To add a log file, webserver checks file exists first. To add log files like apache logs, located in `/var/log/apache2` on debian, you need to add `execute` permission to that directory (`chmod +x /var/log/apache2`), otherwise, app will refuse to add file saying it doesn't exist. Note: no need to add `read` permission to web server as file will be read by a service launch by root.
