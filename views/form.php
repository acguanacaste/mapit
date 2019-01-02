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
    <div class="">
        <div class="col-sm-8">
            <form method="post" action="/"  enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <label for="upload" class="col-sm-5 control-label" >Upload file:<br/> (FMP mer file or csv with a header row)</label>
                    <div class="col-sm-7">
                        <input type="file" name="upload" id="upload" class="form-control-file " >
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Map it!" class="btn btn-primary ">
                    </div>
                </div>



                <input type="hidden" name="s" value="upload">
            </form>
        </div>

        <div class="col-sm-4">
            <?php
            if (!empty($link)){
                ?>
                <div class="input-group col-sm-12">
                    <div class="col-sm-12">
                        <span class="input-group col-sm-12">Link to thihs map:</span>
                    </div>
                    <textarea class="form-control" aria-label="With textarea"><?php echo $link;?></textarea>
                </div>

                <?php
            }
            ?>
        </div>
    </div>

</div>
<?php
if (!empty($message)){
  ?>
    <div class="">

    </div>
    <p class="bg-info">
        <?php echo $message; ?>
        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </p>
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
</script>
<script src="/assets/js/map.js" type="text/javascript"></script>
</body>
</html>


