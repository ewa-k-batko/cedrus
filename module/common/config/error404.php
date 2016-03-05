<?php

if ($this instanceof Manager_Controller) {
    $this->config('common/config/basic');
    $this->storage->metatags->setTitle('Strona o podanym adresie  nie istnieje', false);
    $this->storage->metatags->setDescription('Strona o podanym adresie  nie istnieje.', false);
    $this->storage->metatags->setKeywords('stroan nie istnieje', false);
    $event = new Manager_Event();
    $event->setName('init')->setClass('Manager_Response')->setIn(array('response_code' => 404));
    $this->add($event);
    $event = new Manager_Event();
    $event->setName('fluid')->setClass('Module_Module')->setTemplate('common/view/error.phtml')->setOut(array('code' => 404));
    $this->add($event);
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla strony błędu 404');
}