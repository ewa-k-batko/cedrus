<?php

class Model_Type_Container {

    const FILTER = 'tid';

    private $id, $title, $url;

   /*public function __construct() {
        $this->isActive = false;
        return $this;
    }*/

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

}
