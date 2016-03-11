<?php
class Index_Module_Fluid extends Module_Abstract {
    function execute() {
                $this->template = 'Index/View/Fluid.phtml';
        parent::execute();
    }
}
