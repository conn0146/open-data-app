<?php
//-this does not go on php fog   using bcrypt and blowfish
//a small file for us to create an admin user
//this file should never be publicly accessible

require_once 'includes/db.php';
require_once 'includes/users.php';

$email = 'bradlet@algonquincollege.com';
$password = 'password';

user_create($db, $email, $password);

?>