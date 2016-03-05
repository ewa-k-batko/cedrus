<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.Manager_Config::dbCnf()
 */

class Model_Plant_Source_Db_MysqlAd extends Model_Plant_Source_Db_Mysql {

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

    public function getCategoryList($pack, $sizePack, $sort, $order) {

        $sql = 'call PL_CAT_LIST_ALL(' . $pack . ',' . $sizePack . ',"' . $sort . '", "' . $order . '" );';
        //echo $sql;

        try {
            $res = self::$db->multiQuery($sql);
        } catch (Model_Db_Exception_NotFound $e) {
            throw new Manager_Exception_NotFound();
        } catch (Model_Db_Exception_Unavailable $e) {
            throw new Manager_Exception_Unavailable();
        }
        if (!isset($res[0]->cpc_id) || $res[0]->cpc_id <= 0) {
            throw new Manager_Exception_NotFound();
        }
        $build = new Model_Plant_Source_Db_Mysql_Build_CategoryAd();
        $build->setCollection();
        return $build->collection($res);
    }

    public function getCategoryByIdAd($id) {
        $sql = 'call PL_CAT_BY_ID(' . $id . ' );';
        //echo $sql;

        try {
            $res = self::$db->multiQuery($sql);

            // print_r($res);
        } catch (Model_Db_Exception_NotFound $e) {
            throw new Manager_Exception_NotFound();
        } catch (Model_Db_Exception_Unavailable $e) {
            throw new Manager_Exception_Unavailable();
        }
        if (!isset($res[0]->cpc_id) || $res[0]->cpc_id <= 0) {
            throw new Manager_Exception_NotFound();
        }
        $build = new Model_Plant_Source_Db_Mysql_Build_CategoryAd();
        $category = $build->getContainer();
        return $build->single($category, $res[0]);
    }

    public function getCategoryUpdateAd(Model_Plant_Category_ContainerAd $category) {
        $sql = 'call PL_CAT_UPDATE(' . $category->getId() .
                ',"' . $category->getName() .
                '", "' . $category->getDescription() .
                '","' . $category->getUrl() .
                '", "' . $category->getIcon() .
                '", "' . $category->getStatus() .
                '", ' . $category->getUserUpdateId() .
                ' );';
        //echo $sql;
        try {
            $res = self::$db->multiQuery($sql);

            var_dump($res);
        } catch (Model_Db_Exception_NotFound $e) {
            throw new Manager_Exception_NotFound();
        } catch (Model_Db_Exception_Unavailable $e) {
            throw new Manager_Exception_Unavailable();
        }
        var_dump($res);
    }

    public function getCategoryAddAd(Model_Plant_Category_ContainerAd $category) {
        $sql = 'call PL_CAT_ADD("' . $category->getName() .
                '", "' . $category->getDescription() .
                '","' . $category->getUrl() .
                '", "' . $category->getIcon() .
                '", "' . $category->getStatus() .
                '", ' . $category->getUserCreateId() .
                ' );';
        echo $sql;
        try {
            $res = self::$db->multiQuery($sql);

            var_dump($res);
        } catch (Model_Db_Exception_NotFound $e) {
            throw new Manager_Exception_NotFound();
        } catch (Model_Db_Exception_Unavailable $e) {
            throw new Manager_Exception_Unavailable();
        }
        var_dump($res);
    }

    public function getPlantListAd($pack, $sizePack, $sort, $order) {

        $sql = 'call PL_PLANT_LIST_ALL(' . $pack . ',' . $sizePack . ',"' . $sort . '", "' . $order . '" );';
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
        $build = new Model_Plant_Source_Db_Mysql_Build_PlantAd();
        $build->setCollection();
        return $build->collection($res);
    }

    public function getPlantByIdAd($id) {
        $sql = 'call PL_PLANT_BY_ID(' . $id . ' );';
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
        $build = new Model_Plant_Source_Db_Mysql_Build_PlantAd();
        $plant = $build->getContainer();
        return $build->single($plant, $res[0]);
    }

    public function getPlantSetAd(Model_Plant_ContainerAd $plant) {
        $sql = 'call PL_PLANT_SET(' . $plant->getId() .
                ',' . $plant->getCategory()->getId() .
                ',"' . $plant->getName() .
                '","' . $plant->getNameLT() .
                '", "' . $plant->getDescription() .
                '","' . $plant->getUrl() .
                '", "' . $plant->getIcon() .
                '", "' . $plant->getStatus() .
                '", ' . $plant->getUserCreateId() .
                ' );';
        // echo $sql;
        try {
            $res = self::$db->multiQuery($sql);
            return $res;
            //var_dump($res);
        } catch (Model_Db_Exception_NotFound $e) {
            throw new Manager_Exception_NotFound();
        } catch (Model_Db_Exception_Unavailable $e) {
            throw new Manager_Exception_Unavailable();
        }
        //var_dump($res);
    }

}
