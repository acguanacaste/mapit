<html>
<head>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/stlye.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <meta charset='utf-8' />
    <title>Display a map</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.49.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.49.0/mapbox-gl.css' rel='stylesheet' />
    <style>
        body { margin:0; padding:0; }
        #map {width: 100%;height: 80%; }
    </style>
</head>
<body>
<div class="container">
    <form method="post" action="/"  enctype="multipart/form-data">
        <div class="form-group row">
            <label for="upload" class="col-sm-4">Upload file:<br/> (FMP mer file or csv with a header row)</label>
            <input type="file" name="upload" id="upload" class="form-control-file col-sm-8" >
        </div>
        <div class="form-group">
            <input type="submit" value="Map it!" class="btn btn-primary mb-2">
        </div>
        <input type="hidden" name="s" value="upload">
    </form>
</div>
<?php
if (!empty($filename)){
    ?>
    <div class="container">
        <h4><?php echo $filename;?></h4>
    </div>
<?php
}
?>
<div class="container">
    <div id="map" class="map"></div>
</div>
<script>
    var records = {};
    <?php
        if (isset($records) && !empty($records)){
            $records = json_encode($records);
            echo "records = $records;";
        }
    ?>
    function loadMarkers(map,data) {
        const bug1 = data[0]["Herbivore species"]
        data.forEach(function (marker){
            var el = document.createElement('div')
            var classType = (marker["Herbivore species"] == bug1)? "marker1":"marker2"
            console.log(data["Herbivore species"])
            el.className = 'marker '+classType

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
            map.removeLayer('toggle-turismo');
            map.removeLayer('toggle-unesco');
            map.initialLoaded = true;
        }
    });



</script>
</body>
</html>


