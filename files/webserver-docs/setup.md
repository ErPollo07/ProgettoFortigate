# Webserver

## Install apache

```bash
sudo apt update
sudo apt install -y apache2
sudo systemctl enable --now apache2
```

### Install php for Apache

```bash
sudo apt install -y php libapache2-mod-php
sudo systemctl restart apache2
```

## Create the files

Put the files in `/var/www/html/`.
Remove the `index.html` and create a `index.php` file.

## Install mysql for database connection in php

```bash
sudo apt update
sudo apt install php-mysql
sudo systemctl restart apache2
```

## Visit the site

Connect to `http://<IP>`
