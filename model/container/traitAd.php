<?php

/**
 * for admin tools
 */
trait Model_Container_TraitAd  {

    private $status,
            $dataCreate,
            $dataUpdate,
            $userCreateId,
            $userUpdateId;

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
    
    public function setUserCreateId($userId) {
        $this->userCreateId = $userId ;
        return $this;
    }
    
    public function getUserCreateId() {
        return $this->userCreateId > 0 ? $this->userCreateId : 0;
    }

    public function setUserUpdateId($userId) {
        $this->userUpdateId = $userId;
        return $this;
    }
    
    public function getUserUpdateId() {
        return $this->userUpdateId > 0 ? $this->userUpdateId : 0;
    }

    public function jsonSerialize() {}

}
