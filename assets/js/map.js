function loadMarkers(map,data) {
    const bug1 = data[0]["Herbivore species"];
    let markerClasses = [];
    let typeCounter = 1;

    data.forEach(function (marker){
        let el = document.createElement('div');
        console.log(marker["Herbivore species"]);
        if (markerClasses[marker["Herbivore species"]]==undefined){
            const classNumber = "marker"+typeCounter.toString();
            markerClasses[marker["Herbivore species"]]=classNumber;
            typeCounter++;
        }
        el.className = "marker "+markerClasses[marker["Herbivore species"]];

        var popup = new mapboxgl.Popup({ offset: 25 })
            .setHTML("Voucher: "+marker['Voucher']+ "<br> Herbivore species: "+marker["Herbivore species"]);

// create DOM element for the marker


        new mapboxgl.Marker(el)
            .setLngLat([marker.Longitude, marker.Latitude])
            .setPopup(popup)
            .addTo(map)

        console.log('marker added')
    });
}

mapboxgl.accessToken = 'pk.eyJ1IjoiZ3VhbmFjYXN0ZSIsImEiOiJjamowNzhuYnAwZXU2M2txczhsc21mbDVsIn0.amJMu3O1jfjcbg-B1qC7ww';
const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/guanacaste/cjpuc9ful00ce2sl3u1pfvezx',
    center: [-85.61365526723557, 10.838261234356153],
    zoom: 9.6
});
map.initialLoaded = false;

map.on('load',function (){


    if (records.length > 0) {
        loadMarkers(map,records);
    }
});

map.on("data", () => {
    if (!map.initialLoaded && !map.loaded()) {
        map.removeLayer('toggle-ecosistemas');
        map.removeLayer('toggle-sectores');
        map.removeLayer('toggle-turismo');
        map.removeLayer('toggle-unesco');
        map.initialLoaded = true;
    }
});
