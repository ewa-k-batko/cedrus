<?php
class Index_Module_Fluid extends Module_Abstract {
    function execute() {
                $this->template = 'index/view/fluid.phtml';
        parent::execute();
    }
}
