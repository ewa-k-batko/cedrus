<?php

class Offer_Module_Nav extends Module_Abstract {

    function execute() {

        $this->out['list'] = $this->storage->getParam('list-nav');
        $this->storage->delParam('list-nav');
        
        if ($this->out['list'] instanceof Model_Collection) {
            try {
                $item = $this->out['list']->search('class', $this->storage->pageId);
                if ($item instanceof Model_Link_Container) {
                    $item->setActive($this->storage->pageId);
                }
            } catch (Exception $e) {
                
            }
        }
        parent::execute();
    }

}
