<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Plant_Source_Api extends Model_Api_Abstract implements Model_Plant_Source_Interface  {

    public function __construct($source = Model_Plant_Source_Factory::DB_MYSQL) {
        $this->source = Model_Plant_Source_Factory::getSource($source);
    }

    public function getData() {
        return $this->source->getData();
    }

    public function getPlantById($id) {
        $id = self::validId($id);
        $plant = $this->source->getPlantById($id);
        return self::validObject($plant, 'Model_Plant_Container');
    }

    public function getCategoryPlantsById($id, $pack = 1, $sizePack = 10) {
        $id = self::validId($id);
        $pack = self::validPack($pack);
        $sizePack = self::validPackSize($sizePack);
        $list = $this->source->getCategoryPlantsById($id, $pack, $sizePack);
        return self::validList($list);
    }

    public function getMixPlant($sizePack = 10) {
        $sizePack = self::validPackSize($sizePack);
        $list = $this->source->getData($sizePack);//@todo
        return self::validList($list);
    }   
   
}
