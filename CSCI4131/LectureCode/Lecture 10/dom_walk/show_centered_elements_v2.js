var showCenteredElementsCount = function () {
    	var centeredElements = jsLib.dom.getElementsByClassName("center");
    	alert("Centered elements: " + centeredElements.length);
    }

window.addEventListener("load",showCenteredElementsCount, false);


