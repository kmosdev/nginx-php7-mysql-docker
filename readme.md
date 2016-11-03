# Beginner Windows Docker Dev Envrionment
## with Docker Compose, Nginx, PHP 7, MySQL 5.7

This is a basic set up using docker compose to create an environment running nginx (latest), php 7 and mysql 5.7. I created this on Windows/Boot2Docker some parts may not be optimized for Docker on Linux but I believe the compose file should work on any environment. This is intended as a development envrionment, there are additional security measures to take for production.

You can use environment variables to automate the settings that we manually set here, however I felt that walking through this simple set up would help users get a better understanding of how docker works, and point out common errors or pitfalls especially when using docker with a VM.


##Instructions:

All steps are to be carried out from MINGW on Windows. Boot2Docker should've installed a shortcut called "Docker Quickstart" which you can use to open the CLI with all variables set.

### Step 1: Build the customized PHP 7 image from included Dockerfile

Inside the php7-custom-conf directory is a Dockerfile that pulls the offical PHP 7 image and modifies the configuration. Use this to build your own docker image.

```
cd php7-custom-conf
docker build -t php7-custom-conf .
```
Now that your image has been created you can pull from it in docker compose. Confirm that the image was created with the correct name by running:

```
docker images
```

### Step 2: Set your MySQL default values

The docker compose file will create three containers. One each for Nginx, PHP, and MySQL. We need to configure the database username, pass etc and provide those to the PHP script. 

Move to the directory php7-nginx-mysql and look at the docker compose file.

```
cd ../php7-custom-conf
cat docker-compose.yml
```

Open the file in an editor and set the variables for MySQL root password, default table, username and pass.

### Step 3: Set the MySQL variables in your PHP script

If you're using Windows or Mac you need to set the IP of your docker machine as the MySQL host. This works because we forward the port of the docker container to the host port in our compose file. To get the docker machine IP type:

```
docker-machine ip
```

This should return something like: 192.168.99.100

Now open index.php to fill in the values. I included a very basic php script for connecting via mysqli. You could also use these same values in wp-config.php for a wordpress site, or for any other PHP apps.

```
cd code/public_html/index.php
cat code/public_html/index.php
```

Open the index.php file.

```
$mysql_host = '192.168.99.100'; //the IP returned from docker-machine in the line above, I filled in my example IP
$mysql_db = 'dbname'; //match what is set in docker-compose
$mysql_user = 'dbuser';  //match what is set in docker-compose
$mysql_pass = 'dbpass';  //match what is set in docker-compose
```

### Step 4: Run Docker Compose

Now change back to the root directory of php7-nginx-mysql and run docker-machine up

```
cd ../../
docker-machine up
```

You should now be able to access your nginx server at your ip:8080. Using the example IP above it would be:

```
http://192.168.99.100:8080
```

When you're done you can shutdown the environment by pressing CTL-C.

Remove any container data:

```
docker-compose rm -vf
```

## Next Steps and Resources
Once you have this working you will probably want to use docker enviornment variables to automate the link between php and mysql. Doing it this way first give you some insight into how everything works. You can also access your MySQL instance from your host machine using the same IP and details above (using MySQL Workbench for example).

This was put together from these tutorials and resources:
http://geekyplatypus.com/dockerise-your-php-application-with-nginx-and-php7-fpm/
http://geekyplatypus.com/making-your-dockerised-php-application-even-better/
https://docs.docker.com/compose/wordpress/

## Caveats and Troublshooting

### Volumes with a VM
If you installed Boot2Docker on Windows you should've automatically had VirtualBox installed with your C: drive as a shared directory. If you are getting permissions errors when trying to mount volumes make sure you're working on your C drive. You can open the VirtualBox GUI and confirm settings.

The first time you run docker compose it should create a .data directory. If you have trouble getting mysql to start and have to adust settings be sure to delete that directory and run the docker-compose rm command from above before trying again. Once you've successfully launched mysql your data will be persistent as long as you don't delete that data directory.