<?php

/**
 * Class Manager_View
 */
class Manager_View {

    /**
     * @var
     */
    private $data, $flush;
    
    public function __construct() {
        $this->flush = array();
    }

    /**
     * @param $array
     * @return $this
     */
    public function assign($array) {
        foreach ($array as $name => $value) {
            $this->data[$name] = $value;
        }
        return $this;
    }

    /**
     * @param $template
     */
    public function render($template) {
        include Manager_Config::ROOT_PATH . Manager_Config::DIR_VIEW . $template;
        $this->data = null;
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name) {
        if ($this->exists($name)) {
            return $this->data[$name];
        } else {
            return null;
        }
    }

    /**
     * @param $template
     * @param $params
     */
    public function partial($template, $params = array()) {
        $this->assign($params);
        include Manager_Config::ROOT_PATH . Manager_Config::DIR_VIEW . $template;
    }

    public function ob() {
        ob_start();
    }

    public function clean() {
        $this->flush[] = ob_get_contents();
        ob_get_clean();
    }

    public function flusher() {
        $tmp = implode("\n", $this->flush);
        $this->flush = null;
        return $tmp;
    }

    /**
     * @param $name
     * @return bool
     */
    private function exists($name) {
        if (isset($this->data[$name])) {
            return true;
        }
        return false;
    }

}
