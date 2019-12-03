# Installation:
Exported from https://code.google.com/p/libstats/

These instructions are assuming you are installing this onto a LAMP server

First add the following repository:

	add-apt-repository ppa:ondrej/php

Install the following:
	
	apt install apache2 mysql-server php5.6 php5.6-xml php5.6-mysql php5.6-curl
	
	apt install php-pear

Enable the Apache2 Rewrite mod:

	a2enmod rewrite

Install Pear DB:
	
	pear install db

Change directory to /etc/apache2 and open apache2.conf in a text editor. Change the <Directory /var/www/> section to the following:

	<Directory /var/www/>
		Options Indexes FollowSymLinks
		AllowOverride All
		Order allow,deny
		allow from all
		Require all granted
	</Directory>

If the contents of libstats is not on the server, put it on there now. Move the contents to your Apache web folder (i.e. /var/www/html)

Enter mysql to create your database:

	mysql> create database libstats;

Create your libstats user: 

	mysql> GRANT SELECT, UPDATE, DELETE, INSERT ON libstats.* TO '[USER]'@'localhost' IDENTIFIED BY '[PASSWD]';

Import the sql database (Make sure to change the admin password on the final line of the libstats.sql before importing!):

	mysql> use libstats;
	
	mysql> source /path/to/libstats.sql;

Edit init.php with database and user/pass you created:
	
	$dbHost = 'localhost';
	$dbName = 'libstats';
	$dbUser = '[USER]';
	$dbPass = '[PASSWD]';

If everything was set up correctly, you should be able to access the website and login with your admin account. Make appropriate changes to your mysql database tables to customize the site to your liking.



