<?php

if ($this instanceof Manager_Controller) {
    $this->config('common/config/basic');
    $this->storage->scripts->setCss('/css/offer.css');

    $this->storage->pageId = 'offer-plant-page';

    //$link = new Model_Link_Container();
    //$link->setTitle('Oferta');
    //$this->storage->breadcrumbs->set(1, $link);

    $this->storage->metatags->setTitle('Katalog z ofertą');
    $this->storage->metatags->setDescription('Katalog drzew i krzewów ozdobnych.');
    $this->storage->metatags->setKeywords('katalog, oferta, produkty');

    $this->config('offer/config/nav');

    $event = new Manager_Event();
    $event->setName('main')->setClass('Offer_Module_Single');
    $this->add($event);

    $event = new Manager_Event();
    $event->setName('aside')->setClass('Offer_Module_Nav')->setTemplate('offer/view/aside.phtml')
            ->setOut(array('title' => 'nawigacja katalogu z ofertą',
                'cssClass' => 'offer-nav-list'));
    $this->add($event);
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla strony oferty');
}