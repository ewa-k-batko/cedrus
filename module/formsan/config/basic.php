<?php

if ($this instanceof Manager_Controller) {

    $this->layout = 'formsan/view/common/layout.phtml';
    self::$orderEvent = array('init', 'fluid', 'header', 'nav', 'footer');

    $this->storage->metatags->setTitle('Mirage - szkółka ogrodnicza - forms');
   // $this->storage->metatags->setDescription('Zajmujemy się produkcją i sprzedażą drzew i krzewów ozdobnych.');
   // $this->storage->metatags->setKeywords('szkółka,mirage,ogrodniczy,sprzedaż,produkcja,drzewo,krzew,krzew ozdobny,drzewo ozdobne,ogród,sadzonka,sklep,hurtownia');

    //$this->storage->scripts->setCss('/css/basic.css');
    $this->storage->scripts->setCss('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');


    /* $this->storage->scripts->setCss('/css/old/normalize.css');
      $this->storage->scripts->setCss('/css/old/grid.css');
      $this->storage->scripts->setCss('/css/old/theme.css');
     */
    
    
     $this->storage->scripts->setJs('//code.jquery.com/jquery-1.12.0.min.js', Manager_Helper_Scripts::SLOT_HEAD);
    
    $this->storage->scripts->setJs('https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js', Manager_Helper_Scripts::SLOT_HEAD);
    $this->storage->scripts->setJs('https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-route.min.js', Manager_Helper_Scripts::SLOT_HEAD);
   $this->storage->scripts->setJs('https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-sanitize.min.js', Manager_Helper_Scripts::SLOT_HEAD);
    
    //code.jquery.com/jquery-1.12.0.min.js
   $this->storage->scripts->setJs(Manager_Config::istatUrl() . 'js/modernizr.js', Manager_Helper_Scripts::SLOT_HEAD);
  //$this->storage->scripts->setJs(Manager_Config::istatUrl() . 'js/jquery/jquery-1.11.2.min.js', Manager_Helper_Scripts::SLOT_FOOT);  
   // $this->storage->scripts->setJs(Manager_Config::istatUrl() . 'js/jquery/jquery.cookie.js', Manager_Helper_Scripts::SLOT_FOOT);  
    
    $this->storage->scripts->setJQuery();

    $link = new Model_Link_Container();
    $link->setTitle('Mirage')->setUrl('/');
    $this->storage->breadcrumbs->set(0, (new Model_Link_Container())->setTitle('Strona główna formatki')->setUrl('/'));

    /**
     * navigation start
     */
    $nav = new Model_Collection();
    $link = new Model_Link_Container();
    $link->setUrl('/formsan#')->setTitle('Lista')->setClass('list-page');
    $nav->append($link);
    $link = new Model_Link_Container();
    $link->setUrl('/formsan#category')->setTitle('Kategorie')->setClass('category-page');
    $nav->append($link);
    
    $link = new Model_Link_Container();
    $link->setUrl('/formsan#plant')->setTitle('Rośliny')->setClass('plant-page');
    $nav->append($link);
    
     $link = new Model_Link_Container();
    $link->setUrl('/formsan#param')->setTitle('Parametry')->setClass('param-page');
    $nav->append($link);
    
     $link = new Model_Link_Container();
    $link->setUrl('/formsan/pdf')->setTitle('Pdf')->setClass('pdf-page');
    $nav->append($link);
    
    /**
     * navigation end
     */
   

    $event = new Manager_Event();
    $event->setName('header')->setClass('Module_Module')->setTemplate('formsan/view/common/header.phtml')
            ->setOut(array('title' => 'Forms szkółki'));
    $this->add($event);

    $event = new Manager_Event();
    $event->setName('nav')->setClass('Common_Module_Nav')->setTemplate('formsan/view/common/nav.phtml')
            ->setOut(array('title' => 'nawigacja serwisu',
                'cssClass' => 'main-service-nav',
                'list' => $nav));
    $this->add($event);
    $event = new Manager_Event();
    $event->setName('footer')->setClass('Module_Module')->setTemplate('formsan/view/common/footer.phtml');
    $this->add($event);
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla podtawowych elementow strony');
}