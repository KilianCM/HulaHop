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
            JSON.parse(response["otherUsers"]).forEach(user => {
                map.addMarker(user, "#00adb5", createUserPopupContent(user))
            });
            JSON.parse(response["friends"]).forEach(friend => {
                map.addMarker(friend, "#009900", createUserPopupContent(friend, false))
            });
        }
    };
    xhr.open('GET', '/locate/user');
    xhr.send();
});

function createUserPopupContent(user, withButton = true) {
    const title = document.createElement("h4");
    const text = document.createTextNode(user.name);
    title.appendChild(text);
    const div = document.createElement("div");
    div.classList.add("map-popup");
    div.appendChild(title);

    if (withButton) {
        const button = document.createElement("button");
        button.appendChild(document.createTextNode("Ajouter en ami"));
        button.addEventListener("click",  function() {
            const confirm = window.confirm("Voulez-vous ajouter " + user.name + " en ami ?");
            if (confirm === true) {
                addFriend(user.id);
                button.style.display = "none";
            }
        });
        div.appendChild(button);
    } else {
        const p = document.createElement("p");
        p.appendChild(document.createTextNode("Déjà ami"));
        div.appendChild(p);
    }

    return div
}

function addFriend(id) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/friend/add');
    xhr.send(JSON.stringify({ "user": id }));
}