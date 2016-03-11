<?php

header("Expires: 0");
header("Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
header('Content-type: application/json; charset=utf-8');

class Module_Formsan_Config_Ajax extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->setLayout('Formsan/View/Common/LayoutAjax.phtml');
        $mac->setOrderEvent(array('ajax'));


        //$_SERVER['APPLICATION_ENV'] = 'production';
        //$this->layout = 'formsan/view/common/layout-ajax.phtml';
        //self::$orderEvent = array('ajax');

        $event = new Manager_Event();
        $event->setName('ajax')->setClass('Formsan_Module_Ajax');
        $mac->add($event);
    }

}
