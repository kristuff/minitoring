# ![logo](/public/assets/img/favicon-32x32.png) minitoring

> *Mini* monitoring web app and CLI tool for Gnu/linux server. 

## Main features

*Monitoring*
- Get O/S, machine, cpu infos
- Check memory/swap usage
- Check disks/inodes usage
- Check packages (installed, upgradable, error)
- Check Fail2ban status and get jail stats
- Check Iptables/Ip6tables content
- List all cron jobs (user/system crons, system timers) 
- **Log reader**: support for syslog, apache access/error, fail2ban logs
- Service check (check tcp/udp port)
- List users/group, last/currently connected users
- ...

*Web app*
- Responsive design
- Dark/Light theme
- Localization (EN, FR) ***in progress***

## Requirements
- A debian based web server with root privileges
- PHP >=7.3
- 

## Limitations/known issues/TODO
- You cannot be logged in with the same account on multiple devices at the same time (won't fix). 
- Web installer does not honor Mysql and PostgreSQL, Sqlite only (**TODO**)
- **In progress...** 