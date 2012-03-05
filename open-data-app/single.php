<?php

require_once 'includes/filter-wrapper.php';
require_once 'includes/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');	
	exit;
}

$sql = $db->prepare('
	SELECT id, name, longitude, latitude, address 
	FROM hills
	Where id = :id
');


$sql->bindValue(':id', $id, PDO::PARAM_INT);


$sql->execute();


$results = $sql->fetch();

if (empty($results)) {
	header('Location: index.php');	
	exit;
}

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $results['name']; ?> &middot; Ottawa Sledding Hills &middot; 2010</title>
</head>
<body>

	<h1><?php echo $results['name']; ?></h1>
    <p>Longitude <?php echo $results['longitude']; ?></p>
		<p>Latitude<?php echo $results['latitude']; ?></p>
		<p>Address<?php echo $results['address']; ?></p>

</body>
</html>