<?php

require_once '../includes/filter-wrapper.php';
require_once '../includes/db.php';
require_once '../includes/users.php';

if (! user_is_signed_in()) {
	header('Location: sign-in.php');
}

$id= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');
	exit;
}

$sql = $db->prepare('
	DELETE FROM hills
	WHERE id= :id
	LIMIT 1
');

$sql->bindValue(':id', $id, PDO::PARAM_INT);

$sql->execute();

header('Location: index.php');
exit;