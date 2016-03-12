<?php

class Model_Plant_Source_Db_Mysql_Build_Pot {

    protected $collection;

    public function setCollection() {
        $this->collection = new Model_Collection();
    }

    public function getContainer() {
        return new Model_Plant_Pot_Container();
    }

    public function collection($res) {
        foreach ($res as $row) {
            $pot = $this->getContainer();
            $this->collection->append($this->single($pot, $row));
        }
        return $this->collection;
    }

    public function single($pot, $row) {
        if (isset($row->cpt_id)) {
            $pot->setId($row->cpt_id);
        }
        if (isset($row->cpt_name)) {
            $pot->setName($row->cpt_name);
        }
        if (isset($row->cpt_desc)) {
            $pot->setDescription($row->cpt_desc);
        }
        if (isset($row->cpt_color)) {
            $pot->setColor($row->cpt_color);
        }
        if (isset($row->cpt_height)) {
            $pot->setHeight($row->cpt_height);
        }
        if (isset($row->cpt_diameter)) {
            $pot->setDiameter($row->cpt_diameter);
        }
        return $pot;
    }

    //@todo dokonczyc
}
