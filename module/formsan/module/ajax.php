<?php

class Formsan_Module_Ajax extends Module_Abstract {

    private $api;
    
    //http://stackoverflow.com/questions/5507234/how-to-use-basic-auth-with-jquery-and-ajax

    function execute() {
        if (!$this->request->isAjax()) {
            return;
        }

        //formsanajax/model,t,category-list
        //$type = $this->request->get('t', 's');
        try {
            $params = json_decode(file_get_contents('php://input'));

            if (!isset($params->mdl)) {
                return;
            }

            $this->api = new Model_Plant_Source_ApiAd(Model_Plant_Source_Factory::DB_MYSQL_AD);
            $method = 'get' . $params->mdl . 'Ad';


            if (method_exists($this, $method)) {
                call_user_func(array($this, $method), $params);
            } else {
                $this->out['ajax'] = array('err' => 1, 'message' => 'empty');
            }
        } catch (Exception $e) {

            $this->out['ajax'] = array('err' => 2, 'message' => $e->getMessage());
        }

        $this->template = 'Formsan/View/Common/Ajax.phtml';
        parent::execute();
    }

    private function getCategoryListAd($params) {
        //@todo do params
        $this->out['ajax'] = array('res' => 1, 'rows' => $this->api->getCategoryList($pack = 1, $sizePack = 20, $sort = Model_Api_Abstract::SORT_NAME, $order = Model_Api_Abstract::ORDER_ASC));
    }

    private function getCategoryByIdAd($params) {
        //@todo do params        

        $this->out['ajax'] = array('res' => 1, 'rows' => $this->api->getCategoryByIdAd($params->param->id));
    }

    private function getCategorySetAd($params) {


        print_r($params);


        $category = new Model_Plant_Category_ContainerAd();
        //add validate!!!
        $category->setId(isset($params->param->id) && $params->param->id > 0 ? $params->param->id : 0 );
        $category->setName($params->param->name);
        $category->setDescription($params->param->description);
        
        $gallery = new Model_Gallery_Container();
        $gallery->setId($params->param->gallery);
        $category->setGallery($gallery);
                
        //$category->setUrl($params->param->url);
        $category->setIcon($params->param->icon);
        $category->setStatus($params->param->status);
        $category->setUserCreateId(1);
        $this->out['ajax'] = array('res' => 1, 'res' => $this->api->getCategorySetAd($category));


        print_r($category);
    }

    /*private function getCategoryAddAd($params) {
        print_r($params);


        $category = new Model_Plant_Category_ContainerAd();
        //add validate!!!
        // $category->setId(isset($params->param->id) && $params->param->id > 0 ? $params->param->id : 0 );
        $category->setName($params->param->name);
        $category->setDescription($params->param->description);
        $category->setUrl($params->param->url);
        $category->setIcon($params->param->icon);
        $category->setStatus($params->param->status);
        $category->setUserCreateId(1);
        $this->out['ajax'] = array('res' => $this->api->getCategoryAddAd($category));


        print_r($category);
    }*/

    /* plant */

    private function getPlantListAd($params) {

        //@todo do params
        $this->out['ajax'] = array('res' => 1, 'rows' => $this->api->getPlantListAd($pack = 1, $sizePack = 20, $sort = Model_Api_Abstract::SORT_NAME, $order = Model_Api_Abstract::ORDER_ASC));
    }

    private function getPlantByIdAd($params) {
        //@todo do params  
        $categoryList = $this->api->getCategoryList($pack = 1, $sizePack = 20, $sort = Model_Api_Abstract::SORT_NAME, $order = Model_Api_Abstract::ORDER_ASC);

        $plant = $this->api->getPlantByIdAd($params->param->id);
        $category = $categoryList->search('id', $plant->getCategory()->getId());

        if ($category instanceof Model_Plant_Category_ContainerAd) {
            $plant->setCategory($category);
        }

        $this->out['ajax'] = array('res' => 1, 'rows' => $plant, 'categories' => $categoryList);
    }

