<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Plant_Source_File_CsvAd implements Model_Plant_Source_Interface {

    private static $hand;
    private static $instance;

    private function __construct() {
        //self::$hand = fopen($_SERVER['DOCUMENT_ROOT'] . 'baza_produktow.csv', "r");
        
        //self::$hand = fopen($_SERVER['DOCUMENT_ROOT'] . 'katalog/katalog.csv', "r");
    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self( );
        }
        return self::$instance;
    }

    public function __destruct() {
        if (is_resource(self::$hand)) {
            fclose(self::$hand);
        }
    }

    public function getData() {

        $list = new Model_Collection();       
        
        //if (is_resource(self::$hand)) {
        
        //echo $_SERVER['DOCUMENT_ROOT'];exit;$_SERVER['DOCUMENT_ROOT'] .
        
        if (Manager_Config::isDev()) {
            $csv = new SplFileObject( $_SERVER['DOCUMENT_ROOT'].'katalog/katalog.csv','r');
        }else {
            $csv = new SplFileObject( '../public/katalog/katalog.csv','r');
        }
           
            
            
            
            
            $csv->setFlags(SplFileObject::READ_CSV);
            
            $codeTool =  new Model_Tool_Code();
            
         $i = 0;
            
                //foreach ($file as $data) {
            while (!$csv->eof()) {
                
                   $i++;            
              
                
                 //echo 9;exit;
                $data = $csv->fgetcsv( ';', "\n", "\\");
                 
                
                if($data[0] == 'L.p'){
                    continue;
                } 
                
                if(!isset($data[11]) || count($data) != 12) {
                    continue;
                }                
                  
                $plant = new Model_Plant_ContainerAd();

                //$category = new Model_Plant_Category_ContainerAd();
               // $category->setId($data[1]);
                
                //$plant->setIsnNo($data[1]);
                $plant->setName($data[2]);
                
                $plant->setSpecies($data[3]);
                
                $status = 'D';
                if($data[4] == 'D'){
                    $status = 'A';                    
                }elseif($data[4] == 'P'){
                    $status = 'P';
                }
                
                $plant->setStatus( $status);
                 $plant->setNameLT($data[5]);
                 $plant->setDescription($data[6]);
                 
                 $plant->setIcon(str_replace('zdjcia\\','',$data[7]));
                 
                // pr($plant);exit;
                 
                 //foto
                // $plant->setDescription($data[6]);
                 
                 $plant->setHeight($data[8]);
                 
                 $pot = new Model_Plant_Pot_ContainerAd();
                 $pot->setId($this->getPotId($data[9]));
                 $plant->setPot($pot);
                 $plant->setPrice($data[10]);
                 
                 
                 $category = new Model_Plant_Category_Container();
                    $category->setId($data[11]);
                    $plant->setCategory($category);
                    
                    $no = $codeTool->getCode($data);
                    
                    echo($no) . '<br>';
                    
                   // $no = date('ym').'/'.$data[11].'/'.$this->getSigns($data[2]).'/'.$this->getSigns($data[3]).'/'.$this->getSigns($data[5]).'/'.$i;
                    
                    //echo $no;
                    $plant->setIsnNo($no);/**/
                 
                 
                 /////////
                
               /* $plant->setCategory($category);
                $plant->setId($data[3]);
                
                $plant->setSpecies($data[5]);
                $plant->setGenus($data[6]);
                $plant->setPrice($data[7]);
                $plant->setHeight($data[8]);

                $pot = new Model_Plant_Pot_Container();
                $pot->setDiameter($data[9]);
                $pot->setHeight($data[10]);
                $plant->setPot($pot);

                $plant->setHeightMax($data[11]);
                $plant->setPeriodBloom($data[12]);
                $plant->setPeriodSow($data[13]);*/

                /*$items = new Model_Collection();

                //foto child
                $photo = new Model_Gallery_Photo_Container();
                $file = new Model_File_Container();
                $file->setUrl($data[6]);
                $photo->setFile($file);
                $items->append($photo);*/

                /*//foto adult
                $photo = new Model_Gallery_Photo_Container();
                $file = new Model_File_Container();
                $file->setUrl($data[15]);
                $photo->setFile($file);
                $items->append($photo);*/

                /*$gallery = new Model_Gallery_Container();
                $gallery->setItems($items);
                $plant->setGallery($gallery);*/
                
                
                $list->append($plant);
            }
           // exit;
          // pr($list);exit;
            //fclose(self::$hand);
        //}
          
        return $list;
    }

    public function getPlantById($id) {
        //$plant = new Model_Plant_Container();
        if (is_resource(self::$hand)) {
            while (($row = fgetcsv(self::$hand, 1000, ";")) !== FALSE) {
                if ($row[3] == $id) {
                    $plant = self::buildPlant($row);
                }
            }
            fclose(self::$hand);
        }
        return isset($plant) ? $plant : null;
    }

    public function getPlantListByCategoryId($id, $pack, $sizePack, $sort = Model_Api_Abstract::SORT_ID, $order= Model_Api_Abstract::ORDER_ASC) {
        $list = new Model_Collection();
        if (is_resource(self::$hand)) {
            while (($row = fgetcsv(self::$hand, 1000, ";")) !== FALSE) {
                if ($row[1] == $id) {
                    $list->append(self::buildPlant($row));
                }
            }
            fclose(self::$hand);
        }
        return $list;
    }

    public function getMixPlant($sizePack) {
        
    }

    public static function buildPlant($row) {
        $plant = new Model_Plant_Container();

        $category = new Model_Plant_Category_Container();
        $category->setId(trim($row[1]));
        $plant->setCategory($category);
        $plant->setId($row[3]);
        $plant->setName(trim($row[4]));
        $plant->setSpecies($row[5]);
        $plant->setGenus($row[6]);
        $plant->setPrice($row[7]);
        $plant->setHeight($row[8]);

        $pot = new Model_Plant_Pot_Container();
        $pot->setDiameter($row[9]);
        $pot->setHeight($row[10]);
        $plant->setPot($pot);

        $plant->setHeightMax($row[11]);
        $plant->setPeriodBloom($row[12]);
        $plant->setPeriodSow($row[13]);

        $items = new Model_Collection();

        //foto child
        $photo = new Model_Gallery_Photo_Container();
        $file = new Model_File_Container();
        $file->setUrl($row[14]);
        $photo->setFile($file);
        $items->append($photo);

        //foto adult
        $photo = new Model_Gallery_Photo_Container();
        $file = new Model_File_Container();
        $file->setUrl($row[15]);
        $photo->setFile($file);
        $items->append($photo);


        $gallery = new Model_Gallery_Container();
        $gallery->setItems($items);
        $plant->setGallery($gallery);
        return $plant;
    }
    
    public function getPromotionPlantList($pack, $sizePack, $sort = Model_Api_Abstract::SORT_ID, $order= Model_Api_Abstract::ORDER_ASC) {
        
    }

    private function buildListPlant($row) {
        //$list = new Model_Collection();
    }
    
    private function getPotId($name){
        
        $tmp = array('P13' => '1');
        
        return $tmp[$name];
    }
    
    private function getCategoryId($name){
        
        $tmp = array('P13' => '1');
        
        return $tmp[$name];
    }    

}
