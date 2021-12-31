# ![logo](../public/assets/img/favicon-32x32.png) minitoring


## Install minitoring on debian bullseye server with Apache

> The following guide supposes:
> - a debian based server with root access and running systemd
> - Apache2 + 
>   - a dedicated subdomain with its vhost, `mod_ssl` enabled and SSL certificate files 
>   - OR a server with graphical interface to run app in local 
> - `apt-transport-https`

### 1. Install package

Packages (`.deb`) are available on [packages.kristuff.fr/debian/](https://packages.kristuff.fr/debian/). You can configure `apt` to connect kristuff repository (see instructions here: [packages.kristuff.fr/](https://packages.kristuff.fr/)) and install it: 

```.language-bash
apt-get update
apt-get install minitoring
```
    
Alternatively, you can download the latest `.deb` package from release tags and install it using `dpkg -i`.

Minitoring library is deployed to `/usr/share/minitoring/`. A symlink to executable is created in `/usr/bin` and config (in INI format) is located in `/etc/minitoring/`.
By default, a *data* directories are created in `/var/lib/minitoring/`.

> ⚠️ In previous release, the whole app was deployed in `/var/www/minitoring`. If you upgrade and have data stored in that location, you need to move the content to `/var/lib/minitoring`. For example, `/var/www/minitoring/app/data/db.` becomes `/var/lib/minitoring/db`. The whole directory must be writable by webserver. You will also need to update your apache config with new DocumentRoot (see above) and change the database path in the `config/db.config.php`.  You may also need to change other optional config, see above. 

### 2. Optional config changes:

Most config tasks are done with web installer or can be changed from web interface. For advanced settings, like changing the data directories or using a custom port for websocket service, see [config](/doc/config.md) 


### 3. Configure Apache vhost:

The directory `app/config/sample` contains a full vhost sample. The main points are the following: 

-   Setup Document root to `/usr/share/minitoring/public`

    ```apache-conf
    DocumentRoot  /usr/share/minitoring/public
    ```

-   Setup app rooter (require `mod_rewrite`): 

    ```apache-conf
    <Directory /usr/share/minitoring/public/>
        Options +FollowSymLinks
        Options -Indexes -Includes
        AllowOverride None
        Require all granted
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-l
        RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
    </Directory>
    ```

-   Configure WebSocket API proxy for the url `/wssapi`:

    > Adjust the port, here *12443*, the default value.

    ```apache-conf
    SSLProxyEngine on
    SSLProxyVerify none 
    SSLProxyCheckPeerCN off
    SSLProxyCheckPeerName off
    SSLProxyCheckPeerExpire off
    ProxyPass "/wssapi" "wss://localhost:12443"
    ProxyPassReverse "/wssapi" "wss://localhost:12443"
    ProxyRequests off
    ProxyPreserveHost On 
    ```

    If you want to test app from localhost, configure ProxyPass like this (note `ws://`instead of `wss://`):

     ```apache-conf
    ProxyPass "/wssapi" "ws://localhost:12443"
    ProxyPassReverse "/wssapi" "ws://localhost:12443"
    ProxyRequests off
    ProxyPreserveHost On 
    ``` 


### 4.  Restart `minitoring-server.service`, Enable apache modules, site and restart Apache:

-   Enable the following Apache modules:

    ```apache-conf
    a2enmod rewrite
    a2enmod proxy
    a2enmod proxy_http
    a2enmod proxy_wstunnel
    ```

-   `minitoring-server.service` is started during install. If you have made changes to the default configuration (port, secure server), you need to restart service: 

    ```
    systemctl restart minitoring-server
    ```

-   Restart Apache:

    ```
    systemctl restart apache2
    ```

### 5.  Complete install with web installer:

When running the app for the first time and as long as setup is not complete, you will be redirect to `/setup`. You will be asked identifiers to create a database and an admin account.

Then you can login with your *admin* account and:
- configure services to check, logreader, advanced settings 
- create *guest* accounts: those accounts have a readonly access to all monitoring features
