<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Plant_Source_File_CsvAd implements Model_Plant_Source_Interface {

    private static $hand;
    private static $instance;

    private function __construct() {
        //self::$hand = fopen($_SERVER['DOCUMENT_ROOT'] . 'baza_produktow.csv', "r");
        //self::$hand = fopen($_SERVER['DOCUMENT_ROOT'] . 'katalog/katalog.csv', "r");
    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self( );
        }
        return self::$instance;
    }

    public function __destruct() {
        if (is_resource(self::$hand)) {
            fclose(self::$hand);
        }
    }

    public function getData() {

        $list = new Model_Collection();

        if (Manager_Config::isDev()) {
            $csv = new SplFileObject($_SERVER['DOCUMENT_ROOT'] . 'katalog/katalog-v1.csv', 'r');
        } else {
            $csv = new SplFileObject('../public/katalog/katalog.csv', 'r');
        }

        $csv->setFlags(SplFileObject::READ_CSV);

        //$string = iconv("UTF-8","UTF-8//IGNORE", $string);

        $codeTool = new Model_Tool_Code();

        $i = 0;

        while (!$csv->eof()) {

            $i++;
            $data = $csv->fgetcsv(';', "\n", "\\");
            //print_r($data); 

            if ($data[0] == 'L.p') {
                continue;
            }

            if (!isset($data[12]) || count($data) != 13) {
                continue;
            }

            $plant = new Model_Plant_ContainerAd();

            $plant->setName(Model_Tool_String::utf8($data[4]));
            $tmp = explode('"', Model_Tool_String::utf8($data[6]));

            if (isset($tmp[1])) {
                $plant->setNameLT($tmp[1]);
            }

            if (isset($tmp[3])) {
                $plant->setSpecies($tmp[3]);
            }
            /* $status = 'D';
              if ($data[5] == 'D') {
              $status = 'A';
              } elseif ($data[5] == 'P') {
              $status = 'P';
              } */

            $plant->setStatus($this->getStatus($data[5]));

            $plant->setDescription(Model_Tool_String::escape(Model_Tool_String::utf8($data[7])));




            $plant->setHeight($data[9]);

            $pot = new Model_Plant_Pot_ContainerAd();
            $pot->setId($this->getPotId($data[10]));
            $plant->setPot($pot);
            $plant->setPrice((int) $data[11]);


            $category = new Model_Plant_Category_Container();
            $category->setId($data[12]);
            $plant->setCategory($category);

            $no = $codeTool->getCode($plant);

            //echo($no) . '<br>';

            $plant->setIsnNo($no); /**/


            $plant->setIcon(str_replace('zdjcia\\', '', $data[8]));

            $imgUpload = Model_Tool_Upload_Image::getInstance();
            $plant = $imgUpload->save($plant);


            /////////

            /* $plant->setCategory($category);
              $plant->setId($data[3]);

              $plant->setSpecies($data[5]);
              $plant->setGenus($data[6]);
              $plant->setPrice($data[7]);
              $plant->setHeight($data[8]);

              $pot = new Model_Plant_Pot_Container();
              $pot->setDiameter($data[9]);
              $pot->setHeight($data[10]);
              $plant->setPot($pot);

              $plant->setHeightMax($data[11]);
              $plant->setPeriodBloom($data[12]);
              $plant->setPeriodSow($data[13]); */

            /* $items = new Model_Collection();

              //foto child
              $photo = new Model_Gallery_Photo_Container();
              $file = new Model_File_Container();
              $file->setUrl($data[6]);
              $photo->setFile($file);
              $items->append($photo); */

            /* //foto adult
              $photo = new Model_Gallery_Photo_Container();
              $file = new Model_File_Container();
              $file->setUrl($data[15]);
              $photo->setFile($file);
              $items->append($photo); */

            /* $gallery = new Model_Gallery_Container();
              $gallery->setItems($items);
              $plant->setGallery($gallery); */


            $list->append($plant);
        }
        // exit;
        // print_r($list);exit;
        //fclose(self::$hand);
        //}

        return $list;
    }

    public function getPlantById($id) {
        //$plant = new Model_Plant_Container();
        if (is_resource(self::$hand)) {
            while (($row = fgetcsv(self::$hand, 1000, ";")) !== FALSE) {
                if ($row[3] == $id) {
                    $plant = self::buildPlant($row);
                }
            }
            fclose(self::$hand);
        }
        return isset($plant) ? $plant : null;
    }

    public function getPlantListByCategoryId($id, $pack, $sizePack, $sort = Model_Api_Abstract::SORT_ID, $order = Model_Api_Abstract::ORDER_ASC) {
        $list = new Model_Collection();
        if (is_resource(self::$hand)) {
            while (($row = fgetcsv(self::$hand, 1000, ";")) !== FALSE) {
                if ($row[1] == $id) {
                    $list->append(self::buildPlant($row));
                }
            }
            fclose(self::$hand);
        }
        return $list;
    }

    public function getMixPlant($sizePack) {
        
    }

    public static function buildPlant($row) {
        $plant = new Model_Plant_Container();

        $category = new Model_Plant_Category_Container();
        $category->setId(trim($row[1]));
        $plant->setCategory($category);
        $plant->setId($row[3]);
        $plant->setName(trim($row[4]));
        $plant->setSpecies($row[5]);
        $plant->setGenus($row[6]);
        $plant->setPrice($row[7]);
        $plant->setHeight($row[8]);

        $pot = new Model_Plant_Pot_Container();
        $pot->setDiameter($row[9]);
        $pot->setHeight($row[10]);
        $plant->setPot($pot);

        $plant->setHeightMax($row[11]);
        $plant->setPeriodBloom($row[12]);
        $plant->setPeriodSow($row[13]);

        $items = new Model_Collection();

        //foto child
        $photo = new Model_Gallery_Photo_Container();
        $file = new Model_File_Container();
        $file->setUrl($row[14]);
        $photo->setFile($file);
        $items->append($photo);

        //foto adult
        $photo = new Model_Gallery_Photo_Container();
        $file = new Model_File_Container();
        $file->setUrl($row[15]);
        $photo->setFile($file);
        $items->append($photo);


        $gallery = new Model_Gallery_Container();
        $gallery->setItems($items);
        $plant->setGallery($gallery);
        return $plant;
    }

    public function getPromotionPlantList($pack, $sizePack, $sort = Model_Api_Abstract::SORT_ID, $order = Model_Api_Abstract::ORDER_ASC) {
        
    }

    private function buildListPlant($row) {
        //$list = new Model_Collection();
    }

    private function getPotId($name) {

        $tmp = array('P11' => '1', 'P13' => '3',  'P15' => '5','P16' => '6','P17' => '7','P18' => '8','P19' => '9','P20' => '10', );

        return $tmp[$name];
    }

    private function getStatus($status) {

        $tmp = array('D' => Model_Api_Abstract::STATUS_ACTIVE, 'P' => Model_Api_Abstract::STATUS_PROMOTE, 'N' => Model_Api_Abstract::STATUS_DELETE);

        return $tmp[$status];
    }

}
