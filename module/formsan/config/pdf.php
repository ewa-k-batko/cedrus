<?php

if ($this instanceof Manager_Controller) {
    $this->config('formsan/config/basic');
    //$this->storage->scripts->setCss('/css/contact.css');

    $this->storage->pageId = 'forms-page';
    $link = new Model_Link_Container();
    $link->setTitle('Formatka');
    //$this->storage->breadcrumbs->set(1, $link);
    //$this->storage->metatags->setTitle('Formularz kontaktowy - ');
    //$this->storage->metatags->setDescription('Kontakt z nami.', 'append');
    //$event = new Manager_Event();
    //$event->setName('main')->setClass('Contact_Module_Main');
    
   
    
    
   $event = new Manager_Event();
    $event->setName('fluid')->setClass('Formsan_Module_Pdf')->setIn(array());
    
    
    
    $this->add($event);
    
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla strony kontaktu');
}