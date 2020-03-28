// assets/js/components/map.js
'use strict';

import L from 'leaflet';
import 'devbridge-autocomplete';
import Utils from "./utils";

// Pour une raison obscure, lorsque nous utilisons Webpack, nous devons redéfinir les icons
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});

require('leaflet-easybutton');
require('@ansur/leaflet-pulse-icon');

class Map {
    init(mapId, center = [45.5, 2], zoom = 5) {
        this.map = L.map(mapId, { center: center, zoom: zoom });
        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.map);
        this._getCurrentPosition()
    }
    _getCurrentPosition() {
        Utils.getCurrentPosition((provider, coords) => {
            if (provider === 'js') {
                //On stocke la position de l'utilisateur pour centrer la carte s'il clique sur le bouton de position
                this.latitude = coords.latitude;
                this.longitude = coords.longitude;
                // On ajoute un icon différent de nos lieux
                const icon = L.icon.pulse({ color: 'blue', fillColor: 'blue', heartbeat: 3 });
                // On ajoute le marqueur sur la carte
                L.marker([coords.latitude, coords.longitude], { icon: icon }).addTo(this.map);
                // On crée un nouveau bouton pour localiser l'utilisateur
                L.easyButton({
                    position: 'topright',
                    states: [{
                        onClick: () => this.map.setView([this.latitude, this.longitude], 12),
                        title: 'Me localiser',
                        icon: '<span class="target">&target;</span>'
                    }],
                }).addTo(this.map);
                this.map.setView(new L.LatLng(this.latitude, this.longitude), 12);
            } else {
                // On recentre la carte par rapport aux coordonnées récoltées en PHP
                this.map.setView(new L.LatLng(coords.lat, coords.lon), 11);
            }
        });
    }
}

export default Map;