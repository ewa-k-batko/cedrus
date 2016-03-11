<?php

class Module_Common_Config_Error503 extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->config(new Module_Common_Config_Basic());

        $storage = $mac->getStorage();

        $storage->metatags->setTitle('Strona chwilowo niedostępna. Prosimy spróbować ponownie.', false);
        $storage->metatags->setDescription('Strona chwilowo niedostępna', false);
        $storage->metatags->setKeywords('', false);

        $event = new Manager_Event();
        $event->setName('init')->setClass('Manager_Response')->setIn(array('response_code' => 503));
        $mac->add($event);
        $event = new Manager_Event();
        $event->setName('fluid')->setClass('Module_Module')->setTemplate('Common/View/Error.phtml')->setOut(array('code' => 503));
        $mac->add($event);

        $mac->setStorage($storage);
    }

}
