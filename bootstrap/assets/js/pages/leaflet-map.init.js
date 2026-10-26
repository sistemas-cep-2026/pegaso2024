// =====================================================
// LEAFLET MAP - OPENSTREETMAP SIN TOKEN
// Proyecto: PEGASO2024
// =====================================================

// Configuración general OpenStreetMap
const osmUrl = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";

const osmOptions = {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
};

function crearCapaMapa() {
    return L.tileLayer(osmUrl, osmOptions);
}

// =====================================================
// 1. MAPA BÁSICO
// =====================================================

if (document.getElementById("leaflet-map")) {

    var mymap = L.map("leaflet-map").setView([51.505, -0.09], 13);

    crearCapaMapa().addTo(mymap);
}

// =====================================================
// 2. MAPA CON MARCADORES
// =====================================================

if (document.getElementById("leaflet-map-marker")) {

    var markermap = L.map("leaflet-map-marker")
        .setView([51.505, -0.09], 13);

    crearCapaMapa().addTo(markermap);

    L.marker([51.5, -0.09]).addTo(markermap);

    L.circle([51.508, -0.11], {
        color: "#0ab39c",
        fillColor: "#0ab39c",
        fillOpacity: 0.5,
        radius: 500
    }).addTo(markermap);

    L.polygon([
        [51.509, -0.08],
        [51.503, -0.06],
        [51.51, -0.047]
    ], {
        color: "#405189",
        fillColor: "#405189"
    }).addTo(markermap);
}

// =====================================================
// 3. MAPA CON POPUPS
// =====================================================

if (document.getElementById("leaflet-map-popup")) {

    var popupmap = L.map("leaflet-map-popup")
        .setView([51.505, -0.09], 13);

    crearCapaMapa().addTo(popupmap);

    L.marker([51.5, -0.09])
        .addTo(popupmap)
        .bindPopup("<b>Hello world!</b><br>I am a popup.")
        .openPopup();

    L.circle([51.508, -0.11], {
        radius: 500,
        color: "#f06548",
        fillColor: "#f06548",
        fillOpacity: 0.5
    })
        .addTo(popupmap)
        .bindPopup("I am a circle.");

    L.polygon([
        [51.509, -0.08],
        [51.503, -0.06],
        [51.51, -0.047]
    ], {
        color: "#405189",
        fillColor: "#405189"
    })
        .addTo(popupmap)
        .bindPopup("I am a polygon.");
}

// =====================================================
// 4. MAPA CON ICONOS PERSONALIZADOS
// =====================================================

if (document.getElementById("leaflet-map-custom-icons")) {

    var customiconsmap = L.map("leaflet-map-custom-icons")
        .setView([51.5, -0.09], 13);

    crearCapaMapa().addTo(customiconsmap);

    var LeafIcon = L.Icon.extend({
        options: {
            iconSize: [45, 45],
            iconAnchor: [22, 94],
            popupAnchor: [-3, -76]
        }
    });

    var greenIcon = new LeafIcon({
        iconUrl: "assets/images/logo-sm.png"
    });

    L.marker([51.5, -0.09], {
        icon: greenIcon
    }).addTo(customiconsmap);
}

// =====================================================
// 5. MAPA INTERACTIVO
// =====================================================

function getColor(e) {

    return e > 1000 ? "#405189" :
        e > 500 ? "#516194" :
            e > 200 ? "#63719E" :
                e > 100 ? "#7480A9" :
                    e > 50 ? "#8590B4" :
                        e > 20 ? "#97A0BF" :
                            "#A8B0C9";
}

function style(e) {

    return {
        weight: 2,
        opacity: 1,
        color: "white",
        dashArray: "3",
        fillOpacity: 0.7,
        fillColor: getColor(e.properties.density)
    };
}

if (document.getElementById("leaflet-map-interactive-map")) {

    var interactivemap = L.map("leaflet-map-interactive-map")
        .setView([37.8, -96], 4);

    crearCapaMapa().addTo(interactivemap);

    if (typeof statesData !== "undefined") {

        var geojson = L.geoJson(statesData, {
            style: style
        }).addTo(interactivemap);
    }
}

// =====================================================
// 6. MAPA CON CONTROL DE CAPAS
// =====================================================

if (document.getElementById("leaflet-map-group-control")) {

    var cities = L.layerGroup();

    L.marker([39.61, -105.02])
        .bindPopup("This is Littleton, CO.")
        .addTo(cities);

    L.marker([39.74, -104.99])
        .bindPopup("This is Denver, CO.")
        .addTo(cities);

    L.marker([39.73, -104.8])
        .bindPopup("This is Aurora, CO.")
        .addTo(cities);

    L.marker([39.77, -105.23])
        .bindPopup("This is Golden, CO.")
        .addTo(cities);

    var streets = crearCapaMapa();
    var grayscale = crearCapaMapa();

    var layergroupcontrolmap = L.map("leaflet-map-group-control", {
        center: [39.73, -104.99],
        zoom: 10,
        layers: [streets, cities]
    });

    var baseLayers = {
        "OpenStreetMap": streets,
        "Mapa alternativo": grayscale
    };

    var overlays = {
        "Cities": cities
    };

    L.control.layers(baseLayers, overlays)
        .addTo(layergroupcontrolmap);
}