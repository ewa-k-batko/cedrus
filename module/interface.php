<?php

interface Module_Interface {
    
    public function setOut($out);    
    public function setIn($in);
    public function setTemplate($template);
    public function execute();
}
