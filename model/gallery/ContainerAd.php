<?php

class Model_Gallery_ContainerAd extends Model_Gallery_Container implements JsonSerializable  
{
    use Model_Container_TraitAd;    

    public function jsonSerialize() {
        return array(
            'filter' => self::FILTER,
            'id' => $this->id,
            //'gallery' => $this->gallery,
            'name' => $this->name,
           // 'description' => $this->description,
            'url' => $this->url,
            //'icon' => $this->icon,
            //'status' => $this->status,
            'dataCreate' => $this->dataCreate,
            'dataUpdate' => $this->dataUpdate,
            'userCreateId' => $this->userCreateId,
            'userModId' => $this->userModId); //$this;
    }

}
