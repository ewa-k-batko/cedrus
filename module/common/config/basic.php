<?php

class Module_Common_Config_Basic extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->setLayout('Common/View/Layout.phtml');
        $mac->setOrderEvent(array('init', 'fluid', 'main', 'aside', 'brand', 'header', 'nav', 'footer'));
        
        $storage = $mac->getStorage();

        $storage->metatags->setTitle('Mirage - szkółka ogrodnicza');
        $storage->metatags->setDescription('Zajmujemy się produkcją i sprzedażą drzew i krzewów ozdobnych.');
        $storage->metatags->setKeywords('szkółka,mirage,ogrodniczy,sprzedaż,produkcja,drzewo,krzew,krzew ozdobny,drzewo ozdobne,ogród,sadzonka,sklep,hurtownia');

        $storage->scripts->setCss('/css/basic.css');


        /* $storage->scripts->setCss('/css/old/normalize.css');
          $storage->scripts->setCss('/css/old/grid.css');
          $storage->scripts->setCss('/css/old/theme.css');
         */

        $storage->scripts->setJs(Manager_Config::istatUrl() . 'js/modernizr.js', Manager_Helper_Scripts::SLOT_HEAD);
        $storage->scripts->setJs(Manager_Config::istatUrl() . 'js/jquery/jquery-1.11.2.min.js', Manager_Helper_Scripts::SLOT_FOOT);
        $storage->scripts->setJs(Manager_Config::istatUrl() . 'js/jquery/jquery.cookie.js', Manager_Helper_Scripts::SLOT_FOOT);

        $storage->scripts->setJQuery();

        $link = new Model_Link_Container();
        $link->setTitle('Mirage')->setUrl('/');
        $storage->breadcrumbs->set(0, (new Model_Link_Container())->setTitle('Mirage')->setUrl('/'));

        /**
         * navigation start
         */
        $nav = new Model_Collection();
        $link = new Model_Link_Container();
        $link->setUrl('/')->setTitle('Start')->setClass('front-page');
        $nav->append($link);
        
        $link = new Model_Link_Container();
        $link->setUrl('/oferta')->setTitle('Oferta')->setClass('offer-page');
        $nav->append($link);
        $link = new Model_Link_Container();
        $link->setUrl('/ofirmie')->setTitle('O firmie')->setClass('front-page');
        $nav->append($link);
        $link = new Model_Link_Container();
        $link->setUrl('/kontakt')->setTitle('Kontakt')->setClass('contact-page');
        $nav->append($link);
       /* $link = new Model_Link_Container();
        $link->setUrl('/galeria-kwiatow')->setTitle('Galeria ')->setClass('gallery-page');
        $nav->append($link);*/
        /**
         * navigation end
         */
        $event = new Manager_Event();
        $event->setName('brand')->setClass('Module_Module')->setTemplate('Common/View/Brand.phtml');
        $mac->add($event);

        $event = new Manager_Event();
        $event->setName('header')->setClass('Module_Module')->setTemplate('Common/View/Header.phtml')
                ->setOut(array('title' => 'Strona domowa szkółki'));
        $mac->add($event);

        $event = new Manager_Event();
        $event->setName('nav')->setClass('Common_Module_Nav')->setTemplate('Common/View/Nav.phtml')
                ->setOut(array('title' => 'nawigacja serwisu',
                    'cssClass' => 'main-service-nav',
                    'list' => $nav));
        $mac->add($event);
        $event = new Manager_Event();
        $event->setName('footer')->setClass('Module_Module')->setTemplate('Common/View/Footer.phtml');
        $mac->add($event);
        
        $mac->setStorage($storage);
    }

}
