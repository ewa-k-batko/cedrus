<?php

class Module_Formsan_Config_Basic extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->setLayout('Formsan/View/Common/Layout.phtml');
        $mac->setOrderEvent(array('init', 'fluid', 'header', 'nav', 'footer'));

        $storage = $mac->getStorage();



        $storage->metatags->setTitle('Mirage - szkółka ogrodnicza - forms');
        // $storage->metatags->setDescription('Zajmujemy się produkcją i sprzedażą drzew i krzewów ozdobnych.');
        // $storage->metatags->setKeywords('szkółka,mirage,ogrodniczy,sprzedaż,produkcja,drzewo,krzew,krzew ozdobny,drzewo ozdobne,ogród,sadzonka,sklep,hurtownia');
        //$storage->scripts->setCss('/css/basic.css');
        $storage->scripts->setCss('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');


        /* $storage->scripts->setCss('/css/old/normalize.css');
          $storage->scripts->setCss('/css/old/grid.css');
          $storage->scripts->setCss('/css/old/theme.css');
         */


        $storage->scripts->setJs('//code.jquery.com/jquery-1.12.0.min.js', Manager_Helper_Scripts::SLOT_HEAD);

        $storage->scripts->setJs('https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js', Manager_Helper_Scripts::SLOT_HEAD);
        $storage->scripts->setJs('https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-route.min.js', Manager_Helper_Scripts::SLOT_HEAD);
        $storage->scripts->setJs('https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-sanitize.min.js', Manager_Helper_Scripts::SLOT_HEAD);

        //code.jquery.com/jquery-1.12.0.min.js
        $storage->scripts->setJs(Manager_Config::istatUrl() . 'js/modernizr.js', Manager_Helper_Scripts::SLOT_HEAD);
        //$storage->scripts->setJs(Manager_Config::istatUrl() . 'js/jquery/jquery-1.11.2.min.js', Manager_Helper_Scripts::SLOT_FOOT);  
        // $storage->scripts->setJs(Manager_Config::istatUrl() . 'js/jquery/jquery.cookie.js', Manager_Helper_Scripts::SLOT_FOOT);  

        $storage->scripts->setJQuery();

        $link = new Model_Link_Container();
        $link->setTitle('Mirage')->setUrl('/');
        $storage->breadcrumbs->set(0, (new Model_Link_Container())->setTitle('Strona główna formatki')->setUrl('/'));

        /**
         * navigation start
         */
        $nav = new Model_Collection();
        $link = new Model_Link_Container();
        $link->setUrl('/formsan#')->setTitle('Lista')->setClass('list-page');
        $nav->append($link);
        $link = new Model_Link_Container();
        $link->setUrl('/formsan#category')->setTitle('Kategoria')->setClass('category-page');
        $nav->append($link);

        $link = new Model_Link_Container();
        $link->setUrl('/formsan#plant')->setTitle('Roślina')->setClass('plant-page');
        $nav->append($link);
        
        $link = new Model_Link_Container();
        $link->setUrl('/formsan#pot')->setTitle('Doniczka')->setClass('pot-page');
        $nav->append($link);

        $link = new Model_Link_Container();
        $link->setUrl('/formsan#param')->setTitle('Parametry')->setClass('param-page');
        $nav->append($link);
        
        $link = new Model_Link_Container();
        $link->setUrl('/formsan#gallery')->setTitle('Galeria')->setClass('gallery-page');
        $nav->append($link);

        $link = new Model_Link_Container();
        $link->setUrl('/formsan/pdf/')->setTitle('Pdf')->setClass('pdf-page');
        $nav->append($link);

        /**
         * navigation end
         */
        $event = new Manager_Event();
        $event->setName('header')->setClass('Module_Module')->setTemplate('Formsan/View/Common/Header.phtml')
                ->setOut(array('title' => 'Forms szkółki'));
        $mac->add($event);

        $event = new Manager_Event();
        $event->setName('nav')->setClass('Common_Module_Nav')->setTemplate('Formsan/View/Common/Nav.phtml')
                ->setOut(array('title' => 'nawigacja serwisu',
                    'cssClass' => 'main-service-nav',
                    'list' => $nav));
        $mac->add($event);
        $event = new Manager_Event();
        $event->setName('footer')->setClass('Module_Module')->setTemplate('Formsan/View/Common/Footer.phtml');
        $mac->add($event);
        $mac->setStorage($storage);
    }

}
