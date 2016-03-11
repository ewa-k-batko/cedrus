<?php

class Module_Contact_Config_Contact extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->config(new Module_Common_Config_Basic());

        $storage = $mac->getStorage();
        $storage->scripts->setCss('/css/contact.css');

        $storage->pageId = 'contact-page';
        $link = new Model_Link_Container();
        $link->setTitle('Kontakt');
        $storage->breadcrumbs->set(1, $link);
        $storage->metatags->setTitle('Formularz kontaktowy - ');
        $storage->metatags->setDescription('Kontakt z nami.', 'append');
        //$event = new Manager_Event();
        //$event->setName('main')->setClass('Contact_Module_Main');


        $event = new Manager_Event();
        $event->setName('main')->setClass('Contact_Module_Main')->setIn(array('from' => 'serwer1413186@szkolka-cedrus.pl',
            'to' => 'rena.sonko@interia.pl',
            'host' => 'serwer1413186.home.pl',
            'username' => 'serwer1413186',
            'password' => 'sylwia93cedr',
            'port' => 25));



        $mac->add($event);
        $event = new Manager_Event();
        $event->setName('aside')->setClass('Module_Module')->setTemplate('Contact/View/Aside.phtml');
        $mac->add($event);
        $mac->setStorage($storage);
    }

}
