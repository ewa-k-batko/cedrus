<?php

class Model_Gallery_Container {

    const FILTER = 'gid';

    private $id, $category, $name, $url, $items;

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

    public function setCategory(Model_Category_Container $category) {
        $this->category = $category;
        return $this;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setItems(Model_Collection $items) {
        $this->items = $items;
        return $this;
    }

    public function getItems() {
        if (!$this->items) {
            $this->items = new Model_Collection();
        }
        return $this->items;
    }

}
