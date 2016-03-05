<?php

class Model_Plant_Pot_Container {

    const FILTER = 'oid';

    private $id, $name, $url, $price, $width, $height;

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    public function getName() {
        return $this->name;
    } 

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }
    public function getUrl() {
        return $this->url;
    }
    
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }
    public function getPrice() {
        return $this->price;
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

}
