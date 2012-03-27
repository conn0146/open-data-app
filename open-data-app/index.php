<?php

require_once 'includes/filter-wrapper.php';
require_once 'includes/db.php';

$results = $db->query('
SELECT id, name, longitude, latitude, rate_count, rate_total
FROM hills
ORDER BY name ASC
');

include 'includes/theme-top.php';

?>

<h1>Ottawa Sledding Hills (2010)</h1>

<a href="admin/index.php">Admin Login</a>

<button id="geo">Find Me</button>
<form id="geo-form">
	<label for="adr">Address</label>
	<input id="adr">
</form>
	
<ol class="hills">
<?php foreach ($results as $hills) : ?>
	<?php
		if ($hills['rate_count'] > 0) {
			$rating = round($hills['rate_total'] / $hills['rate_count']);
		} else {
			$rating = 0;
		}
	?>
	<li itemscope itemtype="http://schema.org/TouristAttraction">
		<a href="single.php?id=<?php echo $hills['id']; ?>" itemprop="name"><?php echo $hills['name']; ?></a>
		<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
			<meta itemprop="latitude" content="<?php echo $hills['latitude']; ?>">
			<meta itemprop="longitude" content="<?php echo $hills['longitude']; ?>">
		</span>
		<meter value="<?php echo $rating; ?>" min="0" max="5"><?php echo $rating; ?> out of 5</meter>
		<ol class="rater">
		<?php for ($i = 1; $i <= 5; $i++) : ?>
			<?php $class = ($i <= $rating) ? 'is-rated' : ''; ?>
			<li class="rater-level <?php echo $class; ?>">★</li>
		<?php endfor; ?>
		</ol>
	</li>
<?php endforeach; ?>
</ol>

<div id="map"></div>

<?php

include 'includes/theme-bottom.php';

?>