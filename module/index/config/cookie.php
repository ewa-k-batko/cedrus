<?php

class Module_Index_Config_Cookie extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->config(new Module_Common_Config_Basic());

        $storage = $mac->getStorage();
        $storage->scripts->setCss('/css/cookie.css');
        $storage->pageId = 'cookie-policy-page';
        $storage->metatags->setTitle('Polityka cookie - ');
        $storage->metatags->setDescription('Informacje o polityce cookie.');
        $storage->metatags->setKeywords('polityka cookie, cookie,');
        $link = new Model_Link_Container();
        $link->setTitle('Polityka cookie')->setRoot();
        $storage->breadcrumbs->set(1, $link);

        $event = new Manager_Event();
        $event->setName('main')->setClass('Module_Module')->setTemplate('index/view/cookie.phtml');
        $mac->add($event);
        $mac->setStorage($storage);
    }

}
