<?php

class Module_Formsan_Config_Template extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->config(new Module_Formsan_Config_Basic());


        //$_SERVER['APPLICATION_ENV'] = 'production';
        //$this->layout = 'formsan/view/common/template.phtml';
        $mac->setLayout('Formsan/View/Common/Template.phtml');
        $mac->setOrderEvent(array('ajax'));

        $event = new Manager_Event();
        $event->setName('ajax')->setClass('Formsan_Module_Template');
        $mac->add($event);
    }

}
