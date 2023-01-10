/* ------------------------------------------------------------------------------
 *
 *  # Leaflet maps
 *
 *  Specific JS code additions for maps_leaflet.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const LeafletMaps = function() {


    //
    // Setup module components
    //

    // Basic map example
    const _leafletMapBasic = function() {
        if (typeof leaflet == 'undefined') {
            console.warn('Warning - leaflet.min.js is not loaded.');
            return;
        }

        //
        // Map settings
        //

        // Config map
        let config = {
            minZoom: 7,
            maxZoom: 18
        };

        // Magnification with which the map will start
        const zoom = 15;

        // Co-ordinates
        const lat = 52.37;
        const lng = 4.9041;

        // Calling map
        const map = L.map("leaflet_basic", config).setView([lat, lng], zoom);

        // Used to load and display tile layers on the map
        // Most tile servers require attribution, which you can set under `Layer`
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            className: 'map-leaflet'
        }).addTo(map);
    };

    // Cluster groups
    const _leafletMapCluster = function() {
        if (typeof leaflet == 'undefined') {
            console.warn('Warning - leaflet.min.js is not loaded.');
            return;
        }

        //
        // Map settings
        //

        // Config map
        let config = {
            minZoom: 6,
            maxZoom: 18
        };

        // Magnification with which the map will start
        const zoom = 13;

        // Coordinates
        const lat = -37.82;
        const lng = 175.24;

        // Calling map
        const map = L.map("leaflet_cluster", config).setView([lat, lng], zoom);

        // Used to load and display tile layers on the map
        // Most tile servers require attribution, which you can set under `Layer`
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            className: 'map-leaflet'
        }).addTo(map);

        // L.MarkerClusterGroup extends L.FeatureGroup
        // by clustering the markers contained within
        let markers = L.markerClusterGroup();

        // Add markers to the layer
        for (var i = 0; i < addressPoints.length; i++) {
            var a = addressPoints[i];
            var title = a[2];
            var marker = L.marker(new L.LatLng(a[0], a[1]), { title: title });
            marker.bindPopup(title);
            markers.addLayer(marker);
        }

        // Add all markers to map
        map.addLayer(markers);
    };

    // GeoJSON example
    const _leafletMapGeoJson = function() {
        if (typeof leaflet == 'undefined') {
            console.warn('Warning - leaflet.min.js is not loaded.');
            return;
        }

        //
        // Map settings
        //

        // Config map
        let config = {
            minZoom: 6,
            maxZoom: 19
        };

        // Magnification with which the map will start
        const zoom = 13;

        // Coordinates
        const lat = 39.74739;
        const lng = -105;

        // Calling map
        const map = L.map("leaflet_geojson", config).setView([lat, lng], zoom);

        // Used to load and display tile layers on the map
        // Most tile servers require attribution, which you can set under `Layer`
        const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            className: 'map-leaflet'
        }).addTo(map);

        // Popup content
        function onEachFeature(feature, layer) {
            let popupContent = '<p>I started out as a GeoJSON ' + feature.geometry.type + ', but now I\'m a Leaflet vector!</p>';

            if (feature.properties && feature.properties.popupContent) {
                popupContent += feature.properties.popupContent;
            }

            layer.bindPopup(popupContent);
        }

        // bicycleRental layer
        const bicycleRentalLayer = L.geoJSON([bicycleRental, campus], {
            style: function (feature) {
                return feature.properties && feature.properties.style;
            },
            onEachFeature: onEachFeature,
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, {
                    radius: 8,
                    fillColor: '#ff7800',
                    color: '#000',
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.8
                });
            }
        }).addTo(map);

        // freeBus layer
        const freeBusLayer = L.geoJSON(freeBus, {
            filter: function (feature, layer) {
                if (feature.properties) {
                    // If the property "underConstruction" exists and is true, return false (don't render features under construction)
                    return feature.properties.underConstruction !== undefined ? !feature.properties.underConstruction : true;
                }
                return false;
            },
            onEachFeature: onEachFeature
        }).addTo(map);

        // coorsField layer
        const coorsLayer = L.geoJSON(coorsField, {
            pointToLayer: function (feature, latlng) {
                return L.marker(latlng);
            },
            onEachFeature: onEachFeature
        }).addTo(map);
    };

    // Layer groups and control
    const _leafletMapGroupsControls = function() {
        if (typeof leaflet == 'undefined') {
            console.warn('Warning - leaflet.min.js is not loaded.');
            return;
        }

        //
        // Map settings
        //

        // Base layer group
        const cities = L.layerGroup();

        // Markers
        const mLittleton = L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.').addTo(cities);
        const mDenver = L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.').addTo(cities);
        const mAurora = L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.').addTo(cities);
        const mGolden = L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.').addTo(cities);

        // Map details
        const mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>';
        const mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
     
        // Streets layer
        const streets = L.tileLayer(mbUrl, {
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        });

        // OpenStreetMap layer
        const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            className: 'map-leaflet'
        });

        // Calling map
        const map = L.map('leaflet_groups_controls', {
            center: [39.73, -104.99],
            zoom: 10,
            layers: [osm, cities]
        });

        // Base layers
        const baseLayers = {
            'OpenStreetMap': osm,
            'Streets': streets
        };

        // Base overlays
        const overlays = {
            'Cities': cities
        };

        // Set controls
        const layerControl = L.control.layers(baseLayers, overlays).addTo(map);
        const crownHill = L.marker([39.75, -105.09]).bindPopup('This is Crown Hill Park.');
        const rubyHill = L.marker([39.68, -105.00]).bindPopup('This is Ruby Hill Park.');

        // Set layers
        const parks = L.layerGroup([crownHill, rubyHill]);
        const satellite = L.tileLayer(mbUrl, {
            id: 'mapbox/satellite-v9',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr,
            className: 'map-leaflet'
        });
        layerControl.addBaseLayer(satellite, 'Satellite');
        layerControl.addOverlay(parks, 'Parks');
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _leafletMapBasic();
            _leafletMapCluster();
            _leafletMapGeoJson();
            _leafletMapGroupsControls();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    LeafletMaps.init();
});
