<?php

class Module_Company_Config_Index extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->config(new Module_Common_Config_Basic());
        
        $storage = $mac->getStorage();
        $storage->scripts->setCss('/css/index.css');
        $storage->pageId = 'company-page';
        $storage->metatags->setTitle('O firmie ');
        $storage->metatags->setDescription('O firmie');
        $storage->metatags->setKeywords('firma');
        $link = new Model_Link_Container();
        $link->setTitle('O firmie');
      
        $storage->breadcrumbs->set(1, $link);


        $event = new Manager_Event();
        $event->setName('fluid')->setClass('Company_Module_Fluid');
        $mac->add($event);
        $mac->setStorage($storage);
    }

}
