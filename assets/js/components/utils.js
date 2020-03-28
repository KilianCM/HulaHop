'use strict';

class Utils {
    static getCurrentPosition(success) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => success('js', position.coords),
                () => success('php', Utils.getCurrentPositionWithPhp()),
                { enableHighAccuracy: true }
            );
        } else {
            console.error('navigator.geolocation is not enable to this navigator');
            success('php', Utils.getCurrentPositionWithPhp());
        }
    }

    static getCurrentPositionWithPhp() {
        console.log('Get position by PHP');
    }
}

export default Utils;