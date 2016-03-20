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
            $this->collection->append($this->single($category, $row));
        }
        return $this->collection;
    }

    public function single($category, $row) {
        
        if (isset($row->cpc_id)) {
            $category->setId($row->cpc_id);
        }
        if (isset($row->cpp_cpc_id)) {
            $category->setId($row->cpp_cpc_id);
        }
        if (isset($row->cpc_name)) {
            $category->setName($row->cpc_name);
        }
        if (isset($row->cpc_desc)) {
            $category->setDescription($row->cpc_desc);
        }
        if (isset($row->cpc_gal_id)) {
            $gallery = new Model_Gallery_Container();
            $gallery->setId($row->cpc_gal_id);
            $category->setGallery($gallery);
        }

        if (isset($row->cpc_icon)) {
            $category->setIcon($row->cpc_icon);
        }

        if (isset($row->cpp_id)) {
            $list = new Model_Plant_Category_Plant_Collection();
            if (isset($row->cnt)) {
                $list->setSummaryItems($row->cnt);
            }
            $build = new Model_Plant_Source_Db_Mysql_Build_Plant();
            $plant = $build->getContainer();
            $build->single($plant, $row);
            $list->append($plant);
            $category->setItems($list);
        }        
        return $category;
    }

    //@todo dokonczyc
}
