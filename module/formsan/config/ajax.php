<?php
header("Expires: 0");
header("Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
header('Content-type: application/json; charset=utf-8');

if ($this instanceof Manager_Controller) {
    //$_SERVER['APPLICATION_ENV'] = 'production';
    $this->layout = 'formsan/view/common/layout-ajax.phtml';
    self::$orderEvent = array('ajax');

    $event = new Manager_Event();
    $event->setName('ajax')->setClass('Formsan_Module_Ajax');
    $this->add($event);
} else {
    throw new Manager_Config_Exception('błąd konfiguracji dla podtawowych elementow strony');
}