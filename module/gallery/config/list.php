<?php

class Module_Gallery_Config_List extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->config(new Module_Common_Config_Basic());
        
        $storage = $mac->getStorage();
        $storage->scripts->setCss('/css/gallery.css');
        $storage->pageId = 'gallery-page';

        $link = new Model_Link_Container();
        $link->setTitle('Galeria kwiatów');
        $storage->breadcrumbs->set(1, $link);
        $storage->metatags->setTitle('Galeria - ');
        $storage->metatags->setDescription('Galeria z ogrodu.', 'append');
        $storage->metatags->setKeywords('zdjęcia, w wolnej chwili,');

        //$mac->config('offer/config/nav');

        $event = new Manager_Event();
        $event->setName('fluid')->setClass('Gallery_Module_List');
        $mac->add($event);

        $mac->setStorage($storage);
    }

}
