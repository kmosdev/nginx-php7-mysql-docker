# Docker Compose, Nginx, PHP 7, MySQL 5.7

This is a basic set up using docker compose to create an environment running nginx (latest), php 7 and mysql 5.7. This is intended as a development envrionment, there are additional security measures to take for production.


# Quick Start:

All steps are to be carried out from Git bash on Windows or terminal in Mac or Linux. Platform specific instructions below. Note that while Windows and Mac come with Compose you need to manually install it on Linux.


### Step 1: Build the customized PHP 7 image from included Dockerfile

Inside the php7-custom-conf directory is a Dockerfile that pulls the offical PHP 7 image and modifies the configuration. Use this to build your own docker image. This is required for apps like Wordpress which need mysqli. It is not enabled by default in PHP 7.

```
cd php7-custom-conf
docker build -t php7-custom-conf .
```

Now that your image has been created you can use it in docker compose. Confirm that the image was created with the correct name by running:

```
docker images
```

You should see one called php7-custom-conf

### Step 2: Run Docker Compose

Now change back to the root directory of php7-nginx-mysql and run docker-compose up.

```
cd php7-nginx-mysql
docker-compose up
```

You should now be able to access your nginx server at your the IP of your host machine. 

```
http://localhost
```

See below for finding your IP on Windows or Mac.

When you're done you can shutdown the environment by pressing CTL-C.

# Extras

## Finding your IP

If you use Windows or Mac to run docker in a VM you'll access your webserver at the IP of the VM host. You can find it by typing:

```
docker-machine ip
```

Since we exposed port 3306 in our database you can also use this IP to access your db from MySQL Worbench or similar.

## Container Linking and Configuration

Take a look at the mysql config in our php file.

Note how $mysql_host is set to db. This works because we linked the containers in docker-compose.yml. The other MySQL variables are set in the db section of docker-compose.yml.


```
//php7-nginx-mysql/code/public_html/index.php
$mysql_host = db; //this is automatically set to the hostname of the database because we linked them in docker-compose.yml
$mysql_db = 'dbname'; //set in docker-compose.yml
$mysql_user = 'dbuser';  //set in docker-compose.yml
$mysql_pass = 'dbpass';  //set in docker-compose.yml

```

Here is how it's linked in docker-compose.yml

```
#php7-nginx-mysql/docker-compose.yml
php:
	image: php7-custom-conf
	volumes:
	    - ./code/public_html:/code
	links:
	    - db
```

## Volumes with a VM
If you installed Boot2Docker on Windows you should've automatically had VirtualBox installed with your C: drive as a shared directory. If you are getting permissions errors when trying to mount volumes make sure you're working on your C drive. You can open the VirtualBox GUI and confirm settings.

## Persistent Data
After you run this once your database data and code will be persistent in mounted volumes. If you get an error and need to start over you can remove the .data directory with docker creates and run this command to remove any container data.

```
docker-compose rm -vf
```

## Expose environment variables

```
docker-compose run [service] env
docker-compose run db env
```


## Resources

This was put together from these tutorials and resources:
-http://geekyplatypus.com/dockerise-your-php-application-with-nginx-and-php7-fpm/
-http://geekyplatypus.com/making-your-dockerised-php-application-even-better/
-https://docs.docker.com/compose/wordpress/