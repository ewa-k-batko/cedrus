<?php

class Model_File_Container {

    //const DOMAIN = 'http://www.walaszczyk.pl';

    protected $id, $name, $url, $urlResponsive, $size, $width, $height, $extention; //, $parent;

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

        //Azalia Narcissifora.jpg
        $this->url = $url ? $url : Manager_Config::iphotUrl() . '/a/' . $this->getId() . '.' . $this->getExtention();
        return $this;
    }

    public function getUrl() {
        if (!$this->url) {
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

    /* public function setParent($parent) {
      $this->parent = $parent;
      return $this;
      }
      public function getParent() {
      return $this->parent;
      } */

    public function setUrlResponsive($path, $callback) {
        
        $srcResponsive = array('sm' => $path, 'xs' => str_replace('sm', 'xs', $path), 'rs' => str_replace('sm', 'rs', $path));

        foreach ($srcResponsive as $threshold => $src) {
            if ( call_user_func_array($callback, array($src))) {                
                $this->urlResponsive[$threshold] = $src;
            }
        }
        
        return $this;
    }

    public function getUrlResponsive($json = false) {
        if($json){
            return htmlentities(json_encode($this->urlResponsive), ENT_QUOTES, 'UTF-8');
        }
        return $this->urlResponsive;
    }

}
