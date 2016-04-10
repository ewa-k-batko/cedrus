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
            $this->collection->append($this->single($plant, $row));
        }
        return $this->collection;
    }

    public function getCategoryContainer() {
        return new Model_Plant_Category_Container();
    }

    public function getGalleryContainer() {
        return new Model_Gallery_Container();
    }

    public function getPotContainer() {
        return new Model_Plant_Pot_Container();
    }

    public function single($plant, $row) {
        if (isset($row->cpp_id)) {
            $plant->setId($row->cpp_id);
        }
        if (isset($row->cpp_no_isn)) {
            $plant->setIsnNo($row->cpp_no_isn);
        }
        if (isset($row->cpp_cpc_id)) {
            $category = $this->getCategoryContainer();
            $category->setId($row->cpp_cpc_id);
            if(isset($row->cpc_name)){
                $category->setName($row->cpc_name);
            }            
            $plant->setCategory($category);
        }
        if (isset($row->cpp_gal_id)) {
            $gallery = $this->getGalleryContainer();
            $gallery->setId($row->cpp_gal_id);
            $plant->setGallery($gallery);
        }
        if (isset($row->cpp_pot_id)) {
            $pot = $this->getPotContainer();
            $pot->setId($row->cpp_pot_id);
            if (isset($row->cpt_name)) {
                $pot->setName($row->cpt_name);
            }
            $plant->setPot($pot);
        }
        if (isset($row->cpp_name_pl)) {
            $plant->setName($row->cpp_name_pl);
        }
        if (isset($row->cpp_name_lt)) {
            $plant->setNameLT($row->cpp_name_lt);
        }
        if (isset($row->cpp_species)) {
            $plant->setSpecies($row->cpp_species);
        }
        if (isset($row->cpp_desc)) {
            $plant->setDescription($row->cpp_desc);
        }
        if (isset($row->cpp_height)) {
            $plant->setHeight($row->cpp_height);
        }        
        if (isset($row->cpp_price)) {
            $plant->setPrice($row->cpp_price);
        }
        if (isset($row->cpp_icon) && $row->cpp_icon) {
            $plant->setIcon($row->cpp_icon);
            
            $items = new Model_Collection();
            //foto child
            $photo = new Model_Gallery_Photo_Container();
            $photo->setName($plant->getName());
            $file = new Model_File_Container();
            $file->setId( $plant->getIcon());
            $imgUpload = Model_Tool_Upload_Image::getInstance();
            $path = $imgUpload->getPathDestination() . $plant->getCategory()->getId() . '/' . $plant->getIcon() . '.jpg';            
            if($path) {
              $file->setUrlResponsive($path, 'Model_Tool_Upload_Image::isImage');  
            }
            
            $photo->setFile($file);
            $items->append($photo);

            $gallery = new Model_Gallery_Container();
            $gallery->setItems($items);
            $plant->setGallery($gallery);
        }
        
        //print_r($plant);//exit;
        return $plant;
    }

    //@todo dokonczyc
}
