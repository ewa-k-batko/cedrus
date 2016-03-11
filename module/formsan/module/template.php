<?php

class Formsan_Module_Template extends Module_Abstract {

    function execute() {

        //csrf zawsze jest
       // $token = $this->request->post('token', 'strict');
        
        $this->in['s'] = $this->request->get('s');

        switch ($this->in['s']) {
            
            default;
            case 'list':                
               $this->template = 'Formsan/View/Content.phtml';
                break;

        }
        // $this->out['template'] = 'list.phtml';
        
        parent::execute();
    }

}
