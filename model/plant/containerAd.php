<?php

class Model_Plant_ContainerAd extends Model_Plant_Container implements JsonSerializable  
{
    use Model_Container_TraitAd;    
    
    public function jsonSerialize() {
        return array(
            'filter' => self::FILTER,
            'id' => $this->id,
            'category' => $this->category,
            'name' => $this->name,
            'namelt' => $this->nameLT,
            'description' => $this->description,
            'url' => $this->url,
            'icon' => $this->icon,
            'status' => $this->status,
            'dataCreate' => $this->dataCreate,
            'dataUpdate' => $this->dataUpdate,
            'userId' => $this->userCreateId); //$this;
    }
}