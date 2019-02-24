$(document).ready(function() {
    var editButtons = document.getElementsByClassName("edit");
    var deleteButtons = document.getElementsByClassName("delete");
    var form = document.getElementById("form");
    var idElement = document.getElementById("id");

    for (let editButton of editButtons) {
        editButton.addEventListener("click", function() {
            form.action = "edit.php";
            form.method = "get";
            idElement.value = this.parentNode.getAttribute("id");
        });
    }
    for (let deleteButton of deleteButtons) {
        deleteButton.addEventListener("click", function() {
            form.action = "server/delete_server.php";
            form.method = "post";
            idElement.value = this.parentNode.getAttribute("id");
        });
    }
});
