<?php

if ($this instanceof Manager_Controller) {
    $this->layout = 'common/view/layout-ajax.phtml';
    self::$orderEvent = array('ajax');


    $event = new Manager_Event();
    $event->setName('ajax')->setClass('Contact_Module_Send')->setIn(array('from' => 'serwer1413186@szkolka-cedrus.pl',
                                                                          'to' => 'rena.sonko@interia.pl',
                                                                          'host' => 'serwer1413186.home.pl', 
                                                                          'username' => 'serwer1413186',
                                                                          'password' => 'sylwia93cedr',
                                                                           'port' => 25));
    $this->add($event);

} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla strony kontaktu');
}