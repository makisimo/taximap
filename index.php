
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
		//INSERT INTO coordinate values ( 0, POINT(19.358794, -99.27772), 1, 1 );
		//INSERT INTO coordinate (coordinate, ride_id, user_id) values ( POINT(19.358794, -99.27772), 1, 1 
		require_once("classes/conf.class.php");
		require_once("classes/db.class.php");
		require_once("classes/utils.class.php");
		require_once("classes/coordinate.class.php");
		//require_once("classes/ride.class.php");

		$coordinateDB = new Coordinate();
		$coordinates = $coordinateDB->getByUserRide(1, 1);
	?>
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

	<div id="map-canvas"></div>
	
</body>