<?php
class Index_Module_Index extends Module_Abstract {
    function execute() {
        try {

            $api = new Model_Plant_Source_Api(Model_Plant_Source_Factory::DB_MYSQL);
            $this->out['list'] = $api->getPromotionPlantList(1,10);
        } catch (Model_Exception_NotFound $e) {
            throw new Manager_Exception_NotFound();
        } catch (Exception $e) {
            throw new Manager_Exception_Unavailable();
        }
        $this->template = 'Index/View/Index.phtml';
        parent::execute();
    }
}
