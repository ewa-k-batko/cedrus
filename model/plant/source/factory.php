<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Plant_Source_Factory {

    const FILE_CSV = 'csv';
    const FILE_CSV_AD = 'csv-ad';
    const DB_MYSQL = 'mysql';
    const DB_MYSQL_AD = 'mysql-ad';
    const DB_MYSQL_CSV = 'mysql-csv';
    
    public static function getSource($source = self::DB_MYSQL) {
            switch($source){
               case self::FILE_CSV:
                   return Model_Plant_Source_File_Csv::getInstance();
                   break;
               case self::FILE_CSV_AD:
                   return Model_Plant_Source_File_CsvAd::getInstance();
                   break;
               case self::DB_MYSQL_CSV:
                   return Model_Plant_Source_Db_MysqlCsv::getInstance();
                   break;
               case self::DB_MYSQL_AD:
                    return Model_Plant_Source_Db_MysqlAd::getInstance();
                   break;               
                case self::DB_MYSQL:
                default:
                    return Model_Plant_Source_Db_Mysql::getInstance();                   
                    break;
            }

        
    }

}
