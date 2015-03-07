var map;
var messages = [];
var coordinates = [];
var markers = [];
var coordInfoWindow = [];
var icon_image_start = "images/dot-start.png";
var icon_image_end = "images/dot.png";
var icon_image = "images/taxi-mini.png";
var count_last_i = 0;
var now;
var end_ride = [];
var end = false;
var ever;
//var addresses = []

function initialize() {
	var mapOptions = {
		zoom: 15,
    	center: coordinates[0]
	};

	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	for(var i=0; i<coordinates.length; i++){
		addPoint(icon_image, i, google.maps.Animation.DROP);
	}
	count_last_i = i - 1;
}

function addPoint(icon_image, i, animate){
	if(i == 0)
		icon_image = "images/dot-start.png";
	else if(end_ride[i] == 1)
		icon_image = "images/taxi-mini.png";
	else
		icon_image = "images/dot.png";

	//addresses[i] = getAddress(coordinates[i].lat(), coordinates[i].lng(), i);
	var address = getAddress(coordinates[i].lat(), coordinates[i].lng());

	messages[i] = '<div style="width: 200px; text-align: center;"><img src="images/taxi.png"><p>' + address + '<br><!--<a href="http://maps.google.com/maps?f=d&geocode=&daddr=19.358794,-99.27772&z=15" target="_blank">Get directions</a>--></p></div>';
	markers[i] = new google.maps.Marker({
		position: coordinates[i],
		map: map,
		icon: icon_image,
		animation: animate
	});

	map.setCenter(coordinates[i]);
	setTimeout(function(){ markers[i].setAnimation(null); }, 5000);

	coordInfoWindow = new google.maps.InfoWindow({
		content: messages[markers[i]],
		position: coordinates[i]
	});

	attachSecretMessage(markers[i], i);
}

function attachSecretMessage(marker, number) {
	var infowindow = new google.maps.InfoWindow(
		{ content: messages[number],
		size: new google.maps.Size(50, 50)
	});
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map, marker);
	});
}

function loadEver(){

    $.ajax({
        type: "POST",
        url: "loadCurrentPoints.php",
        data: { "now": now }
        //data: { "now": "2015-03-07 01:50:00" }
    }).success(function(points){
    	if(points){
    		$.each( points, function( key, point ) {
				count_last_i += key + 1;
		    	coordinates[count_last_i] = new google.maps.LatLng(point.latitude, point.longitude);
		    	end_ride[count_last_i] = point.end_ride;
		    	addPoint(icon_image, count_last_i, google.maps.Animation.BOUNCE);
		    	if(point.end_ride == 1){
		    		end = true;
		    		clearTimeout(ever);
		    	}
		    });
	    }
	    if(!end)
        	ever = setTimeout(function(){ loadEver(); }, 10000);
    }).fail(function() {
		console.log( "error" );
	});

}

function getAddress(lat, lng){

	var jqXHR  = $.ajax({
        type: "GET",
        dataType: 'json',
        cache : false,
    	async : false,
        url: "http://maps.googleapis.com/maps/api/geocode/json?latlng=" + lat + "," + lng
    });

    if(jqXHR.responseJSON){
    	return jqXHR.responseJSON.results[0].formatted_address;
    }else{
    	getAddress(lat, lng);
    }

}