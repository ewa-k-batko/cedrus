<?php

class Formsan_Module_Main extends Module_Abstract {

    function execute() {

        //csrf zawsze jest
       // $token = $this->request->post('token', 'strict');
        
        //$api = new Model_Plant_Source_Api(Model_Plant_Source_Factory::DB_MYSQL);
       // $this->out['plant'] = $api->getCategoryList();
//print_r($this->out['plant']);

        //@todo  ajax
        $this->template = 'formsan/view/main.phtml';
        parent::execute();
    }

}
