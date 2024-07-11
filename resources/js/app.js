import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

let map;


async function initMap() {
    await ymaps3.ready;
    const {YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer, YMapListener} = ymaps3;

    map = new YMap(
        document.getElementById('map'),
        {
            location: {
                center: [37.588144, 55.733842],
                zoom: 10
            }
        },
        [
            new YMapDefaultSchemeLayer({}),
            new YMapDefaultFeaturesLayer({})
        ]
    );
    const mapListener = new YMapListener({
        layer: 'any',
        // Adding handlers to the Listener.
        onClick: clickCallback,
    });
    map.addChild(mapListener);
    window.dispatchEvent(new Event('map-loaded'));
}

initMap();

const clickCallback = (layer, coordinates, object) => {
    console.log(coordinates);
    document.getElementById('longitude').value = coordinates['coordinates'][0];
    document.getElementById('latitude').value = coordinates['coordinates'][1];
    window.dispatchEvent(new CustomEvent('map-clicked'));
};

document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
        modalShow: false,
        init() {
        },
        addAllMarkers() {
            const {YMapMarker} = ymaps3;

            fetch('/api/v1/balloons')
                .then(response => response.json())
                .then(data => {
                    data.data.forEach(markerProp => {
                        this.addMarkerToMap(markerProp);
                    })
                })
        },
        addMarker() {
            this.modalShow = true;
        },
        addMarkerToMap(markerProp) {
            const {YMapMarker} = ymaps3;
            const mp = markerProp['attributes'];
            const image = document.createElement('img');
            const me = document.createElement('div');
            me.className = 'marker';
            image.className = 'icon-marker';
            image.src = 'storage/images/pin.svg';
            me.appendChild(image);
            const p1 = document.createElement('p')
            p1.innerText = mp.title;
            me.appendChild(p1);
            const p2 = document.createElement('p')
            p2.innerText = mp.body;
            me.appendChild(p2);
            me.onclick = (e) => {
                e.stopPropagation();
                alert(mp.title + ': ' + mp.body)
            };
            map.addChild(new YMapMarker({coordinates: [mp['longitude'], mp['latitude']]}, me));
        },
        submitForm() {
            const form = document.getElementById('addMarker');
            const formEntries = new FormData(form).entries();
            const json = Object.assign(...Array.from(formEntries, ([x,y]) => ({[x]:y})));
            const data = {
                data: {
                    type: 'balloons',
                    "attributes": json
                }
            };

            fetch('/api/v1/balloons', {
                method: 'POST',
                headers: new Headers({'content-type': 'application/vnd.api+json'}),
                body: JSON.stringify(data)
            }).then(response => {
                this.modalShow = false;
                form.reset();
                this.addMarkerToMap(data.data)
            });
        }
    }))
});

Alpine.start();
