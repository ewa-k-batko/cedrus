<?php

class Model_Plant_Source_Db_Mysql_Build_PlantAd extends Model_Plant_Source_Db_Mysql_Build_Plant {

    public function setCollection() {
        $this->collection = new Model_CollectionAd();
    }

    public function getContainer() {
        return new Model_Plant_ContainerAd();
    }
    
    public function getCategoryContainer() {
        return new Model_Plant_Category_ContainerAd();
    }

    public function single($plant, $row) {

        $plant = parent::single($plant, $row);

        if (isset($row->cpp_status)) {
            $plant->setStatus($row->cpp_status);
        }

        if (isset($row->cpp_create)) {
            $plant->setDataCreate($row->cpp_create);
        }

        if (isset($row->cpp_mod)) {
            $plant->setDataUpdate($row->cpp_mod);
        }

        if (isset($row->cpp_user_create)) {
            $plant->setUserCreateId($row->cpp_user_create);
        }

        if (isset($row->cpp_user_mod)) {
            $plant->setUserUpdateId($row->cpp_user_mod);
        }        
        return $plant;
    }

}
