<?php

class Model_Plant_Source_Db_Mysql_Build_Plant {

    protected $collection;

    public function setCollection() {
        $this->collection = new Model_Collection();
    }
    
     public function getContainer() {
         return new Model_Plant_Container();
     }

    public function collection($res) {        
        foreach ($res as $row) {
            $plant = $this->getContainer();
            $this->collection->append($this->single($plant,$row));
        }
        return $this->collection;
    }
    
    public function getCategoryContainer() {
        return new Model_Plant_Category_Container();
    }

    public function single($plant, $row) {        
        if (isset($row->cpp_id)) {
            $plant->setId($row->cpp_id);
        }
        if (isset($row->cpp_cpc_id)) {
            $category = $this->getCategoryContainer();
            $category->setId($row->cpp_cpc_id);            
            $plant->setCategory($category);
        }
        if (isset($row->cpp_name_pl)) {
            $plant->setName($row->cpp_name_pl);
        }
        if (isset($row->cpp_name_lt)) {
            $plant->setNameLT($row->cpp_name_lt);
        }
        if (isset($row->cpp_desc)) {
            $plant->setDescription($row->cpp_desc);
        }
        if (isset($row->cpp_url)) {
            $plant->setUrl($row->cpp_url);
        }
        if (isset($row->cpp_icon)) {
            $plant->setIcon($row->cpp_icon);
        }
        return $plant;
    }

    //@todo dokonczyc
}
