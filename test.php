<?php
	require_once("classes/conf.class.php");
	require_once("classes/db.class.php");
	require_once("classes/coordinate.class.php");

	$coordinateDB = new Coordinate();

	$coordinates = array("19.363919, -99.264264", "19.365802, -99.262387", "19.367492, -99.260778", "19.369264, -99.261089", "19.370650, -99.260992", "19.371996, -99.259909", "19.373181, -99.258761");
	$count_coordinates = count($coordinates);

	foreach ($coordinates as $key => $coordinate) {

		$coordinateDB->coordinate = $coordinate;
		$coordinateDB->ride_id = 1;
		$coordinateDB->user_id = 1;

		if($count_coordinates == $key){
			$coordinateDB->end_ride = 1;
		}else{
			$coordinateDB->end_ride = 0;
		}

		$coordinates = $coordinateDB->setCoordinate($coordinateDB);
		
		sleep(10);

	}
?>