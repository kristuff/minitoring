# ![logo](../public/assets/img/favicon-32x32.png) minitoring


## Install minitoring on debian based server with Apache

> The following guide supposes:
> - a debian based server root access
> - Apache2 with `mod_ssl` enabled and SSL certificate files 
> - a subdmain with dedicated vhost.  

### 1. Download and install the latest `.deb` package from [TODO]: 

```
wget https://TODO/minitoring_X.X.X_all.deb
dpkg -i minitoring_X.X.X_all.deb
```

Minitoring  `app` and `public` folders are deployed to `/var/www/minitoring`.


### 2. Enable Apache modules:

```apache-conf
a2enmod rewrite
a2enmod proxy
a2enmod proxy_http
a2enmod proxy_wstunnel
```

### 3. Configure Apache whost:

The directory `app/config/sample` contains a full vhost sample. The main points are the following: 

-  Setup Document root to `/var/www/minitoring/public`

```apache-conf
DocumentRoot  /var/www/minitoring/public
```

-  Setup app rooter (require `mod_rewrite`): 

```apache-conf
<Directory /var/www/minitoring/public/>
    Options +FollowSymLinks
    Options -Indexes -Includes
    AllowOverride None
    Require all granted
    
    # ---------------------- 
    # --- WEB APP ROOTER --- 
    # ---------------------- 
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-l
    RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
</Directory>
```


- Configure websocket API proxy for the url `/server-api`:

> Adjust the port, here *12443*, the default value.

```apache-conf
# --------------------- 
# --- WEBSOCKET API --- 
# ---------------------
SSLProxyEngine on
SSLProxyVerify none 
SSLProxyCheckPeerCN off
SSLProxyCheckPeerName off
SSLProxyCheckPeerExpire off
ProxyPass "/server-api" "wss://localhost:12443"
ProxyPassReverse "/server-api" "wss://localhost:12443"
ProxyRequests off
ProxyPreserveHost On 
```

### 4. Optional config changes :

See [config](/config.md) 


### 5.  Restart `minitoring.service`, Enable site and restart Apache:

```
 systemctl restart minitoring
#...
 systemctl restart apache2
```

