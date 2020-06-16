/**  Author: Renda Zhang
	 Class: CSCI4131
	 Assignment 3        **/

var infowindow, iconImg, x, n, s, i, j, k, t;
var map;
var MaxRows = 7;
var MaxCols = 4;
var ImgNum = 21;
var pictures = ["image1", "image2", "image3", "image1", "image1", 
				"image5", "image1", "image4", "image1", "image1", 
				"image1", "image5", "image1", "image5", "image1",
				"image5", "image5", "image5", "image5", "image5",
				"image5"];
var img = document.getElementsByTagName("IMG");
//Hardcode for locations in GoogleMap and Buildings Number
var BuildingNum = 4;
var InfoMark = [//content for InfoWindow
				['<div id="content">'+'<div id="bodyContent">'+
				"Keller Hall 11"+'<p>'+"CSCI1111, Office hours"
				+'</p>'+'</div>'+'</div>',
				'<div id="content">'+'<div id="bodyContent">'+
				"Shepherd Labs 222"+'<p>'+"Meeting"+'</p>'+
				'</div>'+'</div>',
				'<div id="content">'+'<div id="bodyContent">'+
				"Coffman 333"+'<p>'+"Bowling"+'</p>'+'</div>'+'</div>',
				'<div id="content">'+'<div id="bodyContent">'+
				"Walter"+'<p>'+"Group Meeting"+'</p>'+'</div>'+'</div>'],
			    //positions for marker
			    [{lat: 44.974686, lng:-93.232074},
				 {lat: 44.975908, lng:-93.232368},
				 {lat: 44.972871, lng:-93.235329},
				 {lat: 44.97528, lng:-93.236225}],
				 //titles for Marker
				 ['Keller Hall','Shepherd Labs',
                 'Coffman Memorial Union','Walter Library']
];

//load the function start as the page loaded
window.addEventListener( "load", start, false );

//Start the event triggers.
function start()
{
	var t = document.getElementById("tableID");
	
	//Appending image element to the table cell
	k = 0;
	for(i=0; i < MaxRows; i++) {
		for(j=1; j < MaxCols; j++) {
			var cell = t.rows[i].cells[j];
			var node0 = document.createElement("BR");
			cell.appendChild(node0);
			var node1 = document.createElement("IMG");
			node1.setAttribute( "src", 
				"img/" + pictures[k] + ".jpg" );
			//make the image hidden
			node1.style.visibility = "hidden";
			cell.appendChild(node1);
			//Make image hidden and appears only as mouse hover over.
			cell.onmouseover = makeOverCallback(node1);
			cell.onmouseout = makeOutCallback(node1);
			k++;
		}
	}
	
	//load the scrolling event
	myEvent();
}
		
//function and function closure for images 
//to display as mouse hovers over the cells
function makeOverCallback(node) {
	return function() {
		myMouseover(node);
	};
}
function myMouseover(node)
{	
	node.style.visibility = "visible";
}
function makeOutCallback(node) {
	return function() {
		myMouseout(node);
	};
}
function myMouseout(node)
{
	node.style.visibility = "hidden";	
}

//function for loading google map
function myMap() {  
	var myLatLng = {lat: 44.974, lng: -93.234};
	map = new google.maps.Map(document.getElementById('GoogleMap'), {
	  center: myLatLng,
	  zoom: 14
	});

	//Loop for the locations of buildings in my calendar
	var marker;
	for(i=0;i<BuildingNum;i++) {
		infowindow = new google.maps.InfoWindow();
		infowindow.setContent(InfoMark[0][i]);
		marker = new google.maps.Marker({
			position: InfoMark[1][i],
			map: map,
			title: InfoMark[2][i]
		});
		marker.addListener('click',
			ClickInfoWEvent.bind(this,infowindow,map,marker));
	}
}

//Function for click marker shown InfoWindow Event in myMap()
function ClickInfoWEvent(infowindow1, map1, marker1) {
	infowindow1.open(map1,marker1);
}

//Function for showing restaurant within radius
function RformEvent() {
	var GetRadius = document.getElementById("Radius").value;	
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

//Function for getting direction with a travel mode
function DformEvent() {
	//Adding Direction
	var directionsDisplay = new google.maps.DirectionsRenderer;
	var directionsService = new google.maps.DirectionsService;	
	directionsDisplay.setPanel(document.getElementById('right-panel'));
	directionsDisplay.setMap(map);
	calculateAndDisplayRoute(directionsService, directionsDisplay);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
	//reset the panel first	
	var panel = document.getElementById('right-panel');
	panel.innerHTML = "";
	panel.style.display = "block";
	var GetDestination = document.getElementById("Destination").value;
	//Get the checked travel mode	
	var GetMode = document.querySelector('input[name="modes"]:checked').value;

  if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
		//Get the user's Current location		
		var pos = {
		  lat: position.coords.latitude,
		  lng: position.coords.longitude
		};
		
		//Display the route
		directionsService.route({
		 origin: pos,
		 destination: GetDestination,
		 travelMode: GetMode
		  }, function(response, status) {
			 if (status === 'OK') {
			   directionsDisplay.setDirections(response);
			 } else {
			   window.alert('Directions request failed due to ' + status);
			 }
		  });

	    }, function() {
	    	//Error handling 
	      handleLocationError(true);
	    });
	  } else {
	    // Browser doesn't support Geolocation
	    handleLocationError(false);
	  }
}

function handleLocationError(browserHasGeolocation) {
	if (handleLocationError) {
		alert("Failed to display user's location");
	} else { alert("Browser doesn't support Geolocation"); }
}

//Loading twitter feed
!function(d,s,id){
	var js,
		fjs=d.getElementsByTagName(s)[0],
		p=/^http:/.test(d.location)?'http':'https';
	if(!d.getElementById(id)){
		js=d.createElement(s);
		js.id=id;
		js.src=p+"://platform.twitter.com/widgets.js";
		fjs.parentNode.insertBefore(js,fjs);
	}
}(document,"script","twitter-wjs");

//trigger my event at the page load
function myEvent() {
	t = document.getElementById("tableID");
	var k = " --- ";
	//modular the day to match Mon-Sun AS 0-6
	var d = (new Date().getDay() + 6) % 7;
	//get the rows that match
	t = t.rows[d].cells;
	//Concatenate the string for displaying
	x = t[0].innerText + k + t[1].innerText 
		+ k + t[2].innerText + k + t[3].innerText;
	document.getElementById("event").innerHTML = x;
}