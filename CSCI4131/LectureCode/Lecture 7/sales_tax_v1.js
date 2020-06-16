var $ = function (id) {
    return document.getElementById(id); 
}

var calculate_click = function () {
    var itemcost = parseFloat( $("itemcost").value );
    var taxRate  = parseFloat( $("taxRate").value );

    //$("salesTax").value = "";
    //$("total").value = "";

    if ( isNaN(itemcost) || itemcost < 0 ) {
        alert("Item Cost must be a number that is zero or more!");
    } else if ( isNaN(taxRate) || taxRate < 0 ) {
        alert("Tax Rate must be a number that is zero or more!");
    } else {
        var salesTax = itemcost * (taxRate / 100);
        salesTax = parseFloat( salesTax.toFixed(2) );
        var total = itemcost + salesTax;
        $("salesTax").value = salesTax;
        $("total").value = total.toFixed(2);
    }
}

window.onload = function () {
    $("calculate").onclick = calculate_click;
    $("itemcost").focus;
}
