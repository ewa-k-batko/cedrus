<?php

class Model_Plant_Category_Container extends Model_Container_Abstract {

    const FILTER = 'tid';
    const PATH = '/oferta/katalog/typ-';

    protected $description, $icon, $gallery, $items;
    
    public function setUrl($url = null) {
        $this->url = $url ? $url : self::PATH . Model_Tool_String::toUrl($this->getName()) . ',' . self::FILTER  . ',' . $this->getId();
        return $this;
    }
    
    public function getUrl() {
        if(!$this->url){
           $this->setUrl();
        }
        return $this->url;
    }

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
    
    public function setItems(Model_Plant_Category_Plant_Collection $items) {
        $this->items = $items;
        return $this;
    }
    public function getItems() {
        return $this->items;
    }
    
    public function setter($row) {
        
    }
}
