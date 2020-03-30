import OpenStreetMap from "./components/map";

window.addEventListener("DOMContentLoaded", (event) => {
    const map = new OpenStreetMap("map");

    const xhr = new XMLHttpRequest();
    xhr.onload = function () {
        // Process our return data
        if (xhr.status >= 200 && xhr.status < 300) {
            // What do when the request is successful
            const response = JSON.parse(xhr.response);
            map.addMarkerAndZoom(JSON.parse(response["currentUser"]));
            response["otherUsers"].forEach(user => {
                map.addMarker(user, "#E75A5F", createUserPopupContent(user))
            })
        }
    };
    xhr.open('GET', '/locate/user');
    xhr.send();
});

function createUserPopupContent(user) {
    const title = document.createElement("h4");
    const text = document.createTextNode(user.name);
    title.appendChild(text);

    const button = document.createElement("button");
    button.appendChild(document.createTextNode("Ajouter en ami"));
    button.addEventListener("click",  function() {
        const confirm = window.confirm("Voulez-vous ajouter " + user.name + " en ami ?");
        if (confirm === true) {
            addFriend(user.id);
            button.style.display = "none";
        }
    });
    const div = document.createElement("div");
    div.appendChild(title);
    div.appendChild(button);
    return div
}

function addFriend(id) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/friend/add');
    xhr.send(JSON.stringify({ "user": id }));
}