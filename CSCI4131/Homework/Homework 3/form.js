/**  Author: Renda Zhang
	 Class: CSCI4131
	 Assignment 3        **/

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
 
