<?php

require_once 'includes/filter-wrapper.php';
require_once 'includes/db.php';

$results = $db->query('
SELECT id, name, longitude, latitude, address 
FROM hills
ORDER BY name ASC
')

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Ottawa Sledding Hills &middot; 2010</title>
	
</head>
<body>
	<h1>Ottawa Sledding Hills (2010)</h1>
	
	<a href="admin/index.php">Admin Login</a>
	
	<ul>
		<?php foreach ($results as $hills) : ?>
				<li>
        	<a href="single.php?id=<?php echo $hills['id']; ?>"><?php echo $hills['name']; ?></a>
        </li>
		<?php endforeach; ?>
	</ul>
    
</body>
</html>