<?php

/**
 * Class Manager_Storage
 */
class Manager_Storage
{

    /**
     * @var array
     */
    /**
     * @var array
     */
    private $data, $param;
    /**
     * @var
     */
    private static $instance;

    /**
     *
     */
    private function __construct()
    {
        $this->data = array('scripts' => '', 'metatags' => '', 'breadcrumbs' => '', 'pageId' => '');
        $this->scripts = new Manager_Helper_Scripts();
        $this->metatags = new Manager_Helper_Metatags();
        $this->breadcrumbs = new Manager_Helper_Breadcrumbs();
        $this->param = array();
    }

    /**
     * @return Manager_Storage
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if ($this->exists($name)) {
            $this->data[$name] = $value;
        }
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        if ($this->exists($name)) {
            return $this->data[$name];
        } else {
            return null;
        }
    }

    /**
     * @param $name
     * @return bool
     */
    private function exists($name)
    {
        if (isset($this->data[$name])) {
            return true;
        }
        return false;
    }

    /**
     * @param $name
     */
    public function del($name)
    {
        if ($this->exists($name)) {
            $this->data[$name] = null;
        }
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function setParam($name, $value)
    {
        $this->param[$name] = $value;
        return $this;
    }

    /**
     * @param $name
     * @return null
     */
    public function getParam($name)
    {
        return isset($this->param[$name]) ? $this->param[$name] : null;
    }

    /**
     * @param $name
     */
    public function delParam($name)
    {
        if (isset($this->param[$name])) {
            unset($this->param[$name]);
        }
    }

    /**
     *
     */
    public function reset()
    {
        $this->param = array();
    }

}
