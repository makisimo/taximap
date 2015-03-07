<?php
	require_once("classes/conf.class.php");
	require_once("classes/db.class.php");
	require_once("classes/utils.class.php");
	require_once("classes/coordinate.class.php");

	$userId = 0;
	$rideId = 0;
	$endRide = 0;
	$coordinate = "";
	$comment = "";
	$like = 0;
	$end = 0;

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
	if(isset($_REQUEST["end"]))
		$end = Utils::cleanInt($_REQUEST["end"]);



	if($userId > 0 && !empty($coordinate)){
		
		$coordinateDB = new Coordinate();

		$coordinateDB->coordinate = $coordinate;
		$coordinateDB->ride_id = $rideId;
		$coordinateDB->user_id = $userId;
		$coordinateDB->end_ride = $endRide;

		$json_return["status"]["status"] = "ok";
		$json_return["status"]["message"] = "¡Buen viaje!";

		if($coordinateDB->ride_id == 0){
			require_once("classes/coordinate.class.php");

			$rideDB = new Ride();
			$rideDB->user_id = $userId;

			if(!empty($comment))
				$rideDB->comment = "'" . $comment . "'";
			else
				$rideDB->comment = "NULL";

			if($like == 1)
				$rideDB->like = 1;
			else
				$rideDB->like = "NULL";
			
			if($end == 1)
				$rideDB->end_time = "NOW()";
			else
				$rideDB->end_time = "NULL";

			$newRideId = $rideDB->setRide($rideDB);

			$json_return["result"]["ride_id"] = $newRideId;
		}
		$coordinateDB->setCoordinate($coordinateDB);



	}else{
		$json_return["status"]["status"] = "error";
		$json_return["status"]["message"] = "Debes ingresar una coordenada y un identificador de usuario";
	}

	header('Content-Type: application/json');
	echo json_encode($json_return);
?>