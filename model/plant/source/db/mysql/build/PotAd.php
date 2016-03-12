<?php

class Model_Plant_Source_Db_Mysql_Build_PotAd extends Model_Plant_Source_Db_Mysql_Build_Pot {

    public function setCollection() {
        $this->collection = new Model_CollectionAd();
    }

    public function getContainer() {
        return new Model_Plant_Pot_ContainerAd();
    }    

    public function single($pot, $row) {

        $pot = parent::single($pot, $row);

        if (isset($row->cpt_status)) {
            $pot->setStatus($row->cpt_status);
        }

        if (isset($row->cpt_create)) {
            $pot->setDataCreate($row->cpt_create);
        }

        if (isset($row->cpt_mod)) {
            $pot->setDataUpdate($row->cpt_mod);
        }

        if (isset($row->cpt_user_create)) {
            $pot->setUserCreateId($row->cpt_user_create);
        }

        if (isset($row->cpt_user_mod)) {
            $pot->setUserUpdateId($row->cpt_user_mod);
        }        
        return $pot;
    }

}
