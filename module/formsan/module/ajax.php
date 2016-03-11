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

    private function getCategoryUpdateAd($params) {


        print_r($params);


        $category = new Model_Plant_Category_ContainerAd();
        //add validate!!!
        $category->setId(isset($params->param->id) && $params->param->id > 0 ? $params->param->id : 0 );
        $category->setName($params->param->name);
        $category->setDescription($params->param->description);
        $category->setUrl($params->param->url);
        $category->setIcon($params->param->icon);
        $category->setStatus($params->param->status);
        $category->setUserCreateId(1);
        $this->out['ajax'] = array('res' => 1, 'res' => $this->api->getCategoryUpdateAd($category));


        print_r($category);
    }

    private function getCategoryAddAd($params) {
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
    }

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
        
        $category = new Model_Plant_Category_Container();
        $category->setId($params->param->category->id);        
        $plant->setCategory($category);
        $plant->setName($params->param->name);
        $plant->setNameLT($params->param->namelt);
        $plant->setDescription($params->param->description);
        $plant->setUrl($params->param->url);
        $plant->setIcon($params->param->icon);
        $plant->setStatus($params->param->status);
        $plant->setUserCreateId(1);
        
        //print_r($plant);
        $this->out['ajax'] = array('res' => 1, 'res' => $this->api->getPlantSetAd($plant));


        
    }

}

//https://www.codeofaninja.com/2015/12/angularjs-crud-example-php.html
//http://blog.brunoscopelliti.com/building-a-restful-web-service-with-angularjs-and-php-more-power-with-resource/

//http://framework.zend.com/manual/1.12/en/zend.pdf.pages.html