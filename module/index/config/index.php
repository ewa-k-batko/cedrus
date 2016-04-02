<?php

class Module_Index_Config_Index extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->config(new Module_Common_Config_Basic());
        
        $storage = $mac->getStorage();
        $storage->scripts->setCss('/css/index.css');
        $storage->scripts->setCss('/css/offer.css');
        $storage->scripts->setCss('/css/contact.css');
        $storage->pageId = 'front-page';
        $storage->metatags->setTitle('Firma o swojej działalności - ');
        $storage->metatags->setDescription('Startuj z nami');
        $storage->metatags->setKeywords('firma');
        $link = new Model_Link_Container();
        $link->setTitle('Mirage - szkółka ogrodnicza')->setRoot();
        $storage->breadcrumbs->set(0, $link);


        $event = new Manager_Event();
        $event->setName('fluid')->setClass('Index_Module_Index');
        $mac->add($event);
        $mac->setStorage($storage);
    }

}
