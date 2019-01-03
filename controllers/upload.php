<?php

class Upload
{
    private $uploadFolder;
    public $fileName;
    public $records;
    public $message;
    public $link;


    function __construct() {
        $this->setUploadFoder($_ENV['BASEFOLDER']."/var/uploads/");
        if (!file_exists($this->getUploadFoder())) {
            mkdir($this->getUploadFoder(), 0775, true);
        }
    }
    /**
     * @param array $file
     * @return string $filename
     **/
    public function processUpload($file)
    {
        $uploadFolder = $this->getUploadFoder();
        $fileName = mb_ereg_replace("([^\w\d\-_~,;\[\]\(\).])", '', $file['name']);
        $fileName = mb_ereg_replace("([\.]{2,})", '', $fileName);
        $fileName = time() . "-" . $fileName;
        if (file_exists($uploadFolder)) {
            if (move_uploaded_file($file['tmp_name'], $uploadFolder . $fileName)) {
                $this->setFileName($fileName);
                return $fileName;
            }
        }
        return false;
    }

    public function uploadAction($file){

        if ($this->processUpload($file)){
           $this->processRecords();
           $this->viewRecords();

        }
    }

    /**
     * Passes file to records on array
     * @return array|bool
     */
    public function processRecords()
    {
        $records = array();
        ini_set("auto_detect_line_endings", true);
        if (!empty($this->fileName)){
            $file = $this->getUploadFoder() . $this->getFileName();
            if (file_exists($file)){
                $handle = fopen($file, 'r');
                $count = 0;
                $data = array();
                $fields = array();
                do {
                    if (isset($data[0])) {
                        if ($count == 0) {
                            foreach ($data as $unCampo) {
                                $str = preg_replace(
                                    '/
                                        ^
                                        [\pZ\p{Cc}\x{feff}]+
                                        |
                                        [\pZ\p{Cc}\x{feff}]+$
                                       /ux',
                                    '',
                                    $unCampo
                                );

                                $fields[] = $str; //str_replace(" ", "_", strtolower($unCampo));
                            }
                            $count++;
                        }
                        else {

                            $data = array_combine($fields, $data); //los arrays dentro de raw data son asociativos ahora
                            $records[] = $data;
                        }
                    }
                } while ($data = fgetcsv($handle, 0, ",", '"'));
                /*echo "<pre> Data:";
                var_dump($records[1]);
                echo "</pre>";*/
                fclose($handle);
                $this->setRecords($records);
                return $records;
            }
            else{
                echo 'File doesnt exist';
            }
        }
        return false;
    }

    public function viewAction ($file){
        $filePath = $this->uploadFolder.$file;
        if (file_exists($filePath)){
            $this->setFileName($file);
            $this->processRecords();
            $this->viewRecords();
        }else{
            $this->setMessage("File $file doesn't exists!");
        }

    }

    public function viewRecords(){
        $records = $this->getRecords();
        $filename= $this->getFileName();
        $message = $this->getMessage();
        $link = $_ENV['BASEURL']."?s=view&file=".$filename;
        include 'views/form.php';
    }

    /**
     * @return string
     */
    public
    function getUploadFoder()
    {
        return $this->uploadFolder;
    }

    /**
     * @param string $uploadFoder
     */
    public
    function setUploadFoder($uploadFoder)
    {
        $this->uploadFolder = $uploadFoder;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return mixed
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param mixed $records
     */
    public function setRecords($records)
    {
        $this->records = $records;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}


