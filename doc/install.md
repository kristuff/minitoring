# ![logo](../public/assets/img/favicon-32x32.png) minitoring


## Install minitoring on debian buster server with Apache

> The following guide supposes:
> - a debian based server with root access
> - Apache2 with `mod_ssl` enabled and SSL certificate files 
> - a subdmain with dedicated vhost.  
> - `apt-transport-https`

### 1. Install package from packages.kristuff.fr: 

-   #### Import the repository signing key
    
    Add the public key to the APT keyring:

    ```
    wget -qO - https://packages.kristuff.fr/kristuff@kristuff.fr.gpg.key | sudo apt-key add -
    ```


-   #### Setup APT sources list:

    Create a file `kristuff.list` in `/etc/apt/sources.list.d/` with the following content:

    ```
    deb https://packages.kristuff.fr buster main
    deb-src https://packages.kristuff.fr buster main
    ```

-   #### Install package:

    ```
    apt-get update
    apt-get install minitoring
    ```

    Minitoring  `app` and `public` folders are deployed to `/var/www/minitoring`.

### 2. Enable Apache modules:

```apache-conf
a2enmod rewrite
a2enmod proxy
a2enmod proxy_http
a2enmod proxy_wstunnel
```

### 3. Configure Apache vhost:

The directory `app/config/sample` contains a full vhost sample. The main points are the following: 

-   Setup Document root to `/var/www/minitoring/public`

    ```apache-conf
    DocumentRoot  /var/www/minitoring/public
    ```

-   Setup app rooter (require `mod_rewrite`): 

    ```apache-conf
    <Directory /var/www/minitoring/public/>
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

-   Configure websocket API proxy for the url `/wssapi`:

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

### 4. Optional config changes :

See [config](/doc/config.md) 


### 5.  Restart `minitoring.service`, Enable site and restart Apache:

```
 systemctl restart minitoring
#...
 systemctl restart apache2
```

