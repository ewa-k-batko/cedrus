<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Plant_Source_ApiAd extends Model_Api_Abstract {

    public function __construct($source = Model_Plant_Source_Factory::DB_MYSQL_AD) {
        $this->source = Model_Plant_Source_Factory::getSource($source);
    }

    public function getCategoryList($pack = 1, $sizePack = 20, $sort = self::SORT_NAME, $order = self::ORDER_ASC) {
        $pack = self::validPack($pack);
        $sizePack = self::validPackSize($sizePack);
        $sort = self::validSort($sort);
        $order = self::validOrder($order);
        $list = $this->source->getCategoryList($pack, $sizePack, $sort, $order);
        return self::validListAd($list);
    }
    
    public function getOfferList() {
        $res = $this->source->getOfferList();
        var_dump($res);
        return $res;
    }

    public function getCategorySetAd(Model_Plant_Category_ContainerAd $category) {
        //@todo validate
        $res = $this->source->getCategorySetAd($category);
        return $res;
    }

   /* public function getCategoryAddAd(Model_Plant_Category_ContainerAd $category) {
        //@todo validate
        $res = $this->source->getCategoryAddAd($category);


        return $res;
    }*/

    public function getCategoryByIdAd($id) {
        //@todo validate
        $res = $this->source->getCategoryByIdAd($id);
        // print_r($res);
        return $res;
    }

    public function getPlantListAd($pack = 1, $sizePack = 20, $sort = self::SORT_NAME, $order = self::ORDER_ASC) {
        $pack = self::validPack($pack);
        $sizePack = self::validPackSize($sizePack);
        $sort = self::validSort($sort);
        $order = self::validOrder($order);
        $list = $this->source->getPlantListAd($pack, $sizePack, $sort, $order);
        return self::validListAd($list);
    }

    public function getPlantByIdAd($id) {
        //@todo validate
        $res = $this->source->getPlantByIdAd($id);
        // print_r($res);
        return $res;
    }

    public function getPlantSetAd(Model_Plant_ContainerAd $plant) {
        //@todo validate
        $res = $this->source->getPlantSetAd($plant);
        return $res;
    }
    
    public function getPotListAd($pack = 1, $sizePack = 20, $sort = self::SORT_NAME, $order = self::ORDER_ASC) {
        $pack = self::validPack($pack);
        $sizePack = self::validPackSize($sizePack);
        $sort = self::validSort($sort);
        $order = self::validOrder($order);
        $list = $this->source->getPotListAd($pack, $sizePack, $sort, $order);
        return self::validListAd($list);
    }

    public function getPotByIdAd($id) {
        //@todo validate
        $res = $this->source->getPotByIdAd($id);
        // print_r($res);
        return $res;
    }

    public function getPotSetAd(Model_Plant_Pot_ContainerAd $pot) {
        //@todo validate
        $res = $this->source->getPotSetAd($pot);
        return $res;
    }
    
    public function getStuffListAd($type, $pack = 1, $sizePack = 20, $sort = self::SORT_NAME, $order = self::ORDER_ASC) {
        
        //@todo validate type
        $pack = self::validPack($pack);
        $sizePack = self::validPackSize($sizePack);
        $sort = self::validSort($sort);
        $order = self::validOrder($order);
        $list = $this->source->getStuffListAd($type, $pack, $sizePack, $sort, $order);
        return self::validListAd($list);
    }

    public function getStuffByIdAd($id) {
        //@todo validate
        $res = $this->source->getStuffByIdAd($id);
        // print_r($res);
        return $res;
    }

    public function getStuffSetAd(Model_Stuff_ContainerAd $stuff) {
        //@todo validate
        $res = $this->source->getStuffSetAd($stuff);
        return $res;
    }

}
