import OpenStreetMap from "./components/map";

window.addEventListener("DOMContentLoaded", (event) => {
    const map = new OpenStreetMap("map");

    const xhr = new XMLHttpRequest();
    xhr.onload = function () {
        // Process our return data
        if (xhr.status >= 200 && xhr.status < 300) {
            // What do when the request is successful
            const response = JSON.parse(xhr.response);
            map.addMarkerAndZoom(response[0],response[1])
        }
    };
    xhr.open('GET', '/locate/user');
    xhr.send();
});