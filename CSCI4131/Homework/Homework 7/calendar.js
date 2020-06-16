/**  Author: Renda Zhang
	 Class: CSCI4131
	 Assignment 3        **/
var map;
var service;
var infowindow;
var keller = new google.maps.LatLng(44.9745476,-93.23223189999999);

function initMap() {
  map = new google.maps.Map(document.getElementById('map-canvas'), {
     center : keller,
     zoom: 14
   });

   infowindow = new google.maps.InfoWindow();

  service = new google.maps.places.PlacesService(map);

  var locations = document.getElementsByClassName('loc');
   for(var i = 0; i < locations.length; i++) {
     mark(locations[i].innerHTML);
   }
}

google.maps.event.addDomListener(window, 'load', initMap);
// Function to creat markers for events
function mark(loc){
var request = {
       location: keller,
       radius: '1000',
       query:loc
   };
service.textSearch(request, callback);
}
function callback(results, status) {
  if(status == google.maps.places.PlacesServiceStatus.OK) {
    /* just take top result */
    var place = results[0];
    createMarker(results[0]);
  }
}

//Function for showing restaurant within radius
function RformEvent() {
	var GetRadius = document.getElementById("location_box").value;
	infowindow = new google.maps.InfoWindow();
	var RService = new google.maps.places.PlacesService(map);
	RService.nearbySearch({
		location: {lat: 44.974, lng: -93.234},
		radius: GetRadius,
		type: ['restaurant']
	}, Rcallback);
}
function Rcallback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      createMarker(results[i]);
    }
  }
}
function createMarker(place) {
  var placeLoc = place.geometry.location;
  var marker = new google.maps.Marker({
    map: map,
    position: place.geometry.location
  });

  google.maps.event.addListener(marker, 'click', function() {
    infowindow.setContent(place.name+"<br>"+place.vicinity);
    infowindow.open(map, this);
  });
}
