<?php

require_once '../includes/users.php';

if (! user_is_signed_in()) {
	header('Location: sign-in.php');
}

require_once 'includes/filter-wrapper.php';
require_once 'includes/db.php';

$results = $db->query('
SELECT id, name, longitude, latitude, rating
FROM hills
ORDER BY name ASC
')

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Admin &middot; Ottawa Sledding Hills &middot; 2010</title>

</head>
<body>
	<h1>Admin Page</h1>
	
	<a href="sign-out.php">Sign Out</a>
	<a href="../index.php">Back to Main Page</a>
	<a href="add.php">Add a Hill</a>
	
	<ul>
		<?php foreach ($results as $hills) : ?>
				<li>
                	<a href="../single.php?id=<?php echo $hills['id']; ?>"><?php echo $hills['name']; ?></a>
                	&bull;
                	<a href="edit.php?id=<?php echo $hills['id']; ?>">Edit</a>
									<a href="delete.php?id=<?php echo $hills['id']; ?>">Delete</a>
                </li>
		<?php endforeach; ?>
	</ul>
    
</body>
</html>