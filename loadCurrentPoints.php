<?php
	require_once("classes/conf.class.php");
	require_once("classes/db.class.php");
	require_once("classes/utils.class.php");
	require_once("classes/coordinate.class.php");

	$now = "";
	if(Utils::verifyDate($_REQUEST["now"], true))
		$now = $_REQUEST["now"];

	$coordinateDB = new Coordinate();
	$coordinates = $coordinateDB->getCurrentPoints(1, 1, $now);
	header('Content-Type: application/json');
	echo json_encode($coordinates);
?>