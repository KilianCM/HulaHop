// assets/js/components/map.js
'use strict';

import L from 'leaflet';
import 'devbridge-autocomplete';

// Pour une raison obscure, lorsque nous utilisons Webpack, nous devons redéfinir les icons
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});

require('leaflet-easybutton');
require('@ansur/leaflet-pulse-icon');

class OpenStreetMap {

    constructor(mapId, center = [45.5, 2], zoom = 5) {
        this.map = L.map(mapId, { center: center, zoom: zoom });
        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.map);
    }

    addMarkerAndZoom(user, popupContent) {
        this.addMarker(user,'#00adb5', popupContent);
        this.map.setView(new L.LatLng(user.latitude, user.longitude), 12);
    }

    addMarker(user, color, popupContent) {
        const icon = L.icon.pulse({ color: color, fillColor: color, heartbeat: 3 });
        const latlng = [user.latitude, user.longitude];
        const marker = L.marker(latlng, { icon: icon }).addTo(this.map);

        if(popupContent) {
            const popup = L.popup()
                .setLatLng(latlng)
                .setContent(popupContent)
                .openOn(this.map);
            marker.bindPopup(popup);
        }
    }
}

export default OpenStreetMap;