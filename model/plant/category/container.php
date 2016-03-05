<?php

class Model_Plant_Category_Container extends Model_Category_Container {

    const FILTER = 'sid';

    protected $description, $icon;

     public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }
    
    public function setIcon($icon) {
        $this->icon = $icon;
        return $this;
    }
    public function getIcon() {
        return $this->icon;
    }
}
