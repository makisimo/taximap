<?php
	require_once("classes/conf.class.php");
	require_once("classes/db.class.php");
	require_once("classes/utils.class.php");
	require_once("classes/coordinate.class.php");
	require_once("classes/ride.class.php");

	$userId = 0;
	$rideId = 0;
	$endRide = 0;
	$coordinate = "";
	$comment = "";
	$like = 0;
	$end = 0;
	$plate = "";

	$json_return = array('status' => array('status' => 'error', 'message' => 'Hubo un problema al cargar la coordenada'));

	if(isset($_REQUEST["user_id"]))
		$userId = Utils::cleanInt($_REQUEST["user_id"]);
	if(isset($_REQUEST["ride_id"]))
		$rideId = Utils::cleanInt($_REQUEST["ride_id"]);
	if(isset($_REQUEST["end_ride"]))
		$endRide = Utils::cleanInt($_REQUEST["end_ride"]);
	if(isset($_REQUEST["coordinate"]))
		$coordinate = Utils::cleanCoordinate($_REQUEST["coordinate"]);

	if(isset($_REQUEST["comment"]))
		$comment = $_REQUEST["comment"];
	if(isset($_REQUEST["like"]))
		$like = Utils::cleanInt($_REQUEST["like"]);
	if(isset($_REQUEST["plate"]))
		$plate = $_REQUEST["plate"];


	if($userId > 0 && !empty($coordinate)){
		
		$coordinateDB = new Coordinate();

		$coordinateDB->coordinate = $coordinate;
		$coordinateDB->ride_id = $rideId;
		$coordinateDB->user_id = $userId;
		$coordinateDB->end_ride = $endRide;

		$rideDB = new Ride();

		if($endRide == 1)
			$rideDB->setEndTime($userId);

		if($coordinateDB->ride_id == 0){
			$rideDB->user_id = $userId;
			$rideDB->end_time = "NULL";

			if(!empty($comment))
				$rideDB->comment = "'" . $comment . "'";
			else
				$rideDB->comment = "NULL";

			if($like == 1)
				$rideDB->like = 1;
			else
				$rideDB->like = 0;

			if(!empty($plate))
				$rideDB->plate = "'" . $plate . "'";
			else
				$rideDB->plate = "NULL";

			$newRideId = $rideDB->setRide($rideDB);			
			$coordinateDB->ride_id = $newRideId;
			$json_return["result"]["ride_id"] = $newRideId;
		}

		$coordinateDB->setCoordinate($coordinateDB);

		$json_return["status"]["status"] = "ok";
		$json_return["status"]["message"] = "¡Buen viaje!";

	}else{
		$json_return["status"]["status"] = "error";
		$json_return["status"]["message"] = "Debes ingresar una coordenada y un identificador de usuario";
	}

	header('Content-Type: application/json');
	echo json_encode($json_return);
?>