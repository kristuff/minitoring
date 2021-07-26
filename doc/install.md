# ![logo](../public/assets/img/favicon-32x32.png) minitoring


## Install minitoring on debian buster server with Apache

> The following guide supposes:
> - a debian based server with root access and running systemd
> - Apache2 with `mod_ssl` enabled and SSL certificate files 
> - a subdmain with dedicated vhost.  
> - `apt-transport-https`

### 1. Install package

#### 1.1 Configure apt repo

Packages are available on [packages.kristuff.fr](https://packages.kristuff.fr). You can use `apt-key` to configure `apt` but its deprecated (still available in debian 11 then removed and already deprecated in ubuntu 21.04).

[Instructions to connect to a third-party repository](https://wiki.debian.org/DebianRepository/UseThirdParty).

- Configure apt using apt-key

    -   ##### Import the repository signing key
        
        Add the public key to the APT keyring:

        ```
        wget -qO - https://packages.kristuff.fr/kristuff@kristuff.fr.gpg.key | sudo apt-key add -
        ```


    -   ##### Setup APT sources list:

        Create a file `kristuff.list` in `/etc/apt/sources.list.d/` with the following content:

        ```
        deb https://packages.kristuff.fr buster main
        deb-src https://packages.kristuff.fr buster main
        ```

-  Configure apt using [debian instructions to connect to a third-party repository](https://wiki.debian.org/DebianRepository/UseThirdParty).


    -   ##### Import the repository signing key
    
        Download and store the public key using curl (as root):

        ```
        curl https://packages.kristuff.fr/kristuff@kristuff.fr.gpg.key | gpg --dearmor > /usr/share/keyrings/kristuff-archive-keyring.gpg
        ```

    -   ##### Setup APT sources list:

        Create a file `kristuff.list` in `/etc/apt/sources.list.d/` with the following content:

        ```
        deb [signed-by=/usr/share/keyrings/kristuff-archive-keyring.gpg] https://packages.kristuff.fr/ buster main
        deb-src [signed-by=/usr/share/keyrings/kristuff-archive-keyring.gpg] https://packages.kristuff.fr/ buster main
        ```

    > If you want to use a different name, make sure to use the same name in key file and source list file: `<name>-archive-keyring.gpg` + `/etc/apt/sources.list.d/<name>.list` 


#### 1.2 Install package:

```
apt-get update
apt-get install minitoring
```

Minitoring  `app` and `public` folders are deployed to `/var/www/minitoring`.



### 2. Optional config changes :

See [config](/doc/config.md) 



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

    > You can enable the `minitoring` apache conf that contains the block code above
    > 
    > ```
    > a2enconf minitoring
    > ```

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


### 4.  Restart `minitoring.service`, Enable apache modules, site and restart Apache:

-   Enable the following Apache modules:

    ```apache-conf
    a2enmod rewrite
    a2enmod proxy
    a2enmod proxy_http
    a2enmod proxy_wstunnel
    ```

-   `minitoring.service` is started during install. If you have made changes to the default configuration (port, secure server), you need to restart service: 

    ```
    systemctl restart minitoring
    ```

-   Restart Apache:

    ```
    systemctl restart apache2
    ```

### 5.  Complete install with web installer:

When running the app for the first time and as long as setup is not complete, you will be redirect to `/setup`. You will be asked identifiers to create a database and an admin account.
