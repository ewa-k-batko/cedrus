<?php

if ($this instanceof Manager_Controller) {
    $this->config('common/config/basic');

    $this->storage->pageId = 'contact-page-send';
    $link = new Model_Link_Container();
    $link->setTitle('Kontakt - wysyłanie wiadomości');
    $this->storage->breadcrumbs->set(1, $link);
    $this->storage->metatags->setTitle('Formularz kontaktowy - ');
    $this->storage->metatags->setDescription('Kontakt z nami.', 'append');
    $event = new Manager_Event();
    $event->setName('main')->setClass('Contact_Module_Send')->setIn(array('from' => 'serwer1413186@szkolka-cedrus.pl', 
                                                                          'to' => 'rena.sonko@interia.pl',
                                                                          'host' => 'serwer1413186.home.pl', 
                                                                          'username' => 'serwer1413186',
                                                                          'password' => 'sylwia93cedr',
                                                                           'port' => 25));
    $this->add($event);
    $event = new Manager_Event();
    $event->setName('aside')->setClass('Module_Module')->setTemplate('contact/view/aside.phtml');
    $this->add($event);
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla strony kontaktu');
}