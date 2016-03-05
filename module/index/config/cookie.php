<?php

if ($this instanceof Manager_Controller) {
    $this->config('common/config/basic');
    $this->storage->scripts->setCss('/css/cookie.css');
    $this->storage->pageId = 'cookie-policy-page';
    $this->storage->metatags->setTitle('Polityka cookie - ');
    $this->storage->metatags->setDescription('Informacje o polityce cookie.');
    $this->storage->metatags->setKeywords('polityka cookie, cookie,');
    $link = new Model_Link_Container();
    $link->setTitle('Polityka cookie')->setRoot();
    $this->storage->breadcrumbs->set(1, $link);

    $event = new Manager_Event();
    $event->setName('main')->setClass('Module_Module')->setTemplate('index/view/cookie.phtml');
    $this->add($event);
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla strony głównej');
}
