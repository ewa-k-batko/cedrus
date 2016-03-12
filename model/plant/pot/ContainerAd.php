<?php

class Model_Plant_Pot_ContainerAd extends Model_Plant_Pot_Container implements JsonSerializable {

    use Model_Container_TraitAd;

    public function jsonSerialize() {
        return array(
            'filter' => self::FILTER,
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->color,
            'height' => $this->height,
            'diameter' => $this->diameter,
            'status' => $this->status,
            'dataCreate' => $this->dataCreate,
            'dataUpdate' => $this->dataUpdate,
            'userCreateId' => $this->userCreateId,
            'userUpdateId' => $this->userUpdateId); //$this;
    }

}
