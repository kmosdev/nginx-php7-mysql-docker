This is a basic set up using docker compose to create an environment running nginx (latest), php 7 and mysql 5.7. I created this on Windows/Boot2Docker some parts may not be optimized for Docker on Linux. This is intended as a development envrionment, there are additional security measures to take for production.

Instructions:

First build a docker image from php7-custom-conf. I created this to add mysqli, mycrypt and other useful extenstions. 

From MINGW:

cd php7-custom-conf
docker build -t php7-custom-conf .

Now that your image has been created you can pull from it in docker compose. Confirm that the image was created with the correct name by running:

docker images

Now let's move to the directory php7-nginx-mysql. This holds the docker compose file.

cd ../php7-custom-conf
cat docker-compose.yml

Here you can set the MySQL environment variables for root password, and create a default table, username and pass. We'll use these in code/public_html/index.php where we connect to mysql using the mysqli extension.

cd code/public_html/index.php
cat code/public_html/index.php

If you're using Windows or Mac you need to set the IP of your docker machine.

docker-machine ip

This should return something like

192.168.99.100

Use this IP as the value for $mysql_host.

Now change back to the root directory of php7-nginx-mysql and run docker-machine up

cd ../../
docker-machine up

You should now be able to access your nginx server at your ip:8080. Using the example IP above it would be:

http://192.168.99.100:8080

You can use environment variables to automate the settings that we manually set here, however I felt that walking through this simple set up would help users get a better understanding of how docker works, and point out common errors or pitfalls.

When you're done you can shutdown the environment by pressing CTL-C.

docker-compose rm -vf