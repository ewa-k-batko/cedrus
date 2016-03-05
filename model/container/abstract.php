<?php

abstract class Model_Container_Abstract {

    protected $id, $name, $url, $isActive;

    public function __construct() {
        $this->isActive = false;
        return $this;
    }

    public function setId($id) {
        $this->id = (int)$id;
        return $this;
    }

    public function getId() {
        return ($this->id && $this->id > 0) ? $this->id : 0;
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

    public function setActive($active) {
        $this->isActive = true;
    }

    public function isActive() {
        return $this->isActive ? true : false;
    }

    public function search($name, $value, $nameIn = null, $level = 1) {
        if($level > 10) {
            throw new Exception ('searching container only in 10 level deep bound, more set');
        }
        if (property_exists(get_class($this), $name)) {
            $tmp = $this->{$name};
            if ($level == 1) {
                return $tmp == $value ? $this : false;
            }            
            if (method_exists($tmp, 'search')) {
                $level--;                
                return $level == 1 ? $tmp->search($nameIn, $value) : $tmp->search($name, $value, $nameIn, $level);
            }
        }
        return false;       
    }

    /**
     * @todo
     * @param type $row
     */
    abstract public function setter($row);
}
