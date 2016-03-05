<?php

class Model_Gallery_Photo_Container extends Model_Container_Abstract {

    private $description, $file, $mask;

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setFile(Model_File_Container $file) {
        $this->file = $file;
        return $this;
    }

    public function getFile() {
        if (!$this->file) {
            $this->file = new Model_File_Container();
        }
        return $this->file;
    }

    public function setter($row) {
        
    }

}
