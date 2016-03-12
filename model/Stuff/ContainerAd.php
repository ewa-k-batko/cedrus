<?php

class Model_Stuff_ContainerAd extends Model_Stuff_Container implements JsonSerializable  
{
    use Model_Container_TraitAd; 

    public function jsonSerialize() {
        return array(
            'filter' => self::FILTER,
            'id' => $this->id,            
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'type' => $this->type,
            'status' => $this->status,
            'dataCreate' => $this->dataCreate,
            'dataUpdate' => $this->dataUpdate,
            'userId' => $this->userCreateId); //$this;
    }

}
