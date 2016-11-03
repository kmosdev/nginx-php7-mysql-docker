<?php

$mysql_host = '192.168.99.100'; //if you run docker on Windows or Mac you need to use the IP of your host machine, output by running docker-machine ip
$mysql_db = 'dbname'; //set in docker-compose
$mysql_user = 'dbuser';  //set in docker-compose
$mysql_pass = 'dbpass';  //set in docker-compose

$link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

mysqli_close($link);
?>
