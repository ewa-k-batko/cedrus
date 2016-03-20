<?php

class Model_Plant_Category_Plant_Collection extends Model_Collection {
    
    private $summaryItems;
    
    public function append(Model_Plant_Container $object) {
        $id = parent::append($object);
        return $id;
    }
    
    public function setSummaryItems($summaryItems) {
        $this->summaryItems = $summaryItems;
        return $this;
    }
    
    public function getSummaryItems() {
        return $this->summaryItems;
    }

}
