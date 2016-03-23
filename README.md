Dedman Pickup
=====================

####To Access Ionic App
Simply go to the URL of the staging/production server:
Staging: `104.236.10.218`
Production: `104.236.33.141`
NOTE: THIS IS DEPRECATED. IT NO LONGER WORKS. APP CAN ONLY BE RUN LOCALLY NOW

####To Access Slim
Access either server with the extension `/public/index.php/{endpoint}`
For example, to access the 'hello' endpoint of the staging server, use:
`104.236.10.218/public/index.php/hello`

####Default Login Info
Three testing accounts exist. Their username:password pairs are as follows:

ianjohnson:ianjohnson

iqbalkhan:iqbalkhan

ljbrown:ljbrown

####To Upload GUI Changes to Staging Server
Make sure all of your changes are in the `gui` branch of the git repo

Type this into your kernel: `ssh root@104.236.10.218 "./gui.sh"`

Enter the password.

##To Setup a New Server (I made my own for development)
#### Create a DigitalOcean droplet with the LAMP Stack
Follow the directions on their site
#### Load our code into the droplet
Go into /var and delete the www directory using `rm -r www` and clone this repository with `git clone https://github.com/SMUCSEG2Consulting/DedmanPickup`.
Then rename the folder to www using `mv DedmanPickup www`.

#### Setup Permissions
In /var/www/html, execute the command `chmod -R 757 *`

Go into the 

#### Setup MySQL
The password for MySQL is in /etc/motd.tail

Find the password, use it to login as follows: `mysql -u root -p` and then enter the password.

Change the password `SET PASSWORD FOR 'root'@'localhost' = PASSWORD('');`\
#### Make sure it works.
Find your droplet's IP on the DigitalOcean site.

Go to `yourIP` in a web browser. You should see the Ionic app.

Go to `yourIP/public/index.php/json` in a web browser. You should see a little JSON object.

If you don't see one or both of these, contact me (Ian).


