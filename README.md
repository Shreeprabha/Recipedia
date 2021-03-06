Recipedia
=======================

Introduction
------------
This is a recipe collection application using the ZF2 MVC layer and module
systems. 

Installation
------------

    git clone git://github.com/Shreeprabha/Recipedia.git --recursive

Web Server Setup
----------------

### PHP CLI Server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note: ** The built-in CLI server is *for development only*.

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName recipedia.localhost
        DocumentRoot /path/to/recipedia/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/recipedia/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
