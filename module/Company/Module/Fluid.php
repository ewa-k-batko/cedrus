<?php
class Company_Module_Fluid extends Module_Abstract {
    function execute() {
                $this->template = 'Company/View/Fluid.phtml';
        parent::execute();
    }
}
