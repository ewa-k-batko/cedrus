<?php

class Manager_Helper_Scripts {

    const SLOT_HEAD = 'head';
    const SLOT_FOOT = 'foot';

    private $js, $css, $jquery;    
    
    public function setCss($css) {
        $this->css[] = $css;
    }

    public function loadCss() {
        if(!$this->css){
           return; 
        }
        $scripts = "\n";
        foreach ($this->css as $item) {
            $scripts .= "\n" . '<link href="' . $item . '" rel="stylesheet">';
        }
        return $scripts . "\n";
    }

    public function setJs($js, $place = self::SLOT_HEAD, $async = false) {
        $this->js[$place][] = array('file' => $js, 'async' => (bool) $async);
    }

    public function loadJs($place = self::SLOT_HEAD) {
        if(!isset($this->js[$place])){
           return; 
        }
        
        $scripts = "\n";
        foreach ($this->js[$place] as $item) {
            $async = $item['async'] ? ' async="async"' : null;
            $scripts .= "\n" . '<script' . $async . ' src="' . $item['file'] . '"></script>';
        }
        return $scripts . "\n";
    }
    
    public function setJQuery() {
        $this->jquery = true;
    }
    
    public function isJQuery() {
        return $this->jquery ? true : false;
    }

}
