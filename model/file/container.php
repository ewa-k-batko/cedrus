<?php

class Model_File_Container {

    //const DOMAIN = 'http://www.walaszczyk.pl';

    private $id,  $url, $size, $width, $height, $extention, $parent;

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getId() {
        return $this->id;
    }
    
    public function setUrl($url) {
        
        //Azalia Narcissifora.jpg
        $this->url = $url ? $url : Manager_Config::iphotUrl() . '/a/' . $this->getId() . '.' .$this->getExtention();
        return $this;
    }
    public function getUrl() {
        if(!$this->url) {
            $this->setUrl();
        }
        return $this->url;
    }
    
    public function setSize($size) {
        $this->size = $size;
        return $this;
    }
    public function getSize() {
        return $this->size;
    }
    
    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }
    public function getHeight() {
        return $this->height;
    }
    
    public function setWidth($width) {
        $this->width = $width;
        return $this;
    }
    public function getWidth() {
        return $this->width;
    }

   public function setExtention($extention) {
        $this->extention = $extention;
        return $this;
    }
    public function getExtention() {
        return $this->extention;
    }    
    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }
    public function getParent() {
        return $this->parent;
    } 
}
