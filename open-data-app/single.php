<?php

require_once 'includes/filter-wrapper.php';
require_once 'includes/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');	
	exit;
}

$sql = $db->prepare('
	SELECT id, name, longitude, latitude
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

include 'includes/theme-top.php';
?>

<h1><?php echo $results['name']; ?></h1>
<p>Longitude <?php echo $results['longitude']; ?></p>
<p>Latitude<?php echo $results['latitude']; ?></p>

<?php

include 'includes/theme-bottom.php';

?>