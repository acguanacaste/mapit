<?php

$_ENV['BASEFOLDER'] = __DIR__;
$protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
$base = $protocol.$_SERVER['SERVER_NAME'].($_SERVER['SERVER_PORT']!='80'?":".$_SERVER['SERVER_PORT']:null);
$_ENV['BASEURL'] = $base.parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
require __DIR__ . '/controllers/upload.php';
require __DIR__ . '/controllers/uploadForm.php';


$action = !empty($_REQUEST['s'])?$_REQUEST['s']:"default";
switch ($action){
    case "upload":{

        $files = $_FILES;
        if (!empty($files)){
            $upload = new Upload();
            $upload->uploadAction($files['upload']);
            break;
        }
    }

    case "view":{
        $file = $_REQUEST['file'];
        $upload = new Upload();
        $upload->viewAction($file);
        break;
    }

    default:{
        require 'views/form.php';
    }
}
