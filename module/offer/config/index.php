<?php

class Module_Offer_Config_Index extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->config(new Module_Common_Config_Basic());

        $storage = $mac->getStorage();
        $storage->scripts->setCss('/css/offer.css');
        $storage->pageId = 'offer-page';

        $link = new Model_Link_Container();
        $link->setTitle('Oferta');
        $storage->breadcrumbs->set(1, $link);
        $storage->metatags->setTitle('Katalog z ofertą');
        $storage->metatags->setDescription('Katalog drzew i krzewów ozdobnych.', 'append');
        $storage->metatags->setKeywords('katalog, oferta, produkty,');

        $mac->config(new Module_Offer_Config_Nav());

        $event = new Manager_Event();
        $event->setName('main')->setClass('Offer_Module_Index');
        $mac->add($event);

        $event = new Manager_Event();
        $event->setName('aside')->setClass('Offer_Module_Nav')->setTemplate('Offer/View/Aside.phtml')
                ->setOut(array('title' => 'nawigacja katalogu z ofertą',
                    'cssClass' => 'offer-nav-list'));
        $mac->add($event);
        $mac->setStorage($storage);
    }

}
