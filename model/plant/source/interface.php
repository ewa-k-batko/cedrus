<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

interface Model_Plant_Source_Interface {    
   public function getPlantById($id);
   public function getPlantListByCategoryId($id, $pack, $sizePack, $sort = Model_Api_Abstract::SORT_ID, $order= Model_Api_Abstract::ORDER_ASC);
   public function getMixPlant($sizePack);
   public function getPromotionPlantList($pack, $sizePack, $sort = Model_Api_Abstract::SORT_ID, $order= Model_Api_Abstract::ORDER_ASC) ;
}

