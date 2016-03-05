<?php

class Model_Plant_Source_Db_Mysql_Build_Category {

    protected $collection;

    public function setCollection() {
        $this->collection = new Model_Collection();
    }
    
     public function getContainer() {
         return new Model_Plant_Category_Container();
     }

    public function collection($res) {        
        foreach ($res as $row) {
            $category = $this->getContainer();
            $this->collection->append($this->single($category,$row));
        }
        return $this->collection;
    }

    public function single($category,$row) {        
        if (isset($row->cpc_id)) {
            $category->setId($row->cpc_id);
        }
        if (isset($row->cpc_name)) {
            $category->setName($row->cpc_name);
        }
        if (isset($row->cpc_desc)) {
            $category->setDescription($row->cpc_desc);
        }
        if (isset($row->cpc_url)) {
            $category->setUrl($row->cpc_url);
        }
        if (isset($row->cpc_icon)) {
            $category->setIcon($row->cpc_icon);
        }
        return $category;
    }

    //@todo dokonczyc
}
