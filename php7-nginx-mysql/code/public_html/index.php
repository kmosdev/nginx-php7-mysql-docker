<?php

$mysql_host = db; //this is automatically set to the hostname of the database because we linked them in docker-compose.yml
$mysql_db = 'dbname'; //set in docker-compose.yml
$mysql_user = 'dbuser';  //set in docker-compose.yml
$mysql_pass = 'dbpass';  //set in docker-compose.yml

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
