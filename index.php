<?php

error_reporting(E_ALL);
require __DIR__ . '/vendor/autoload.php';
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

    default:{
        require 'views/form.php';
    }
}
