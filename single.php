<?php

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');	
	exit;
}

require_once 'includes/filter-wrapper.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';


$sql = $db->prepare('
	SELECT id, name, longitude, latitude,rate_count, rate_total
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

$cookie = get_rate_cookie();

include 'includes/theme-top.php';
?>

<h2><?php echo $results['name']; ?></h2>
<div class="ratedeco">
	<dl>
		<dt>Average Rating</dt><dd><meter value="<?php echo $rating; ?>" min="0" max="5"><?php echo $rating; ?> out of 5</meter></dd>
		<dt>Longitude</dt><dd><?php echo $results['longitude']; ?></dd>
		<dt>Latitude</dt><dd><?php echo $results['latitude']; ?></dd>
	</dl>
<div>


<div class="ra">
	<?php if (isset($cookie[$id])) : ?>
	
	<h2>Your rating</h2>
	<ol class="rater rater-usable">
		<?php for ($i = 1; $i <= 5; $i++) : ?>
			<?php $class = ($i <= $cookie[$id]) ? 'is-rated' : ''; ?>
			<li class="rater-level <?php echo $class; ?>">★</li>
		<?php endfor; ?>
	</ol>

	<?php else : ?>

	<h2>Rate</h2>
	<ol class="rater rater-usable">
		<?php for ($i = 1; $i <= 5; $i++) : ?>
		<li class="rater-level"><a href="rate.php?id=<?php echo $results['id']; ?>&rate=<?php echo $i; ?>">★</a></li>
		<?php endfor; ?>
	</ol>
    

	<?php endif; ?>
</div>

<a href="index.php" alt="Home">Home</a>

<?php

include 'includes/theme-bottom.php';

?>