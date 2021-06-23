# ![logo](../public/assets/img/favicon-32x32.png) minitoring



To change anything in configuration, first create a local config file named `minitoring.conf.local.php` in the `app/config` directory with the following content: 

```php
return array(
      // local changes here...
      
);
```

This file won't be removed when you uninstall the `.deb` package with `dpkg --remove` or during update. To remove it use the `--purge` option.

Use this file to overwrite any value of others config file.  


## Setup custom port

Setup your local config file (`app/config/minitoring.conf.local.php`) like this:

```php
return array(
      // use a custom port
      'WEBSOCKET_PORT'         => 12345,
      
      // other local changes here...
);
```


## Setup a secure websocket server

Setup your local config file (`app/config/minitoring.conf.local.php`) like this:

```php
return array(
      // use a secure websocket server, need to define certificate/key path
      'WEBSOCKET_USE_SECURE'   => true,
      'WEBSOCKET_CERT_PATH'    => '/etc/letsencrypt/live/EXAMPLE/fullchain.pem',
      'WEBSOCKET_KEY_PATH'     => '/etc/letsencrypt/live/EXAMPLE/privkey.pem',
      
      // other local changes here...
);
```

