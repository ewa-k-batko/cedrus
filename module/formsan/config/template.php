<?php
if ($this instanceof Manager_Controller) {
    $_SERVER['APPLICATION_ENV'] = 'production';
    $this->layout = 'formsan/view/common/template.phtml';
    self::$orderEvent = array('ajax'); 
    
    $event = new Manager_Event();
    $event->setName('ajax')->setClass('Formsan_Module_Template');
    $this->add($event);
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla podtawowych elementow strony');
}