<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Plant_Source_File_Csv implements Model_Plant_Source_Interface {

    private static $hand;
    private static $instance;

    private function __construct() {
        self::$hand = fopen($_SERVER['DOCUMENT_ROOT'] . 'baza_produktow.csv', "r");
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
        if (is_resource(self::$hand)) {
            while (($data = fgetcsv(self::$hand, 1000, ";")) !== FALSE) {

                if ($data[0] == 'lp.' || $data[0] == 0) {
                    continue;
                }
                $plant = new Model_Plant_Container();

                $category = new Model_Plant_Category_Container();
                $category->setId($data[1]);
                $plant->setCategory($category);
                $plant->setId($data[3]);
                $plant->setName($data[4]);
                $plant->setSpecies($data[5]);
                $plant->setGenus($data[6]);
                $plant->setPrice($data[7]);
                $plant->setHeight($data[8]);

                $pot = new Model_Plant_Pot_Container();
                $pot->setWidth($data[9]);
                $pot->setHeight($data[10]);
                $plant->setPot($pot);

                $plant->setHeightMax($data[11]);
                $plant->setPeriodBloom($data[12]);
                $plant->setPeriodSow($data[13]);

                $items = new Model_Collection();

                //foto child
                $photo = new Model_Gallery_Photo_Container();
                $file = new Model_File_Container();
                $file->setUrl($data[14]);
                $photo->setFile($file);
                $items->append($photo);

                //foto adult
                $photo = new Model_Gallery_Photo_Container();
                $file = new Model_File_Container();
                $file->setUrl($data[15]);
                $photo->setFile($file);
                $items->append($photo);

                $gallery = new Model_Gallery_Container();
                $gallery->setItems($items);
                $plant->setGallery($gallery);
                $list->append($plant);
            }
            fclose(self::$hand);
        }
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

    public function getCategoryPlantsById($id, $pack, $sizePack) {
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
        $pot->setWidth($row[9]);
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

    private function buildListPlant($row) {
        //$list = new Model_Collection();
    }

}
