<?php

class Model_Plant_Source_Db_Mysql_Build_CategoryAd extends Model_Plant_Source_Db_Mysql_Build_Category {

    public function setCollection() {
        $this->collection = new Model_CollectionAd();
    }

    public function getContainer() {
        return new Model_Plant_Category_ContainerAd();
    }

    public function single($category,$row) {
        
        $category = parent::single($category,$row);
        
        if (isset($row->cpc_status)) {
            $category->setStatus($row->cpc_status);
        }

        if (isset($row->cpc_create)) {
            $category->setDataCreate($row->cpc_create);
        }

        if (isset($row->cpc_mod)) {
            $category->setDataUpdate($row->cpc_mod);
        }

        if (isset($row->cpc_user)) {
            $category->setUserCreateId($row->cpc_user);
        }

        return $category;
    }

}
