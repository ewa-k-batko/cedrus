<?php

class Model_Plant_Category_ContainerAd extends Model_Plant_Category_Container implements JsonSerializable  
{
    use Model_Container_TraitAd;
    
    
    /*privatuse Model_Container_TraitAde $status,
            $dataCreate,
            $dataUpdate,
            $userId;

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }
    public function getStatus() {
        return $this->status;
    }

    public function setDataCreate($dataCreate) {
        $this->dataCreate = $dataCreate;
        return $this;
    }
    
    public function getDataCreate($dataCreate) {
        return $this->dataCreate;
    }

    public function setDataUpdate($dataUpdate) {
        $this->dataUpdate = $dataUpdate;
        return $this;
    }
    
    public function getDataUpdate() {
        return $this->dataUpdate;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }
    
    public function getUserId() {
        return $this->userId;
    }*/

    public function jsonSerialize() {
        return array(
            'filter' => self::FILTER,
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'icon' => $this->icon,
            'status' => $this->status,
            'dataCreate' => $this->dataCreate,
            'dataUpdate' => $this->dataUpdate,
            'userId' => $this->userCreateId); //$this;
    }

}
