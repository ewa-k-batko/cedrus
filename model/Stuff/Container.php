<?php

class Model_Stuff_Container extends Model_Container_Abstract{

    const FILTER = 'sid';

    protected $type, $description;
    //$subCategories;    

    public function setType($type) {
        $this->type = $type;
        return $this;
    }
    public function getType() {
        return $this->type;
    }
    
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }
    
   /* public function setSubCategories(Model_Collection $list) {
        $this->subCategories = $list;
        return $this;
    }
    public function getSubCategories() {
        return $this->subCategories;
    } */ 
    
    public function setter($row) { }
}
