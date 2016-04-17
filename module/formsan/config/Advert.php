<?php

class Module_Formsan_Config_Advert extends Module_Config {

    public function get(Manager_Controller $mac) {

       
        $mac->config(new Module_Formsan_Config_Basic());
        //$this->storage->scripts->setCss('/css/contact.css');
        // $this->storage->pageId = 'forms-page';


        $link = new Model_Link_Container();
        $link->setTitle('Formatka');
        //$this->storage->breadcrumbs->set(1, $link);
        //$this->storage->metatags->setTitle('Formularz kontaktowy - ');
        //$this->storage->metatags->setDescription('Kontakt z nami.', 'append');
        //$event = new Manager_Event();
        //$event->setName('main')->setClass('Contact_Module_Main');




        $event = new Manager_Event();
        $event->setName('fluid')->setClass('Formsan_Module_Advert')->setIn(array());



        $mac->add($event);
    }

}
