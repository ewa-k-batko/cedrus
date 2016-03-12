<?php

class Model_Plant_Source_Db_Mysql_Build_Stuff {

    protected $collection;

    public function setCollection() {
        $this->collection = new Model_Collection();
    }

    public function getContainer() {
        return new Model_Stuff_Container();
    }

    public function collection($res) {
        foreach ($res as $row) {
            $category = $this->getContainer();
            $this->collection->append($this->single($category, $row));
        }
        return $this->collection;
    }

    public function single($stuff, $row) {
        if (isset($row->csf_id)) {
            $stuff->setId($row->csf_id);
        }
        if (isset($row->csf_name)) {
            $stuff->setName($row->csf_name);
        }
        if (isset($row->csf_desc)) {
            $stuff->setDescription($row->csf_desc);
        }        

        if (isset($row->csf_type)) {
            $stuff->setType($row->csf_type);
        }
        return $stuff;
    }

    //@todo dokonczyc
}
