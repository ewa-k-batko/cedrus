<?php

ini_set("display_errors", 1);
error_reporting(255);

class Formsan_Module_Import extends Module_Abstract {

    function execute() {

        // Model_Plant_Source_File_CsvAd();

        try {
            $apiCsv = new Model_Plant_Source_Api(Model_Plant_Source_Factory::FILE_CSV_AD);
            $list = $apiCsv->getData();


            $apiDB = new Model_Plant_Source_ApiAd(Model_Plant_Source_Factory::DB_MYSQL_AD);

            foreach ($list as $plant) {
                $res = $apiDB->getPlantSetAd($plant);
                
                var_dump($res);
            }




            //print_r($list);
        } catch (Exception $e) {

            echo $e->getMessage();
        }

        //@todo  ajax
        $this->template = 'Formsan/View/Import.phtml';
        parent::execute();
    }

}
