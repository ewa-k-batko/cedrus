<?php

class Model_Plant_Pot_Container extends Model_Container_Abstract {

    const FILTER = 'oid';

    protected $description, $color, $diameter, $height;

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }
    
    public function setColor($color) {
        $this->color = $color;
        return $this;
    }
    public function getColor() {
        return $this->color;
    }
    
    public function setDiameter($diameter) {
        $this->diameter = $diameter;
        return $this;
    }
    public function getDiameter() {
        return $this->diameter;
    }
    
    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }
    public function getHeight() {
        return $this->height;
    }
    
    public function setter($row) {
        
    }
}
