/*global $, jQuery, document, sendRequest, alert */



$(document).ready(function () {
    "use strict";
    $(".button-collapse").sideNav();

    $('.modal-trigger').leanModal();

    if (sessionStorage.length == 0) {
        window.location = "index.html";
    }

    var u = sessionStorage.getItem("name");

    $(".user").html(u);
});

$(function () {
    "use strict";
    $("#setPriceBtn").click(function () {
        var productBarcode, productPrice, URL, response;
        productBarcode = $("#product_barcode").val();
        productPrice = $("#product_price").val();

        URL = "http://cs.ashesi.edu.gh/~csashesi/class2016/sheamus-yebisi/mobile_web/Vendite/php/owner_function.php?cmd=2&barcode='" + productBarcode + "'&price=" + productPrice;

        response = sendRequest(URL);

        if (response.status === 0) {
            $("#product_id").val("");
            $("#product_barcode").val("");
            $("#product_name").val("");
            $("#product_price").val("");
            alert("Price changed.");
        } else if (response.status === 2) {
            alert("Please again try later");
        } else {
            alert("Please check your feilds.");
        }
    });
});

//$(function () {
//    "use strict";
//    $("#searchBtn").click(function (){
//
//    })
//})

function getProduct() {
    "use strict";
    var barcode, URL, response, product;
    barcode = $("#searchTxt").val();

    URL = "http://cs.ashesi.edu.gh/~csashesi/class2016/sheamus-yebisi/mobile_web/Vendite/php/owner_function.php?cmd=4&barcode='" + barcode + "'";
    response = sendRequest(URL);
    product = response.products;
    $("#product_id").val(product.PRODUCT_ID);
    $("#product_barcode").val(product.PRODUCT_BARCODE);
    $("#product_name").val(product.PRODUCT_NAME);
    $("#product_price").val(product.PRODUCT_PRICE);

}

function getProductS() {
    "use strict";
    var barcode, URL, response, product;
    barcode = $("#searchTxtS").val();

    URL = "http://cs.ashesi.edu.gh/~csashesi/class2016/sheamus-yebisi/mobile_web/Vendite/php/owner_function.php?cmd=4&barcode='" + barcode + "'";
    response = sendRequest(URL);
    product = response.products;
    $("#product_id").val(product.PRODUCT_ID);
    $("#product_barcode").val(product.PRODUCT_BARCODE);
    $("#product_name").val(product.PRODUCT_NAME);
    $("#product_price").val(product.PRODUCT_PRICE);
    $("#searchTxtS").val("");

}

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
