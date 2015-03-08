
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="es"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="es"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="es"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>	
    <meta charset="utf-8">
  	<meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no">
 	
 	<title>TaxiMap</title>

	<link rel="shortcut icon" href="images/favicon.ico" type="img/ico"> 
 	<link href="styles/main.css" rel="stylesheet" type="text/css" media="screen">
 	<script src="scripts/libs/jquery-2.1.3.min.js"></script>
 	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
	<script src="scripts/main.js"></script>
</head>
<body>
	<?php
		require_once("classes/conf.class.php");
		require_once("classes/db.class.php");
		require_once("classes/utils.class.php");
		require_once("classes/loadjson.class.php");
		require_once("classes/coordinate.class.php");
		require_once("classes/ride.class.php");

		// get user on move
		$user_id = 1;

		$rideDB = new Ride();
		$ride = $rideDB->getLastByUser($user_id);

		$coordinateDB = new Coordinate();
		$coordinates = $coordinateDB->getByUserRide($user_id, $ride->id);
		$consession = LoadJSON::load("movilidad", "taxis", $ride->plate);
		$consession = $consession->Taxi->concesion;
	?>
	<header>
		<nav>
			<ul>
				<li>
					<figure><img src="" alt="Información del taxi"></figure>
				</li>
			</ul>
		</nav>
	</header>

	<section id="taxi_info">
		<div id="plate"><strong><?php echo $consession->placa; ?></strong></div>
		<p id="driver_name"><?php echo $consession->nombre . " " . $consession->apellido_paterno . " " . $consession->apellido_materno; ?></p>
		<p id="auto"><?php echo $consession->marca . " " . $consession->submarca . " " . $consession->anio; ?></p>
	</section>

	<section id="map-canvas"></section>

	<script>
		now = '<?php echo date("Y-m-d H:i:s"); ?>';
		<?php
			foreach ($coordinates as $key => $coordinate) {
		?>
			coordinates[<?php echo $key; ?>] = new google.maps.LatLng(<?php echo $coordinate->latitude; ?>, <?php echo $coordinate->longitude; ?>);
			end_ride[<?php echo $key; ?>] = "<?php echo $coordinate->end_ride; ?>";
		<?php	
			echo (($coordinate->end_ride == 1)?"clearTimeout(ever);":"");
		}
		?>
		google.maps.event.addDomListener(window, 'load', initialize);
		loadEver();
	</script>

</body>