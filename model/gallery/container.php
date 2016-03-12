<?php

class Model_Gallery_Container extends Model_Container_Abstract {

    const FILTER = 'gid';

    protected $description, $stuff, $items;

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setStuff(Model_Stuff_Container $stuff) {
        $this->stuff = $stuff;
        return $this;
    }

    public function getStuff() {
        return $this->stuff;
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

    public function setter($row) {
        
    }

}
