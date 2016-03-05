<?php

class Offer_Module_Index extends Module_Abstract {

    function execute() {
        try {

            $api = new Model_Plant_Source_Api(Model_Plant_Source_Factory::FILE_CSV);
            $this->out['list'] = $api->getMixPlant();
        } catch (Model_Exception_NotFound $e) {
            throw new Manager_Exception_NotFound();
        } catch (Exception $e) {
            throw new Manager_Exception_Unavailable();
        }
        $this->template = 'offer/view/list.phtml';
        parent::execute();
    }

}
