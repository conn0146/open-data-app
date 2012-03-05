<?php
// Gets an environment variable we created in the .htaccess file
// This is the best way to keep usernames and passwords out of the public GitHub repos
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$dsn = getenv('DB_DSN');

// Opens a connection to the database and stores it in a variable
// PDO allows us to connect to different types of databases, not just MySQL
$db = new PDO($dsn, $user, $pass);

// Makes sure we talk to the database in UTF-8, so we can support more than just English
$db->exec('SET NAMES utf8');

?>