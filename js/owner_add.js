/*global $, jQuery, document, sendRequest, alert */


$(document).ready(function () {
    "use strict";
    $(".button-collapse").sideNav();

//    if (sessionStorage.length == 0) {
//        window.location = "index.html";
//    }

    var u = sessionStorage.getItem("name");

    $(".user").html(u);

});

$(function () {
    "use strict";
    $("#addBtn").click(function () {
        var productName, productBarcode, productPrice, URL, response;
        productBarcode = $("#product_barcode").val();
        productName = $("#product_name").val();
        productPrice = $("#product_price").val();

        URL = "http://localhost/mobile_web/Vendite/php/owner_function.php?cmd=1&name='" + productName + "'&barcode='" + productBarcode + "'&price=" + productPrice;
        response = sendRequest(URL);

        if (response.status === 0) {
            $("#product_barcode").val("");
            $("#product_name").val("");
            $("#product_price").val("");
            alert("Added");
        } else if (response.status === 2) {
            alert("Please again try later");
        } else {
            alert("Please check your feilds.");
        }
    });
});


function logout(){
    sessionStorage.clear();
    window.location = "index.html";
}

function sendRequest(u) {
    "use strict";
    var obj, result;
    obj = $.ajax({
        url: u,
        async: false
    });
    result = $.parseJSON(obj.responseText);
    return result;
}
