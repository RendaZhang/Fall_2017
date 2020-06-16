function init() {

	var showCenteredElementsCount = function () {
			var centeredElements = jsLib.dom.getElementsByClassName("center");
			alert("Centered elements: " + centeredElements.length);
		}
		
	document.addEventListener("click", showCenteredElementsCount, false)
}

window.addEventListener("load",init(), false);


