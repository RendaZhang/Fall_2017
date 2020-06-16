var iconImg, x, n, s, i, j;
var MaxRows = 7;
var MaxCols = 4;
var pictures = ["image1", "image2", "image3", "image4", "image5", 
				"image6", "image7", "image8", "image9", "image10", 
				"image11", "image12", "image13", "image14", "image15",
				"image16", "image16", "image16", "image16", "image16",
				"image16"];

//load the function start as the page loaded
window.addEventListener( "load", start, false );

//Start the event triggers.
function start()
{
	var t = document.getElementById("tableID");

	//load the scrolling event
	myEvent();

	//add event handler to every click on event
	var k = 1;
	for(i=0; i < MaxRows; i++) {
		for(j=1; j < MaxCols; j++) {
			t.rows[i].cells[j].addEventListener( 
				"click", pickImage.bind(this, k-1), false);
			k++;
		}
	}
	
	//Display event as user click on the Day (Mon - Sun)
	for(i=0; i<MaxRows; i++) {
		t.rows[i].cells[0].addEventListener( "click",
			displayEvent.bind(this, i), false );
	}
}

//pick image for the trigger event
function pickImage(index)
{
	document.getElementById("image").setAttribute( "src", 
		"img/" + pictures[ index ] + ".jpg" );
}

//trigger my event at the page load
function myEvent() {
	var x;
	var t = document.getElementById("tableID");
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

//Display event as user click on the Day
function displayEvent(id) {
	var x;
	var c;
	var t = document.getElementById("tableID");
	var k = " --- "
	//get the rows that match
	t = t.rows[id].cells;
	//Concatenate the string for displaying
	x = t[0].innerText + k + t[1].innerText 
		+ k + t[2].innerText + k + t[3].innerText;
	document.getElementById("event").innerHTML = x;
	document.getElementById("event").style.color = "#ff9999";
}

//Form validation
function validateForm() {
	var letters = /^[0-9a-zA-Z]+$/;
	var x = document.getElementById("check1").value;
	var y = document.getElementById("check2").value;
	if(x.match(letters) && y.match(letters)) {
		return true;
	}
	else {
		alert('Error:\n\nEvent Name and Location must be alphanumeric');
		return false;
	}
}





