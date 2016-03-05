<?php

abstract class Module_Abstract implements Module_Interface {

    private $view;
    protected $out, $in, $request, $priv, $storage, $template;

    public function __construct(Manager_Storage $storage) {
        $this->view = new Manager_View();
        $this->request = Manager_Request::getInstance();
        $this->out = array();
        $this->storage = $storage;
    }

    public function setOut($out) {
        $this->out = $out;
        return $this;
    }

    public function setIn($in) {
        $this->in = $in;
        return $this;
    }

    public function setTemplate($template) {
        $this->template = $template;
        return $this;
    }

    public function render() {
        $this->view->render($this->template);
    }
    
    public function flusher() {
       return $this->view->flusher();
     }

    public function execute() {
        $this->request = null;
        $this->in = null;
        $this->storage = null;
        $this->view->assign($this->out);
        $this->out = null;
    }

}
