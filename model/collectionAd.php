<?php

class Model_CollectionAd extends Model_Collection implements JsonSerializable{

    public function jsonSerialize() {
        return array('count'=>$this->_total, 'list' => $this->_items);
    }
}
