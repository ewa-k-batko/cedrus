<?php
class Common_Module_Nav extends Module_Abstract {
    function execute() {
        
        if ($this->out['list'] instanceof Model_Collection) {
            try {
                $item = $this->out['list']->search('class', $this->storage->pageId);
                if ($item instanceof Model_Link_Container) {
                    $item->setActive($this->storage->pageId);
                }
                
                $this->out['switchMenu'] = true;
            } catch (Exception $e) {
                
            }
        }
        parent::execute();
    }

}
