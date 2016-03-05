<?php

if ($this instanceof Manager_Controller) {

    $this->config('common/config/basic');

    $this->storage->metatags->setTitle('Strona chwilowo niedostępna. Prosimy spróbować ponownie.', false);
    $this->storage->metatags->setDescription('Strona chwilowo niedostępna', false);
    $this->storage->metatags->setKeywords('', false);
    
    $event = new Manager_Event();
    $event->setName('init')->setClass('Manager_Response')->setIn(array('response_code' => 503));
    $this->add($event);
    $event = new Manager_Event();
    $event->setName('fluid')->setClass('Module_Module')->setTemplate('common/view/error.phtml')->setOut(array('code' => 503));
    $this->add($event);
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla strony błędu 503');
}