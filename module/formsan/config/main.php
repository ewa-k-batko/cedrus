<?php

class Module_Formsan_Config_Main extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->config(new Module_Formsan_Config_Basic());

        $storage = $mac->getStorage();

        $storage->pageId = 'forms-page';
        $link = new Model_Link_Container();
        $link->setTitle('Formatka');
        //$storage->breadcrumbs->set(1, $link);
        //$storage->metatags->setTitle('Formularz kontaktowy - ');
        //$storage->metatags->setDescription('Kontakt z nami.', 'append');
        //$event = new Manager_Event();
        //$event->setName('main')->setClass('Contact_Module_Main');

        $storage->scripts->setJs('/js/formsan/category.js', Manager_Helper_Scripts::SLOT_FOOT);

        $storage->scripts->setJs('/js/formsan/plant.js', Manager_Helper_Scripts::SLOT_FOOT);

        $storage->scripts->setJs('/js/formsan/main.js', Manager_Helper_Scripts::SLOT_FOOT);



        $event = new Manager_Event();
        $event->setName('fluid')->setClass('Formsan_Module_Main')->setIn(array());



        $mac->add($event);
        $mac->setStorage($storage);
    }

}
