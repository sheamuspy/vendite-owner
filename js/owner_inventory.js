/*global $, jQuery, document, sendRequest, setupTable */


$(document).ready(function () {
    "use strict";
    if (sessionStorage.length == 0) {
        window.location = "index.html";
    }

    $(".button-collapse").sideNav();

    var u = sessionStorage.getItem("name");

    Materialize.toast("Hi " + u, 2000);

    $(".user").html(u);
        //    setupTable();

    setupList();

    $(".collapsible").collapsible({
      accordion : false
    });
});

function setupTable() {
    "use strict";
    var URL, response, i, products;

    URL = "http://cs.ashesi.edu.gh/~csashesi/class2016/sheamus-yebisi/mobile_web/Vendite/php/owner_function.php?cmd=0";
    response = sendRequest(URL);

    products = response.products;

    for (i = 0; i < products.length; i = i + 1) {

        $("#inventory-table tbody").append(
            "<tr>" +
            "<td>" + products[i].PRODUCT_NAME + "</td>" +
            "<td>" + products[i].PRODUCT_BARCODE + "</td>" +
            "<td>" + products[i].PRODUCT_PRICE + "</td>" +
            "</tr>"
        );
    }

}

function setupList() {
    var URL, response, i, products, prodNum, newProd, name, num, index;
    URL = "http://cs.ashesi.edu.gh/~csashesi/class2016/sheamus-yebisi/mobile_web/Vendite/php/owner_function.php?cmd=0";
    response = sendRequest(URL);

    products = response.products;
    prodNum = [];
    newProd = [];
    name = products[0].PRODUCT_NAME;
    num=0;
    for (i = 0; i < products.length; i = i + 1) {
        if (name != products[i].PRODUCT_NAME) {
            prodNum.push(num);
            newProd.push(i);
            name = products[i].PRODUCT_NAME;
            num=1;
        } else {
            num++;
        }
    }
    prodNum.push(num);
    newProd.push(products.length);

    i = 0;
    j = 0;

    while (i < prodNum.length) {

        $("#inventory-list").append(
            "<li>" +
            "<div class='collapsible-header'>" + products[j].PRODUCT_NAME + "<span class='badge'>"+prodNum[i]+"</span></div>" +
            "<div class='collapsible-body'>" +
            "<table id='inventory-table"+i+"'><thead><tr><th>Barcode</th><th>Product</th><th>Price</th></tr></thead><tbody>");
        while(j < newProd[i]) {
            $("#inventory-list #inventory-table"+i+" tbody").append("<tr>" +
                "<td>" + products[j].PRODUCT_NAME + "</td>" +
                "<td>" + products[j].PRODUCT_BARCODE + "</td>" +
                "<td>" + products[j].PRODUCT_PRICE + "</td>" +
                "</tr>" +
                "</div>" +
                "</li>");
            j++;
        }
        i++;

        $("#inventory-list").append("</tbody></table>");

    }

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
