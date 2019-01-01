<?php

class Upload
{
    private $uploadFolder = "/srv/www/ACG/mapa/var/uploads/";
    public $fileName;
    public $records;


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
                $this->fileName = $fileName;
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
        if (!empty($this->fileName)){
            $file = $this->uploadFolder . $this->fileName;
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
                $this->records = $records;
                return $records;
            }
            else{
                echo 'File doesnt exist';
            }
        }
        return false;
    }

    public function viewRecords(){
        $records = $this->records;
        $filename= $this->fileName;
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
}


