Dedman Pickup
=====================

####To Access Ionic App
Simply go to the URL of the staging/production server:
Staging: `104.236.10.218`
Production: `104.236.33.141`

####To Access Slim
Access either server with the extension `/slim/public/index.php/{endpoint}`
For example, to access the 'hello' endpoint of the staging server, use:
`104.236.10.218/slim/public/index.php/hello`

##To Setup a New Server (I made my own for development)
#### Create a DigitalOcean droplet with the LAMP Stack
Follow the directions on their site
#### Load our code into the droplet
Go into /var/www, delete the html directory and clone this repository with
`https://github.com/SMUCSEG2Consulting/DedmanPickup`
#### Setup MySQL
The password for MySQL is in /etc/motd.tail
Find the password, use it to login as follows: `mysql -u root -p` and then enter the password.
Change the password `SET PASSWORD FOR 'root'@'localhost' = PASSWORD('');`\
#### Make sure it works.
Find your droplet's IP on the DigitalOcean site.
Go to `yourIP` in a web browser. You should see the Ionic app.
Go to `yourIP/slim/public/index.php/hello` in a web browser. You should see the slim homepage.
If you don't see one or both of these, contact me (Ian).

