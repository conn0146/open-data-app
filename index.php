
<?php
/**
 * Displays the list and map for the Open Data Set
 *
 * @package Ottawa Sledding Hills (2010)
 * @copyright 2012 Jason Connell
 * @author Jason Connell <connell.connect@gmail.com>
 * @link https://github.com/conn0146/open-data-app
 * @license New BSD License
 *@version 1.0.0
 */
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

<a class="sin1" href = "/admin/sign-in.php">Admin</a>

<button id="geo">Find Me</button>
<form id="geo-form">
	<label for="adr">Address</label>
	<input id="adr">
</form>
	
<ul class="hills">
<?php foreach ($results as $hills) : ?>
	<?php
		if ($hills['rate_count'] > 0) {
			$rating = round($hills['rate_total'] / $hills['rate_count']);
		} else {
			$rating = 0;
		}
	?>
	<li itemscope itemtype="http://schema.org/TouristAttraction" data-id="<?php echo $hills["id"]; ?>" class="box">
		<a href="single.php?id=<?php echo $hills['id']; ?>" itemprop="name"><?php echo $hills['name']; ?></a>
		<strong class="distance"
		<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
			<meta itemprop="latitude" content="<?php echo $hills['latitude']; ?>">
			<meta itemprop="longitude" content="<?php echo $hills['longitude']; ?>">
		</span>
	<?php /*?><meter value="<?php echo $rating; ?>" min="0" max="5"><?php echo $rating; ?> out of 5</meter><?php */?>
		<ol class="rater">
		<?php for ($i = 1; $i <= 5; $i++) : ?>
			<?php $class = ($i <= $rating) ? 'is-rated' : ''; ?>
			<li class="rater-level <?php echo $class; ?>">★</li>
		<?php endfor; ?>
		</ol></strong>
	</li>
<?php endforeach; ?>
</ul>

<div id="map"></div>

<?php

include 'includes/theme-bottom.php';

?>