<?php

if ($this instanceof Manager_Controller) {
    $this->config('common/config/basic');
    $this->storage->scripts->setCss('/css/gallery.css');
    $this->storage->pageId = 'gallery-page';

    $link = new Model_Link_Container();
    $link->setTitle('Galeria kwiatów');
    $this->storage->breadcrumbs->set(1, $link);
    $this->storage->metatags->setTitle('Galeria - ');
    $this->storage->metatags->setDescription('Galeria z ogrodu.', 'append');
    $this->storage->metatags->setKeywords('zdjęcia, w wolnej chwili,');

    //$this->config('offer/config/nav');

    $event = new Manager_Event();
    $event->setName('fluid')->setClass('Gallery_Module_List');
    $this->add($event);

    
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla strony listy galerii');
}