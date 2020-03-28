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

    addMarkerAndZoom(latitude, longitude) {
        const icon = L.icon.pulse({ color: '#00adb5', fillColor: '#00adb5', heartbeat: 3 });
        //add marker
        L.marker([latitude, longitude], { icon: icon }).addTo(this.map);
        this.map.setView(new L.LatLng(latitude, longitude), 12);
    }
}

export default OpenStreetMap;