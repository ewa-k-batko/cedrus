<?php

class Model_Link_Container {

    const ACTIVE_NAME = 'active';

    private $id, $title, $url, $class, $isActive, $isRoot;

    public function __construct() {
        $this->isActive = false;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setClass($class) {
        $this->class = $class;
        return $this;
    }

    public function getClass() {
        return $this->class;
    }

    public function setActive($active) {
        if ($this->class == $active) {
            $this->class .= ' ' . self::ACTIVE_NAME;
            $this->isActive = true;
        }
        return $this->class;
    }

    public function isActive() {
        return $this->isActive;
    }

    public function setRoot($root = true) {
        $this->isRoot = $root ? $root : false;
        return $this;
    }

    public function isRoot() {
        return $this->isRoot;
    }

    public function search($name, $value) {
        return $this->{$name} == $value ? $this : false;
    }

    /**
     * @todo
     * @param type $row
     */
    public function setter($row) {
        
    }

}
