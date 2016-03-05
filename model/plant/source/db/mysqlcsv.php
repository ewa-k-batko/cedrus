<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Plant_Source_Db_MysqlCsv implements Model_Plant_Source_Interface {

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

    private function getCsv() {
        $sid = 3;
        $sql = 'call CSV(' . $sid . ' );';
        $res = self::$db->multiQuery($sql);
        if (isset($res[0]->p_data)) {
            return $res[0]->p_data;
        }
        throw new Model_Exception_NotFound();
    }

    public function getPlantById($id) {
        $data = $this->getCsv();
        $data = str_getcsv($data, "|");
        foreach ($data as $row) {
            $row = str_getcsv($row, ";");
            if (isset($row[3]) && $row[3] == $id) {
                $plant = Model_Plant_Source_File_Csv::buildPlant($row);
            }
        }
        return $plant;
    }

    public function getCategoryPlantsById($id, $pack, $sizePack) {
        $list = new Model_Collection();  
        $data = $this->getCsv();
        $data = str_getcsv($data, "|");
        foreach ($data as $row) {
            $row = str_getcsv($row, ";");
            if (isset($row[1]) && $row[1] == $id) {
                $list->append(Model_Plant_Source_File_Csv::buildPlant($row));
            }
        }
        return $list;
    }

    public function getMixPlant($sizePack) {
        
    }

}
