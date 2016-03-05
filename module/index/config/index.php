<?php

if ($this instanceof Manager_Controller) {
    $this->config('common/config/basic');
    $this->storage->scripts->setCss('/css/index.css');
    $this->storage->pageId = 'front-page';
    $this->storage->metatags->setTitle('Firma o swojej działalności - ');
    $this->storage->metatags->setDescription('Startuj z nami');
    $this->storage->metatags->setKeywords('firma');
    $link = new Model_Link_Container();
    $link->setTitle('Mirage - szkółka ogrodnicza')->setRoot();
    $this->storage->breadcrumbs->set(0, $link);
    
    
    $event = new Manager_Event();
    $event->setName('fluid')->setClass('Index_Module_Fluid');
    $this->add($event);
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla strony głównej');
}