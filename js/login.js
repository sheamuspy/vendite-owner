function sendRequest(requestURL) {
    var obj = $.ajax({
        url: requestURL,
        async: false
    });
    var response = $.parseJSON(obj.responseText);
    return response;

}

function login() {
    var username, password, url;

    username = $("#loginUsername").val();
    password = $("#loginPassword").val();

    url = "http://cs.ashesi.edu.gh/~csashesi/class2016/sheamus-yebisi/mobile_web/Vendite/php/owner_function.php?cmd=5&username='" + username + "'&password='" + password + "'";

    var response = sendRequest(url);

    if (response.status === 0) {
        var name = response.user['USERNAME'];
        var role = response.user['ROLE'];
        sessionStorage.setItem("name", name);
        sessionStorage.setItem("role", role);
        window.location = "inventory.html";

    } else {
        Materialize.toast("Password or username is incorrect.", 2000);
    }
}
