<?php

class Module_Contact_Config_Send extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->setLayout('Common/View/LayoutAjax.phtml');
        $mac->setOrderEvent(array('ajax'));

       // $mac->config(new Module_Common_Config_Basic());  ??


        $event = new Manager_Event();
        $event->setName('ajax')->setClass('Contact_Module_Send')->setIn(array('from' => 'serwer1413186@szkolka-cedrus.pl',
            'to' => 'rena.sonko@interia.pl',
            'host' => 'serwer1413186.home.pl',
            'username' => 'serwer1413186',
            'password' => 'sylwia93cedr',
            'port' => 25));
        $mac->add($event);
    }

}
