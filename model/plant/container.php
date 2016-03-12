<?php

class Model_Plant_Container extends Model_Container_Abstract {

    
    const PATH = '/oferta/katalog/roslina-';
    const FILTER = 'pid';
    const CURRENCY = 'zł';   
     

    protected $isnNo, $category, $gallery, $pot, $nameLT,  $description,  $icon, $price, $genus, $species, $height, $heightMax, $periodBloom, $periodSow;
  
    public function setIsnNo($isnNo) {
        $this->isnNo = $isnNo;
        return $this;
    }
    public function getIsnNo() {
        return $this->isnNo;
    }
    
    public function setCategory(Model_Plant_Category_Container $category) {
        $this->category = $category;
        return $this;
    }
    public function getCategory() {
        return $this->category; 
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
    
     public function setPot(Model_Plant_Pot_Container $pot) {
        $this->pot = $pot;
        return $this;
    }
    public function getPot() {
        return $this->pot;
    }
    
    public function setNameLT($name) {
        $this->nameLT = $name;
        return $this;
    }
    public function getNameLT() {
        return $this->nameLT;
    }
    
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    } 

    public function setUrl($url = null) {
        $this->url = $url ? $url : self::PATH . Model_Tool_String::toUrl($this->getName()) . ',' . self::FILTER  . ',' . $this->getId(). ',' . Model_Plant_Category_Container::FILTER  . ',' . $this->getCategory()->getId();
        return $this;
    }
    public function getUrl() {
        if(!$this->url){
           $this->setUrl();
        }
        return $this->url;
    }
    
    public function setIcon($icon) {
        $this->icon = $icon;
        return $this;
    }
    public function getIcon() {
        return $this->icon;
    }
    
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }
    public function getPrice() {
        return $this->price;
    }
    
    public function setGenus($genus) {
        $this->genus = $genus;
        return $this;
    }
    public function getGenus() {
        return $this->genus;
    }
    
    public function setSpecies($species) {
        $this->species = $species;
        return $this;
    }
    public function getSpecies() {
        return $this->species;
    }
    
    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }
    public function getHeight() {
        return $this->height;
    }
    
    public function setHeightMax($heightMax) {
        $this->heightMax = $heightMax;
        return $this;
    }
    public function getHeightMax() {
        return $this->heightMax;
    }
    
    public function setPeriodBloom($periodBloom) {
        $this->periodBloom = $periodBloom;
        return $this;
    }
    public function getPeriodBloom() {
        return $this->periodBloom;
    }
    
    public function setPeriodSow($periodSow) {
        $this->periodSow = $periodSow;
        return $this;
    }
    public function getPeriodSow() {
        return $this->periodSow;
    }    
    public function setter($row){}

}
