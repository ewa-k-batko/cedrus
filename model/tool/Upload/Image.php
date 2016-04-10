<?php

/*
 * generate code of product by product data fields
 */

class Model_Tool_Upload_Image {

    /**
     * dir to keep waitinf to save db images 
     */
    const DIR_WAIT = '/katalog/waiting/';

    /**
     * destination dir of image  
     */
    const DIR_DESTINATION = 'katalog/fotografie/';
    const SIZE_SM = 600;
    const SIZE_RS = 460;
    const SIZE_XS = 300;

    private static $instance;

    /**
     * dir of waiting image
     * @var string 
     */
    private $dirWait;

    /**
     * src of waiting image
     * @var string 
     */
    private $srcWait;

    /**
     * dir destination
     * @var string 
     */
    private $dirDestination;

    /**
     * src of saved in db image
     * @var string 
     */
    private $srcDestination;
    private $pathDestination;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function setDir() {
        if ($this->dirWait && $this->dirDestination) {
            return;
        }

        if (Manager_Config::isDev()) {
            $this->dirWait = $_SERVER['DOCUMENT_ROOT'] . self::DIR_WAIT;
            $this->dirDestination = $_SERVER['DOCUMENT_ROOT'] . self::DIR_DESTINATION;
        } else {
            $this->dirWait = '../public/' . self::DIR_WAIT;
            $this->dirDestination = '../public/' . self::DIR_DESTINATION;
        }
    }

    private function isImageWait($icon) {
        $this->srcWait = $this->dirWait . $icon;       
        return file_exists($this->srcWait);
    }

    private function getIconByNames(Model_Plant_Container $plant) {

        return $plant->getCategory()->getId() . '/' . Model_Tool_String::toUrl($plant->getName()) . '-' . Model_Tool_String::toUrl($plant->getNameLT()) . '-' . Model_Tool_String::toUrl($plant->getSpecies());
    }

    private function copy($icon) {
        $this->srcDestination = $this->dirDestination . $icon . '-sm-' . (date('mdhis')) . '.jpg';
        return copy($this->srcWait, $this->srcDestination);
    }

    private function setResponsive() {
        $this->srcDestination = str_replace('sm', 'xs', $this->srcDestination);

        $inf = getimagesize($this->srcWait);

        $rate = ((int) $inf[0] / (int) $inf[1]);
        //echo $rate;
        if ($inf[0] == self::SIZE_SM) {
            $widthXS = self::SIZE_XS;
            $heightXS = $rate * self::SIZE_XS;

            $widthRS = self::SIZE_RS;
            $heightRS = $rate * self::SIZE_RS;
        } else {
            $heightXS = self::SIZE_XS;
            $widthXS = $rate * self::SIZE_XS;

            $heightRS = self::SIZE_RS;
            $widthRS = $rate * self::SIZE_RS;
        }

        $imgSM = imagecreatefromjpeg($this->srcWait);

        //XS
        $imgXS = imagescale($imgSM, $widthXS, $heightXS, IMG_BICUBIC_FIXED);
        imagejpeg($imgXS, $this->srcDestination);
        imagedestroy($imgXS);

        //RS
        $this->srcDestination = str_replace('xs', 'rs', $this->srcDestination);
        $imgRS = imagescale($imgSM, $widthRS, $heightRS, IMG_BICUBIC_FIXED);
        imagejpeg($imgRS, $this->srcDestination);
        imagedestroy($imgRS);

        imagedestroy($imgSM);
    }

    private function getName() {
        return mb_substr($this->srcDestination, strrpos($this->srcDestination, '/') + 1, -4, 'UTF-8');
    }

    private function setName($src) {
        return $this->dirDestination . $src . '.jpg';
    }

    public function replaceIcon(Model_Plant_Container $plant, $srcDate) {

        $this->setDir();
        $srcDate = $this->dirDestination . $plant->getCategory()->getId() . '/' . $srcDate . '.jpg';
        $srcId = $this->dirDestination . $plant->getCategory()->getId() . '/' . $plant->getIcon() . '.jpg';
        @rename($srcDate, $srcId);
        @rename(str_replace('sm', 'xs', $srcDate), str_replace('sm', 'xs', $srcId));
        @rename(str_replace('sm', 'rs', $srcDate), str_replace('sm', 'rs', $srcId));
    }

    public function setPathDestination() {
        $this->pathDestination = '/' . self::DIR_DESTINATION;
    }

    public function getPathDestination() {
        if (!$this->pathDestination) {
            $this->setPathDestination();
        }
        return $this->pathDestination;
    }
    
    public static function isImage($path) { 
         if (Manager_Config::isDev()) {
            return file_exists($_SERVER['DOCUMENT_ROOT'] . $path);
        } else {
            return file_exists('../public/' .$path);
        }
    }

    /**
     * 
     * @param Model_Plant_Container $plant
     * @return \Model_Plant_Container
     */
    public function save(Model_Plant_Container $plant) {
        if (!$plant->getIcon()) {
            return $plant;
        }

        $this->setDir();

        if (!$this->isImageWait($plant->getIcon())) {
            $plant->setIcon(null);
            return $plant;
        }
        $icon = $this->getIconByNames($plant);
        if ($this->copy($icon)) {
            $plant->setIcon($this->getName());
            $this->setResponsive();
        }
        return $plant;
    }

}
