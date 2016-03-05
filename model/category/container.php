<?php

class Model_Category_Container extends Model_Container_Abstract{

    const FILTER = 'cid';

    protected $url, $subCategories;    

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }
    public function getUrl() {
        return $this->url;
    }
    
    public function setSubCategories(Model_Collection $list) {
        $this->subCategories = $list;
        return $this;
    }
    public function getSubCategories() {
        return $this->subCategories;
    }  
    
    public function setter($row) {
        
    }
}
