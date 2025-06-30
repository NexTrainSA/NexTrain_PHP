let map;
let marker;

function initMap() {
    const defaultLocation = { lat: -26.3045, lng: -48.8487 }; // Joinville

    map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLocation,
        zoom: 12
    });

    marker = new google.maps.Marker({
        map: map,
        position: defaultLocation
    });

    const input = document.getElementById("search-box");
    const autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        if (!place.geometry || !place.geometry.location) {
            alert("Local não encontrado");
            return;
        }

        // Centraliza o mapa e move o marcador
        map.setCenter(place.geometry.location);
        map.setZoom(14);
        marker.setPosition(place.geometry.location);
    });
}