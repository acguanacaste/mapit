function loadMarkers(map,data) {
    let markerClasses = [];
    let typeCounter = 1;
    let legend = [];
    data.forEach(function (marker){
        let el = document.createElement('div');
        console.log(marker["Herbivore species"]);
        if (typeof markerClasses[marker["Herbivore species"]] === 'undefined'){
            markerClasses[marker["Herbivore species"]]="marker"+typeCounter.toString();
            typeCounter++;
            legend.push({
                species:marker["Herbivore species"],
                color:markerClasses[marker["Herbivore species"]]
            })
        }
        el.className = "marker "+markerClasses[marker["Herbivore species"]];

        let popup = new mapboxgl.Popup({ offset: 25 })
            .setHTML("Voucher: "+marker['Voucher']+ "<br> Herbivore species: "+marker["Herbivore species"]);

        new mapboxgl.Marker(el)
            .setLngLat([marker.Longitude, marker.Latitude])
            .setPopup(popup)
            .addTo(map);

        console.log('marker added')
    });
    let legendEl = document.getElementById("legend");
    let node = document.createElement("ul");


    legendEl.appendChild(node);
    legend.map (item => {
        let childItem = document.createElement("li");
        childItem.innerHTML = `<div class="marker ${item.color}"></div><span>${item.species}</span>`;
        node.appendChild(childItem);

    });
    legendEl.appendChild(node);
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
        const nav = new mapboxgl.NavigationControl({ showCompass: false });
        map.addControl(nav, "top-left");
        map.initialLoaded = true;
    }
});
