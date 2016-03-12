<?php

class Model_Plant_Category_Container extends Model_Container_Abstract {

    const FILTER = 'sid';

    protected $description, $icon, $gallery;

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
    
    public function setGallery(Model_Gallery_Container $gallery) {
        $this->gallery = $gallery;
        return $this;
    }
    public function getGallery() {
        if(!$this->gallery) {
           $this->gallery = new Model_Gallery_Container(); 
        }
        return $this->gallery;
    }
}
