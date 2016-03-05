<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

interface Model_Plant_Source_Interface {    
   public function getPlantById($id);
   public function getCategoryPlantsById($id, $pack, $sizePack);
   public function getMixPlant($sizePack);
}