    private function getPlantSetAd($params) {
        //print_r($params);
        //add validate!!!
        $plant = new Model_Plant_ContainerAd();
        $plant->setId($params->param->id);
        $plant->setIsnNo($params->param->isnno);        
        
        $category = new Model_Plant_Category_Container();
        $category->setId($params->param->category->id);        
        $plant->setCategory($category);
        
        $gallery = new Model_Gallery_Container();
        $gallery->setId($params->param->gallery);
        $plant->setGallery($gallery);
        
        $pot = new Model_Plant_Pot_Container();
        $pot->setId($params->param->pot);
        $plant->setPot($pot);
        
        $plant->setName($params->param->name);
        $plant->setNameLT($params->param->namelt);
        $plant->setDescription($params->param->description);
        $plant->setHeight($params->param->height);
        $plant->setIcon($params->param->icon);
        $plant->setPrice($params->param->price);
        
        $plant->setStatus($params->param->status);
        $plant->setUserCreateId(1);
        
        //print_r($plant);
        $this->out['ajax'] = array('res' => 1, 'res' => $this->api->getPlantSetAd($plant));


        
    }
    
    private function getPotListAd($params) {

        //@todo do params
        $this->out['ajax'] = array('res' => 1, 'rows' => $this->api->getPotListAd($pack = 1, $sizePack = 20, $sort = Model_Api_Abstract::SORT_NAME, $order = Model_Api_Abstract::ORDER_ASC));
    }
    
     private function getPotByIdAd($params) {        
        $pot = $this->api->getPotByIdAd($params->param->id);
        $this->out['ajax'] = array('res' => 1, 'rows' => $pot);
    }
    
     private function getPotSetAd($params) {

        print_r($params);

        $pot = new Model_Plant_Pot_ContainerAd();
        //add validate!!!
        $pot->setId(isset($params->param->id) && $params->param->id > 0 ? $params->param->id : 0 );
        $pot->setName($params->param->name);
        $pot->setDescription($params->param->description);        
                
        $pot->setColor($params->param->color);
        $pot->setHeight($params->param->height);
        $pot->setDiameter($params->param->diameter);
         
        $pot->setStatus($params->param->status);
        $pot->setUserCreateId(1);
        
        print_r($pot);
        $this->out['ajax'] = array('res' => 1, 'res' => $this->api->getPotSetAd($pot));        
    }
    
    private function getStuffListAd($params) {
          //print_r($params);
        //@todo do params
        $this->out['ajax'] = array('res' => 1, 'rows' => $this->api->getStuffListAd($params->type, $pack = 1, $sizePack = 20, $sort = Model_Api_Abstract::SORT_NAME, $order = Model_Api_Abstract::ORDER_ASC));
    }
    
     private function getStuffByIdAd($params) {        
        $stuff = $this->api->getStuffByIdAd($params->param->id);
        $this->out['ajax'] = array('res' => 1, 'rows' => $stuff);
    }
    
     private function getStuffSetAd($params) {

        print_r($params);

        $stuff = new Model_Stuff_ContainerAd();
        //add validate!!!
        $stuff->setId(isset($params->param->id) && $params->param->id > 0 ? $params->param->id : 0 );
        $stuff->setName($params->param->name);
        $stuff->setDescription($params->param->description);        
                
        $stuff->setType($params->param->type);
        
         
        $stuff->setStatus($params->param->status);
        $stuff->setUserCreateId(1);
        
        print_r($stuff);
        $this->out['ajax'] = array('res' => 1, 'res' => $this->api->getStuffSetAd($stuff));

        
    }

}

//https://www.codeofaninja.com/2015/12/angularjs-crud-example-php.html
//http://blog.brunoscopelliti.com/building-a-restful-web-service-with-angularjs-and-php-more-power-with-resource/

//http://framework.zend.com/manual/1.12/en/zend.pdf.pages.html