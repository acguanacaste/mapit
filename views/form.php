<html>
<head>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
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
</body>
</html>
