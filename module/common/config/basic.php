<?php

if ($this instanceof Manager_Controller) {

    $this->layout = 'common/view/layout.phtml';
    self::$orderEvent = array('init', 'fluid', 'main', 'aside', 'brand', 'header', 'nav', 'footer');

    $this->storage->metatags->setTitle('Mirage - szkółka ogrodnicza');
    $this->storage->metatags->setDescription('Zajmujemy się produkcją i sprzedażą drzew i krzewów ozdobnych.');
    $this->storage->metatags->setKeywords('szkółka,mirage,ogrodniczy,sprzedaż,produkcja,drzewo,krzew,krzew ozdobny,drzewo ozdobne,ogród,sadzonka,sklep,hurtownia');

    $this->storage->scripts->setCss('/css/basic.css');


    /* $this->storage->scripts->setCss('/css/old/normalize.css');
      $this->storage->scripts->setCss('/css/old/grid.css');
      $this->storage->scripts->setCss('/css/old/theme.css');
     */

    $this->storage->scripts->setJs(Manager_Config::istatUrl() . 'js/modernizr.js', Manager_Helper_Scripts::SLOT_HEAD);
    $this->storage->scripts->setJs(Manager_Config::istatUrl() . 'js/jquery/jquery-1.11.2.min.js', Manager_Helper_Scripts::SLOT_FOOT);  
    $this->storage->scripts->setJs(Manager_Config::istatUrl() . 'js/jquery/jquery.cookie.js', Manager_Helper_Scripts::SLOT_FOOT);  
    
    $this->storage->scripts->setJQuery();

    $link = new Model_Link_Container();
    $link->setTitle('Mirage')->setUrl('/');
    $this->storage->breadcrumbs->set(0, (new Model_Link_Container())->setTitle('Mirage')->setUrl('/'));

    /**
     * navigation start
     */
    $nav = new Model_Collection();
    $link = new Model_Link_Container();
    $link->setUrl('/')->setTitle('O firmie')->setClass('front-page');
    $nav->append($link);
    $link = new Model_Link_Container();
    $link->setUrl('/oferta')->setTitle('Oferta')->setClass('offer-page');
    $nav->append($link);
    $link = new Model_Link_Container();
    $link->setUrl('/kontakt')->setTitle('Kontakt')->setClass('contact-page');
    $nav->append($link);
    $link = new Model_Link_Container();
    $link->setUrl('/galeria-kwiatow')->setTitle('Galeria ')->setClass('gallery-page');
    $nav->append($link);
    /**
     * navigation end
     */
    $event = new Manager_Event();
    $event->setName('brand')->setClass('Module_Module')->setTemplate('common/view/brand.phtml');
    $this->add($event);

    $event = new Manager_Event();
    $event->setName('header')->setClass('Module_Module')->setTemplate('common/view/header.phtml')
            ->setOut(array('title' => 'Strona domowa szkółki'));
    $this->add($event);

    $event = new Manager_Event();
    $event->setName('nav')->setClass('Common_Module_Nav')->setTemplate('common/view/nav.phtml')
            ->setOut(array('title' => 'nawigacja serwisu',
                'cssClass' => 'main-service-nav',
                'list' => $nav));
    $this->add($event);
    $event = new Manager_Event();
    $event->setName('footer')->setClass('Module_Module')->setTemplate('common/view/footer.phtml');
    $this->add($event);
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla podtawowych elementow strony');
}