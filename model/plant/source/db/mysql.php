<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Plant_Source_Db_Mysql implements Model_Plant_Source_Interface {

    private static $db;
    private static $instance;

    private function __construct() {
        self::$db = Model_Db_Mysql::getInstance(Manager_Config::dbCnf());
    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self( );
        }
        return self::$instance;
    }

    //public function __destruct() {}

    public function getCategoryList() {
       
    }

    public function getPlantById($id) {
        $sql = 'call PLS_PLANT_BY_ID(' . $id . ' );';
        //echo $sql;

        try {
            $res = self::$db->multiQuery($sql);
            //print_r($res);
        } catch (Model_Db_Exception_NotFound $e) {
            throw new Manager_Exception_NotFound();
        } catch (Model_Db_Exception_Unavailable $e) {
            throw new Manager_Exception_Unavailable();
        }
        if (!isset($res[0]->cpp_id) || $res[0]->cpp_id <= 0) {
            throw new Manager_Exception_NotFound();
        }
        $build = new Model_Plant_Source_Db_Mysql_Build_Plant();
        $plant = $build->getContainer();
        return $build->single($plant, $res[0]);
    }

    public function getPlantListByCategoryId($id, $pack, $sizePack, $sort = Model_Api_Abstract::SORT_ID, $order= Model_Api_Abstract::ORDER_ASC) {

        $sql = 'call PLS_PLANT_LIST_BY_CATEGORY_ID(' . $id.','.$pack . ',' . $sizePack . ',"' . $sort . '", "' . $order . '" );';
        //echo $sql;

        try {
            $res = self::$db->multiQuery($sql);
           // print_r($res);
        } catch (Model_Db_Exception_NotFound $e) {            
            throw new Manager_Exception_NotFound();
        } catch (Model_Db_Exception_Unavailable $e) {
            throw new Manager_Exception_Unavailable();
        }
        if (!isset($res[0]->cpp_id) || $res[0]->cpp_id <= 0) {
            throw new Manager_Exception_NotFound();
        }
        $build = new Model_Plant_Source_Db_Mysql_Build_Plant();
        $build->setCollection();
        return $build->collection($res);
    }

    public function getMixPlant($sizePack) {
        
    }
    
    public function getPromotionPlantList($pack, $sizePack, $sort = Model_Api_Abstract::SORT_ID, $order= Model_Api_Abstract::ORDER_ASC) {
        $sql = 'call PLS_PLANT_LIST_PROMOTED('. $pack . ',' . $sizePack . ',"' . $sort . '", "' . $order . '" );';
        //echo $sql;

        try {
            $res = self::$db->multiQuery($sql);
           //print_r($res);
        } catch (Model_Db_Exception_NotFound $e) {            
            throw new Manager_Exception_NotFound();
        } catch (Model_Db_Exception_Unavailable $e) {
            throw new Manager_Exception_Unavailable();
        }
        if (!isset($res[0]->cpp_id) || $res[0]->cpp_id <= 0) {
            throw new Manager_Exception_NotFound();
        }
        $build = new Model_Plant_Source_Db_Mysql_Build_Plant();
        $build->setCollection();
        return $build->collection($res);
        
        
        
    }

}
