## Introduction

This is a skeleton application using the Zend Framework MVC layer and module
systems.

## Installation using Composer

The easiest way to create a new Zend Framework project is to use
[Composer](https://getcomposer.org/).  If you don't have it already installed,
then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

To create your new Zend Framework project:

```bash
$ composer create-project -sdev zendframework/skeleton-application path/to/install
```

Once installed, you can test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/install
$ php -S 0.0.0.0:8080 -t public
# OR use the composer alias:
$ composer run --timeout 0 serve
```

This will start the cli-server on port 8080, and bind it to all network
interfaces. You can then visit the site at http://localhost:8080/
- which will bring up Zend Framework welcome page.

**Note:** The built-in CLI server is *for development only*.

## Development mode

The skeleton ships with [zf-development-mode](https://github.com/zfcampus/zf-development-mode)
by default, and provides three aliases for consuming the script it ships with:

```bash
$ composer development-enable  # enable development mode
$ composer development-disable # disable development mode
$ composer development-status  # whether or not development mode is enabled
```
Development mode is automatically enabled as part of the skeleton installation process. 
After making changes to one of the above-mentioned `.dist` configuration files you will
either need to disable then enable development mode for the changes to take effect,
or manually make matching updates to the `.dist`-less copies of those files.

## Using docker-compose

This skeleton provides a `docker-compose.yml` for use with
[docker-compose](https://docs.docker.com/compose/); it
uses the `Dockerfile` provided as its base. Build and start the image using:

```bash
$ docker-compose up -d --build
```

At this point, you can visit http://localhost:8080 to see the site running.

## Web server setup

### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

```apache
<VirtualHost *:80>
    ServerName zfapp.localhost
    DocumentRoot /path/to/zfapp/public
    <Directory /path/to/zfapp/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_authz_core.c>
        Require all granted
        </IfModule>
    </Directory>
</VirtualHost>
```
