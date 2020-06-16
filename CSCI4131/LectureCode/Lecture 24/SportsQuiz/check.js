function check(n){
	var x = document.getElementsByName(n)
	for( var i=0; i< x.length; i++)
		if (x[i].type=='radio' && x[i].checked)
			return true;
	alert("No choice has been made");
	return false;
}
