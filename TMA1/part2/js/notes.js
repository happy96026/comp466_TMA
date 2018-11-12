function createHTMLObjects(asyncRequest) {
    if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
        var data = JSON.parse(asyncRequest.responseText);
    }
}

var currentScript = document.currentScript;

$(document).ready(function() {
    var asyncRequest = new XMLHttpRequest();
    asyncRequest.open("Get", currentScript.path, true);
    asyncRequest.send();
    createHTMLObjects(asyncRequest);
});
