<?php

require_once 'includes/filter-wrapper.php';
require_once 'includes/db.php';

$results = $db->query('
SELECT id, name, longitude, latitude
FROM hills
ORDER BY name ASC
');

include 'includes/theme-top.php';

?>

<h1>Ottawa Sledding Hills (2010)</h1>
	
<a href="admin/index.php">Admin Login</a>
	
<ol class="hills">
<?php foreach ($results as $hills) : ?>
	<li itemscope itemtype="http://schema.org/TouristAttraction">
		<a href="single.php?id=<?php echo $hills['id']; ?>" itemprop="name"><?php echo $hills['name']; ?></a>
		<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
			<meta itemprop="latitude" content="<?php echo $hills['latitude']; ?>">
			<meta itemprop="longitude" content="<?php echo $dino['longitude']; ?>">
		</span>
	</li>
<?php endforeach; ?>
</ol>

<div id="map"></div>

<?php

include 'includes/theme-bottom.php';

?>