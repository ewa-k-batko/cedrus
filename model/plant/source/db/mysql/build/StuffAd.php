<?php

class Model_Plant_Source_Db_Mysql_Build_StuffAd extends Model_Plant_Source_Db_Mysql_Build_Stuff {

    public function setCollection() {
        $this->collection = new Model_CollectionAd();
    }

    public function getContainer() {
        return new Model_Stuff_ContainerAd();
    }

    public function single($stuff,$row) {
        
        $stuff = parent::single($stuff,$row);
        
        if (isset($row->csf_status)) {
            $stuff->setStatus($row->csf_status);
        }

        if (isset($row->csf_create)) {
            $stuff->setDataCreate($row->csf_create);
        }

        if (isset($row->csf_mod)) {
            $stuff->setDataUpdate($row->csf_mod);
        }

        if (isset($row->csf_user)) {
            $stuff->setUserCreateId($row->csf_user);
        }

        return $stuff;
    }

}
